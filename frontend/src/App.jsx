import React, { useEffect, useState } from 'react';

const API_ORIGIN = (import.meta.env.VITE_API_URL || (import.meta.env.DEV ? 'http://localhost:3000' : window.location.origin)).replace(/\/+$/, '');
const API_URL = API_ORIGIN.endsWith('/index.php') ? API_ORIGIN : `${API_ORIGIN}/index.php`;
const TOKEN_KEY = 'product-system-tokens';
const LOGIN_PATH = '/login';
const PRODUCTS_PATH = '/products';

function getRouteFromPath(pathname = window.location.pathname) {
  if (pathname === PRODUCTS_PATH) {
    return 'products';
  }

  return 'login';
}

function navigateTo(path) {
  const nextPath = path.startsWith('/') ? path : `/${path}`;

  if (window.location.pathname !== nextPath) {
    window.history.pushState({}, '', nextPath);
  }

  return getRouteFromPath(nextPath);
}

function readTokens() {
  try {
    return JSON.parse(localStorage.getItem(TOKEN_KEY) || 'null');
  } catch {
    return null;
  }
}

function saveTokens(tokens) {
  localStorage.setItem(TOKEN_KEY, JSON.stringify(tokens));
}

function clearTokens() {
  localStorage.removeItem(TOKEN_KEY);
}

async function send(path, options = {}, retry = true) {
  const tokens = readTokens();
  const headers = new Headers(options.headers || {});

  if (options.body && !(options.body instanceof FormData)) {
    headers.set('Content-Type', 'application/json');
  }
  if (tokens?.access_token) {
    headers.set('Authorization', `Bearer ${tokens.access_token}`);
  }

  let response = await fetch(`${API_URL}${path}`, { ...options, headers });

  if (response.status === 401 && retry && tokens?.refresh_token && path !== '/api/auth/refresh') {
    const refreshResponse = await fetch(`${API_URL}/api/auth/refresh`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ refresh_token: tokens.refresh_token }),
    });
    const refreshed = await refreshResponse.json();

    if (refreshResponse.ok && refreshed.tokens) {
      saveTokens(refreshed.tokens);
      return send(path, options, false);
    }

    clearTokens();
  }

  const data = await response.json().catch(() => ({}));
  if (!response.ok) {
    throw new Error(data.error || data.message || `Request failed (${response.status}).`);
  }
  return data;
}

function ProductForm({ initial, onSave, onCancel, saving }) {
  const [form, setForm] = useState({
    product_name: initial?.product_name || '',
    description: initial?.description || '',
    price: initial?.price ?? '',
    quantity: initial?.quantity ?? '',
  });

  function update(event) {
    setForm((current) => ({ ...current, [event.target.name]: event.target.value }));
  }

  function submit(event) {
    event.preventDefault();
    onSave({
      ...form,
      price: Number(form.price),
      quantity: Number(form.quantity),
    });
  }

  return (
    <form className="product-form" onSubmit={submit}>
      <label>
        Product name
        <input name="product_name" value={form.product_name} onChange={update} maxLength="100" required />
      </label>
      <label>
        Description
        <textarea name="description" value={form.description} onChange={update} rows="3" />
      </label>
      <div className="form-row">
        <label>
          Price
          <input name="price" type="number" min="0" step="0.01" value={form.price} onChange={update} required />
        </label>
        <label>
          Quantity
          <input name="quantity" type="number" min="0" step="1" value={form.quantity} onChange={update} required />
        </label>
      </div>
      <div className="form-actions">
        <button className="button primary" disabled={saving}>{saving ? 'Saving…' : 'Save product'}</button>
        <button className="button quiet" type="button" onClick={onCancel}>Cancel</button>
      </div>
    </form>
  );
}

