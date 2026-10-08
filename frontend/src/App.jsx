import React, { useEffect, useMemo, useState } from 'react';

const API_ORIGIN = (import.meta.env.VITE_API_URL || (import.meta.env.DEV ? 'http://localhost:3000' : 'https://carsocho-brian-lavalust.onrender.com')).replace(/\/+$/, '');
const API_URL = API_ORIGIN.endsWith('/index.php') ? API_ORIGIN : `${API_ORIGIN}/index.php`;
const TOKEN_KEY = 'product-system-tokens';
const currency = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' });

function normalizePath() {
  if (window.location.pathname !== '/') {
    window.history.replaceState({}, '', '/');
  }
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
  const [deleteTarget, setDeleteTarget] = useState(null);
  const [deleting, setDeleting] = useState(false);
  const [showForm, setShowForm] = useState(false);
  const [search, setSearch] = useState('');
  const [stockFilter, setStockFilter] = useState('all');
  const [sortBy, setSortBy] = useState('newest');
  const [refreshing, setRefreshing] = useState(false);
  const [authMode, setAuthMode] = useState('login');
  const [authForm, setAuthForm] = useState({ username: '', email: '', password: '' });
  const [passwordVisible, setPasswordVisible] = useState(false);
  const [loading, setLoading] = useState(Boolean(tokens?.access_token));
  const [saving, setSaving] = useState(false);
  const [apiStatus, setApiStatus] = useState('checking');
  const [error, setError] = useState('');
  const [notice, setNotice] = useState('');
  const isAuthenticated = Boolean(tokens?.access_token);
  const shouldShowLogin = !isAuthenticated;
  const visibleProducts = useMemo(() => {
    const query = search.trim().toLocaleLowerCase();
    return products
      .filter((product) => {
        const matchesSearch = !query
          || `${product.product_name || ''} ${product.description || ''}`.toLocaleLowerCase().includes(query);
        const quantity = Number(product.quantity) || 0;
        const matchesStock = stockFilter === 'all'
          || (stockFilter === 'in-stock' && quantity > 5)
          || (stockFilter === 'low-stock' && quantity > 0 && quantity <= 5)
          || (stockFilter === 'out-of-stock' && quantity === 0);
        return matchesSearch && matchesStock;
      })
      .sort((first, second) => {
        switch (sortBy) {
          case 'name-asc':
            return String(first.product_name).localeCompare(String(second.product_name));
          case 'name-desc':
            return String(second.product_name).localeCompare(String(first.product_name));
          case 'price-asc':
            return Number(first.price) - Number(second.price);
          case 'price-desc':
            return Number(second.price) - Number(first.price);
          case 'quantity-asc':
            return Number(first.quantity) - Number(second.quantity);
          case 'quantity-desc':
            return Number(second.quantity) - Number(first.quantity);
          default:
            return Number(second.id) - Number(first.id);
        }
      });
  }, [products, search, sortBy, stockFilter]);
  const inventoryUnits = products.reduce((total, product) => total + (Number(product.quantity) || 0), 0);
  const inventoryValue = products.reduce(
    (total, product) => total + (Number(product.price) || 0) * (Number(product.quantity) || 0),
    0,
  );
  const lowStockCount = products.filter((product) => Number(product.quantity) > 0 && Number(product.quantity) <= 5).length;
  const outOfStockCount = products.filter((product) => Number(product.quantity) === 0).length;

  useEffect(() => {
    normalizePath();
  }, []);

  useEffect(() => {
    if (!deleteTarget) return undefined;

    function closeOnEscape(event) {
      if (event.key === 'Escape' && !deleting) {
        setDeleteTarget(null);
      }
    }

    window.addEventListener('keydown', closeOnEscape);
    return () => window.removeEventListener('keydown', closeOnEscape);
  }, [deleteTarget, deleting]);

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
      normalizePath();
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
      normalizePath();
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

  async function refreshProducts() {
    setRefreshing(true);
    setError('');
    try {
      await loadProducts();
    } catch (requestError) {
      setError(requestError.message);
    } finally {
      setRefreshing(false);
    }
  }

  async function deleteProduct() {
    if (!deleteTarget || deleting) return;
    setDeleting(true);
    setError('');
    try {
      await send(`/api/products/${deleteTarget.id}`, { method: 'DELETE' });
      setProducts((current) => current.filter((item) => item.id !== deleteTarget.id));
      setNotice(`${deleteTarget.product_name} was deleted.`);
      setDeleteTarget(null);
    } catch (requestError) {
      setError(requestError.message);
    } finally {
      setDeleting(false);
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
          <span>Stock<span className="brand-light">room</span></span>
        </a>
        <div className="account">
          <ApiStatus status={apiStatus} />
          <span className="account-divider" />
          <span className="account-avatar">{(user?.username || 'A').slice(0, 1).toUpperCase()}</span>
          <span className="account-name">{user?.username || 'Administrator'}</span>
          <button className="button quiet logout-button" onClick={logout}>Log out</button>
        </div>
      </header>

      <section className="content">
        <div className="page-heading">
          <div>
            <p className="eyebrow">OVERVIEW <span className="eyebrow-dot">/</span> INVENTORY</p>
            <h1>Product inventory</h1>
            <p className="muted">A clear view of your products, stock levels, and inventory value.</p>
          </div>
          <button
            className="button primary"
            onClick={() => {
              setEditing(null);
              setShowForm(true);
              setError('');
              setNotice('');
            }}
          >
            <span className="button-plus" aria-hidden="true">+</span> Add product
          </button>
        </div>

        {error && <div className="alert error" role="alert">{error}</div>}
        {notice && <div className="alert success">{notice}</div>}

        <section className="stats-grid" aria-label="Inventory summary">
          <article className="stat-card">
            <div className="stat-top"><span className="stat-icon blue-icon">P</span><span className="stat-caption">CATALOG</span></div>
            <p className="stat-value">{products.length}</p>
            <p className="stat-label">Total products</p>
          </article>
          <article className="stat-card">
            <div className="stat-top"><span className="stat-icon violet-icon">U</span><span className="stat-caption">ON HAND</span></div>
            <p className="stat-value">{inventoryUnits.toLocaleString()}</p>
            <p className="stat-label">Units in stock</p>
          </article>
          <article className="stat-card">
            <div className="stat-top"><span className="stat-icon amber-icon">!</span><span className="stat-caption">NEEDS ATTENTION</span></div>
            <p className="stat-value">{lowStockCount + outOfStockCount}</p>
            <p className="stat-label">{lowStockCount} low stock · {outOfStockCount} out of stock</p>
          </article>
          <article className="stat-card">
            <div className="stat-top"><span className="stat-icon green-icon">$</span><span className="stat-caption">ESTIMATED VALUE</span></div>
            <p className="stat-value">{currency.format(inventoryValue)}</p>
            <p className="stat-label">Based on current stock</p>
          </article>
        </section>

        {(showForm || editing) && (
          <section className="panel form-panel" aria-label={editing ? 'Edit product' : 'Add product'}>
            <div className="panel-heading">
              <div>
                <p className="eyebrow">{editing ? 'UPDATE CATALOG' : 'NEW CATALOG ITEM'}</p>
                <h2>{editing ? `Edit ${editing.product_name}` : 'Add a product'}</h2>
                <p className="muted">Product details are saved securely to your inventory.</p>
              </div>
              <button className="icon-button" type="button" aria-label="Close product form" onClick={() => { setEditing(null); setShowForm(false); }}>×</button>
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
          <div className="panel-heading inventory-heading">
            <div className="list-title">
              <div>
                <h2>All products</h2>
                <p className="muted">Browse and manage your catalog</p>
              </div>
              <span className="item-count">{visibleProducts.length} of {products.length}</span>
            </div>
            <button className="button quiet refresh-button" onClick={refreshProducts} disabled={refreshing || loading}>
              <span className={refreshing ? 'refresh-icon spinning' : 'refresh-icon'} aria-hidden="true">↻</span>
              {refreshing ? 'Refreshing' : 'Refresh'}
            </button>
          </div>

          <div className="inventory-toolbar">
            <label className="search-field">
              <span className="search-icon" aria-hidden="true">⌕</span>
              <span className="sr-only">Search products</span>
              <input
                type="search"
                value={search}
                onChange={(event) => setSearch(event.target.value)}
                placeholder="Search products or descriptions..."
              />
              {search && <button type="button" className="clear-search" onClick={() => setSearch('')} aria-label="Clear search">×</button>}
            </label>
            <label className="sort-control">
              <span>Sort by</span>
              <select value={sortBy} onChange={(event) => setSortBy(event.target.value)} aria-label="Sort products">
                <option value="newest">Recently added</option>
                <option value="name-asc">Name: A to Z</option>
                <option value="name-desc">Name: Z to A</option>
                <option value="price-asc">Price: low to high</option>
                <option value="price-desc">Price: high to low</option>
                <option value="quantity-asc">Quantity: low to high</option>
                <option value="quantity-desc">Quantity: high to low</option>
              </select>
            </label>
          </div>

          <div className="filter-tabs" role="group" aria-label="Filter products by stock">
            {[
              ['all', 'All products', products.length],
              ['in-stock', 'In stock', products.filter((product) => Number(product.quantity) > 5).length],
              ['low-stock', 'Low stock', lowStockCount],
              ['out-of-stock', 'Out of stock', outOfStockCount],
            ].map(([filter, label, count]) => (
              <button
                className={`filter-tab${stockFilter === filter ? ' active' : ''}`}
                key={filter}
                type="button"
                onClick={() => setStockFilter(filter)}
                aria-pressed={stockFilter === filter}
              >
                {label}<span>{count}</span>
              </button>
            ))}
          </div>
          {loading ? (
            <div className="empty-state"><span className="loading-spinner" />Loading your inventory…</div>
          ) : products.length === 0 ? (
            <div className="empty-state">
              <span className="empty-icon">P</span>
              <strong>Your inventory is ready for its first product</strong>
              <span>Add products to track stock and see your inventory summary here.</span>
              <button className="button primary" onClick={() => { setEditing(null); setShowForm(true); }}>Add your first product</button>
            </div>
          ) : visibleProducts.length === 0 ? (
            <div className="empty-state">
              <span className="empty-icon">⌕</span>
              <strong>No matching products</strong>
              <span>Try a different search or stock filter.</span>
              <button className="button quiet" onClick={() => { setSearch(''); setStockFilter('all'); }}>Clear filters</button>
            </div>
          ) : (
            <div className="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th>Product details</th>
                    <th>Unit price</th>
                    <th>Stock level</th>
                    <th>Inventory value</th>
                    <th className="actions-heading">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {visibleProducts.map((product) => {
                    const quantity = Number(product.quantity) || 0;
                    const stockStatus = quantity === 0 ? 'out' : quantity <= 5 ? 'low' : 'healthy';
                    return (
                    <tr key={product.id}>
                      <td>
                        <div className="product-cell">
                          <span className="product-avatar">{String(product.product_name || 'P').slice(0, 1).toUpperCase()}</span>
                          <span className="product-copy">
                            <strong className="product-name">{product.product_name}</strong>
                            <span className="description">{product.description || 'No description'}</span>
                          </span>
                        </div>
                      </td>
                      <td className="price-cell">{currency.format(Number(product.price) || 0)}</td>
                      <td>
                        <span className={`stock-badge ${stockStatus}`}>
                          <span className="stock-dot" />{quantity === 0 ? 'Out of stock' : quantity <= 5 ? 'Low stock' : 'In stock'}
                        </span>
                        <span className="stock-quantity">{quantity.toLocaleString()} units</span>
                      </td>
                      <td className="price-cell">{currency.format((Number(product.price) || 0) * quantity)}</td>
                      <td>
                        <div className="row-actions">
                          <button
                            className="action-button edit-action"
                            onClick={() => {
                              setEditing(product);
                              setShowForm(false);
                              setError('');
                              setNotice('');
                            }}
                          >
                            <span aria-hidden="true">✎</span> Edit
                          </button>
                          <button className="action-button delete-action" onClick={() => { setDeleteTarget(product); setError(''); }}>
                            <span aria-hidden="true">⌫</span> Delete
                          </button>
                        </div>
                      </td>
                    </tr>
                    );
                  })}
                </tbody>
              </table>
            </div>
          )}
        </section>
        <footer><span className="footer-brand">Stockroom</span><span>Inventory management</span><span>·</span><span>{new Date().getFullYear()}</span></footer>
      </section>
      {deleteTarget && (
        <div className="modal-backdrop" onMouseDown={(event) => { if (event.target === event.currentTarget && !deleting) setDeleteTarget(null); }}>
          <section className="confirm-dialog" role="dialog" aria-modal="true" aria-labelledby="delete-title" aria-describedby="delete-description">
            <div className="confirm-icon">!</div>
            <h2 id="delete-title">Delete this product?</h2>
            <p id="delete-description">
              <strong>{deleteTarget.product_name}</strong> will be permanently removed from your inventory. This action cannot be undone.
            </p>
            {error && <div className="alert error modal-error" role="alert">{error}</div>}
            <div className="confirm-actions">
              <button className="button quiet" onClick={() => setDeleteTarget(null)} disabled={deleting}>Keep product</button>
              <button className="button danger-button" onClick={deleteProduct} disabled={deleting}>
                {deleting ? 'Deleting…' : 'Delete product'}
              </button>
            </div>
          </section>
        </div>
      )}
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
