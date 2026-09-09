```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --background: #f8fafc;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #172554 100%);
            padding: 28px 18px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-size: 20px;
            font-weight: 800;
            padding: 10px 12px;
            margin-bottom: 45px;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        .logo-text span {
            display: block;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 1px;
            margin-top: 3px;
            text-transform: uppercase;
        }

        .menu-title {
            color: #64748b;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0 14px;
            margin-bottom: 12px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #94a3b8;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 10px;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateX(3px);
        }

        .sidebar a.active {
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            color: white;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }

        .main {
            margin-left: 250px;
            padding: 45px 50px;
            max-width: 1450px;
        }

        .page-header {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1e3a8a, #2563eb, #4f46e5);
            border-radius: 20px;
            padding: 35px 38px;
            margin-bottom: 28px;
            color: white;
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.18);
        }

        .page-header::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            right: -60px;
            top: -90px;
        }

        .page-header::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            right: 130px;
            bottom: -90px;
        }

        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            width: 65px;
            height: 65px;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.16);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            backdrop-filter: blur(10px);
        }

        .header-label {
            font-size: 11px;
            font-weight: 600;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 7px;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .add-button {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: white;
            color: #2563eb;
            text-decoration: none;
            padding: 13px 19px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.12);
        }

        .add-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.18);
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .section-heading h2 {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
        }

        .section-heading span {
            color: #94a3b8;
            font-size: 12px;
        }

        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 22px;
        }

        .card-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .card-header p {
            color: #64748b;
            font-size: 13px;
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        th {
            padding: 14px 16px;
            background: #f8fafc;
            color: #475569;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        td {
            padding: 16px;
            color: #475569;
            font-size: 13px;
            font-weight: 500;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        td:first-child {
            color: #94a3b8;
            font-weight: 600;
        }

        td:nth-child(2) {
            color: #0f172a;
            font-weight: 700;
        }

        td:nth-child(4) {
            color: #2563eb;
            font-weight: 700;
        }

        td:nth-child(5) {
            color: #0f172a;
            font-weight: 700;
        }

        .description {
            max-width: 250px;
            color: #64748b;
            line-height: 1.5;
        }

        .quantity {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            padding: 6px 9px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 700;
        }

        .date {
            color: #64748b;
            font-size: 12px;
            white-space: nowrap;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .edit,
        .delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 11px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .edit {
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid #fed7aa;
        }

        .delete {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .edit:hover {
            background: #ffedd5;
            transform: translateY(-1px);
        }

        .delete:hover {
            background: #fee2e2;
            transform: translateY(-1px);
        }

        footer {
            color: #94a3b8;
            font-size: 12px;
            margin-top: 55px;
            padding-top: 20px;
            padding-bottom: 20px;
            border-top: 1px solid #e2e8f0;
        }

        @media (max-width: 950px) {
            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;
                padding: 30px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .add-button {
                margin-left: 85px;
            }
        }

        @media (max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 18px;
            }

            .logo {
                justify-content: center;
                margin-bottom: 20px;
            }

            .menu-title {
                display: none;
            }

            .sidebar a {
                display: inline-flex;
                padding: 10px 14px;
                margin: 3px;
            }

            .main {
                margin-left: 0;
                padding: 25px 18px;
            }

            .page-header {
                padding: 28px 25px;
            }

            .header-left {
                flex-direction: column;
                text-align: center;
                width: 100%;
            }

            .header-content {
                align-items: center;
            }

            .page-header h1 {
                font-size: 27px;
            }

            .add-button {
                margin-left: 0;
                width: 100%;
                justify-content: center;
            }

            .card {
                padding: 20px;
            }

            .card-header {
                flex-direction: column;
            }

            .section-heading {
                align-items: flex-start;
                gap: 5px;
                flex-direction: column;
            }
        }
    </style>

</head>

<body>

    <aside class="sidebar">

        <div class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-box"></i>
            </div>

            <div class="logo-text">
                Product System
                <span>Inventory Management</span>
            </div>
        </div>

        <div class="menu-title">
            Main
        </div>

        <a href="<?= site_url('products'); ?>" class="active">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Products</span>
        </a>

        <a href="<?= site_url('products/create'); ?>">
            <i class="fa-solid fa-plus"></i>
            <span>Add Product</span>
        </a>

        <div class="menu-title">
            System
        </div>

        <a href="#">
            <i class="fa-solid fa-users"></i>
            <span>Users</span>
        </a>

        <a href="#">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>

        <a href="#">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>

    </aside>

    <main class="main">

        <div class="page-header">

            <div class="header-content">

                <div class="header-left">

                    <div class="header-icon">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>

                    <div>
                        <div class="header-label">
                            Inventory Management
                        </div>

                        <h1>Products</h1>

                        <p>
                            Manage your products, inventory, prices and quantities.
                        </p>
                    </div>

                </div>

                <a href="<?= site_url('products/create'); ?>" class="add-button">
                    <i class="fa-solid fa-plus"></i>
                    Add Product
                </a>

            </div>

        </div>

        <div class="section-heading">
            <h2>Product Management</h2>
            <span>Manage Inventory</span>
        </div>

        <div class="card">

            <div class="card-header">

                <div>
                    <h2>Product List</h2>

                    <p>
                        View and manage all products in your inventory.
                    </p>
                </div>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($products as $product): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($product['id']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($product['product_name']) ?>
                            </td>

                            <td>
                                <div class="description">
                                    <?= htmlspecialchars($product['description']) ?>
                                </div>
                            </td>

                            <td>
                                ₱<?= htmlspecialchars($product['price']) ?>
                            </td>

                            <td>
                                <span class="quantity">
                                    <?= htmlspecialchars($product['quantity']) ?>
                                </span>
                            </td>

                            <td>
                                <span class="date">
                                    <?= htmlspecialchars($product['created_at']) ?>
                                </span>
                            </td>

                            <td>

                                <div class="actions">

                                    <a
                                        href="<?= site_url('products/edit/' . $product['id']); ?>"
                                        class="edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit
                                    </a>

                                    <a
                                        href="<?= site_url('products/delete/' . $product['id']); ?>"
                                        class="delete"
                                        onclick="return confirm('Are you sure you want to delete this product?');">
                                        <i class="fa-solid fa-trash"></i>
                                        Delete
                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

        <footer>
            Product Management System
        </footer>

    </main>

</body>

</html>
```