export default function App() {
  const [tokens, setTokenState] = useState(readTokens);
  const [user, setUser] = useState(null);
  const [products, setProducts] = useState([]);
  const [editing, setEditing] = useState(null);
  const [showForm, setShowForm] = useState(false);
  const [route, setRoute] = useState(() => getRouteFromPath());
  const [authMode, setAuthMode] = useState('login');
  const [authForm, setAuthForm] = useState({ username: '', email: '', password: '' });
  const [passwordVisible, setPasswordVisible] = useState(false);
  const [loading, setLoading] = useState(Boolean(tokens?.access_token));
  const [saving, setSaving] = useState(false);
  const [apiStatus, setApiStatus] = useState('checking');
  const [error, setError] = useState('');
  const [notice, setNotice] = useState('');
  const isAuthenticated = Boolean(tokens?.access_token);
  const shouldShowLogin = !isAuthenticated || window.location.pathname === LOGIN_PATH;

  useEffect(() => {
    const syncRoute = () => {
      const nextRoute = getRouteFromPath();
      setRoute(nextRoute);

      if (nextRoute === 'products' && !tokens?.access_token) {
        window.history.replaceState({}, '', LOGIN_PATH);
        setRoute('login');
      }

      if (nextRoute === 'login' && tokens?.access_token) {
        window.history.replaceState({}, '', PRODUCTS_PATH);
        setRoute('products');
      }
    };

    syncRoute();
    window.addEventListener('popstate', syncRoute);

    return () => window.removeEventListener('popstate', syncRoute);
  }, [tokens?.access_token]);

  useEffect(() => {
    let cancelled = false;
    let controller;
    let timeout;
    let retry;

    async function checkHealth(attempt = 0) {
      controller = new AbortController();
      timeout = window.setTimeout(() => controller.abort(), 30000);

      try {
        const response = await fetch(`${API_URL}/api/health`, { signal: controller.signal });
        if (!response.ok) {
          throw new Error(`API returned HTTP ${response.status}`);
        }

        const data = await response.json();
        if (!cancelled) {
          setApiStatus(data.status === 'ok' && data.database === 'connected' ? 'online' : 'offline');
        }
      } catch {
        if (cancelled) return;
        if (attempt < 2) {
          retry = window.setTimeout(() => checkHealth(attempt + 1), (attempt + 1) * 3000);
        } else {
          setApiStatus('offline');
        }
      } finally {
        window.clearTimeout(timeout);
      }
    }

    checkHealth();

    return () => {
      cancelled = true;
      controller.abort();
      window.clearTimeout(timeout);
      window.clearTimeout(retry);
    };
  }, []);

  async function loadProducts() {
    const data = await send('/api/products');
    setProducts(data.products || []);
  }

  useEffect(() => {
    if (!tokens?.access_token) {
      setLoading(false);
      return;
    }

    loadProducts()
      .catch((requestError) => {
        clearTokens();
        setTokenState(null);
        setError(requestError.message);
      })
      .finally(() => setLoading(false));
  }, []);

  async function authenticate(event) {
    event.preventDefault();
    setError('');
    setNotice('');
    setSaving(true);

    try {
      const data = await send(`/api/auth/${authMode}`, {
        method: 'POST',
        body: JSON.stringify(authForm),
      }, false);
      saveTokens(data.tokens);
      setTokenState(data.tokens);
      setUser(data.user);
      setRoute(navigateTo(PRODUCTS_PATH));
      await loadProducts();
    } catch (requestError) {
      setError(requestError.message);
    } finally {
      setSaving(false);
      setLoading(false);
    }
  }

  async function logout() {
    const currentTokens = readTokens();
    let logoutError = '';
    try {
      await send('/api/auth/logout', {
        method: 'POST',
        body: JSON.stringify({ refresh_token: currentTokens?.refresh_token || '' }),
      }, false);
    } catch (requestError) {
      logoutError = requestError.message;
    } finally {
      clearTokens();
      setTokenState(null);
      setUser(null);
      setProducts([]);
      setEditing(null);
      setShowForm(false);
      setAuthForm({ username: '', email: '', password: '' });
      setPasswordVisible(false);
      setAuthMode('login');
      setRoute(navigateTo(LOGIN_PATH));
      setNotice(logoutError
        ? `Signed out here, but server token revocation failed: ${logoutError}`
        : 'You have been logged out.');
    }
  }

  async function saveProduct(product) {
    setSaving(true);
    setError('');
    try {
      const path = editing ? `/api/products/${editing.id}` : '/api/products';
      await send(path, {
        method: editing ? 'PUT' : 'POST',
        body: JSON.stringify(product),
      });
      await loadProducts();
      setEditing(null);
      setShowForm(false);
      setNotice(editing ? 'Product updated.' : 'Product added.');
    } catch (requestError) {
      setError(requestError.message);
    } finally {
      setSaving(false);
    }
  }

  async function deleteProduct(product) {
    if (!window.confirm(`Delete "${product.product_name}"?`)) return;
    setError('');
    try {
      await send(`/api/products/${product.id}`, { method: 'DELETE' });
      setProducts((current) => current.filter((item) => item.id !== product.id));
      setNotice('Product deleted.');
    } catch (requestError) {
      setError(requestError.message);
    }
  }

  function changeAuthMode(mode) {
    setAuthMode(mode);
    setAuthForm({ username: '', email: '', password: '' });
    setPasswordVisible(false);
    setError('');
    setNotice('');
  }

  if (shouldShowLogin) {
    return (
      <main className="auth-page">
        <section className="auth-card">
          <div className="brand-mark">P</div>
          <p className="eyebrow">INVENTORY WORKSPACE</p>
          <h1>Welcome back</h1>
          <p className="muted">Sign in to manage your products and stock.</p>
          <ApiStatus status={apiStatus} />

          {error && <div className="alert error" role="alert">{error}</div>}
          {notice && <div className="alert success">{notice}</div>}

          <form className="auth-form" onSubmit={authenticate}>
            <label>
              Username
              <input
                value={authForm.username}
                onChange={(event) => setAuthForm({ ...authForm, username: event.target.value })}
                autoComplete="username"
                required
              />
            </label>
            <label>
              Password
              <span className="password-field">
                <input
                  type={passwordVisible ? 'text' : 'password'}
                  value={authForm.password}
                  onChange={(event) => setAuthForm({ ...authForm, password: event.target.value })}
                  autoComplete="current-password"
                  minLength="8"
                  required
                />
                <button
                  className="password-toggle"
                  type="button"
                  onClick={() => setPasswordVisible((visible) => !visible)}
                  aria-label={passwordVisible ? 'Hide password' : 'Show password'}
                  aria-pressed={passwordVisible}
                >
                  <svg viewBox="0 0 24 24" aria-hidden="true">
                    {passwordVisible ? (
                      <>
                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z" />
                        <circle cx="12" cy="12" r="3" />
                      </>
                    ) : (
                      <>
                        <path d="m3 3 18 18" />
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8" />
                        <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a16 16 0 0 1-3.1 3.8" />
                        <path d="M6.2 6.2C3.5 8 2 12 2 12s3.6 7 10 7a10 10 0 0 0 4-.8" />
                      </>
                    )}
                  </svg>
                </button>
              </span>
            </label>
            <button className="button primary full-width" disabled={saving}>
              {saving ? 'Please wait…' : 'Sign in'}
            </button>
          </form>
        </section>
      </main>
    );
  }

  return (
    <main className="app-shell">
      <header className="topbar">
        <a className="brand" href="/">
          <span className="brand-mark small">P</span>
          <span>Product<span className="brand-light">Desk</span></span>
        </a>
        <div className="account">
          <ApiStatus status={apiStatus} />
          {user?.username && <span className="account-name">{user.username}</span>}
          <button className="button quiet" onClick={logout}>Log out</button>
        </div>
      </header>

      <section className="content">
        <div className="page-heading">
          <div>
            <p className="eyebrow">INVENTORY</p>
            <h1>Products</h1>
            <p className="muted">Manage your products, prices, and available stock.</p>
          </div>
          <button
            className="button primary"
            onClick={() => {
              setEditing(null);
              setShowForm(true);
              setError('');
            }}
          >
            <span aria-hidden="true">＋</span> Add product
          </button>
        </div>

        {error && <div className="alert error" role="alert">{error}</div>}
        {notice && <div className="alert success">{notice}</div>}

        {(showForm || editing) && (
          <section className="panel form-panel">
            <div className="panel-heading">
              <div>
                <h2>{editing ? 'Edit product' : 'Add a product'}</h2>
                <p className="muted">Product details are saved to the API database.</p>
              </div>
            </div>
            <ProductForm
              key={editing?.id || 'new-product'}
              initial={editing}
              onSave={saveProduct}
              onCancel={() => {
                setEditing(null);
                setShowForm(false);
              }}
              saving={saving}
            />
          </section>
        )}

        <section className="panel">
          <div className="panel-heading">
            <div>
              <h2>Product list</h2>
              <p className="muted">{products.length} {products.length === 1 ? 'item' : 'items'}</p>
            </div>
          </div>
          {loading ? (
            <div className="empty-state">Loading products…</div>
          ) : products.length === 0 ? (
            <div className="empty-state">No products yet. Add your first product to get started.</div>
          ) : (
            <div className="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th><span className="sr-only">Actions</span></th>
                  </tr>
                </thead>
                <tbody>
                  {products.map((product) => (
                    <tr key={product.id}>
                      <td className="product-name">{product.product_name}</td>
                      <td className="description">{product.description || '—'}</td>
                      <td>${Number(product.price).toFixed(2)}</td>
                      <td><span className="quantity-badge">{product.quantity}</span></td>
                      <td>
                        <div className="row-actions">
                          <button
                            className="link-button"
                            onClick={() => {
                              setEditing(product);
                              setShowForm(false);
                              setError('');
                            }}
                          >
                            Edit
                          </button>
                          <button className="link-button danger-link" onClick={() => deleteProduct(product)}>
                            Delete
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </section>
        <footer>ProductDesk · LavaLust API</footer>
      </section>
    </main>
  );
}

function ApiStatus({ status }) {
  const label = {
    checking: 'Checking API…',
    online: 'API operational',
    offline: 'API unavailable',
  }[status];

  return (
    <div className={`api-status ${status}`} role="status" aria-live="polite">
      <span className="api-status-dot" aria-hidden="true" />
      {label}
    </div>
  );
}
