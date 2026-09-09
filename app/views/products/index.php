<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Management</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            width: 240px;
            background: #1e293b;
            color: white;
            padding: 25px 15px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 35px;
        }

        .menu-title {
            font-size: 12px;
            color: #94a3b8;
            margin: 20px 10px 8px;
            text-transform: uppercase;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        /* MAIN CONTENT */

        .main {
            margin-left: 240px;
            width: calc(100% - 240px);
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .topbar h1 {
            font-size: 28px;
        }

        .add-button {
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 7px;
            font-weight: bold;
        }

        .add-button:hover {
            background: #1d4ed8;
        }

        /* CARD */

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            margin-bottom: 20px;
        }

        .card-header h2 {
            font-size: 20px;
        }

        .card-header p {
            color: #64748b;
            margin-top: 5px;
        }

        /* TABLE */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f8fafc;
            font-size: 13px;
            text-transform: uppercase;
            color: #475569;
        }

        tr:hover {
            background: #f8fafc;
        }

        /* ACTION BUTTONS */

        .actions {
            display: flex;
            gap: 8px;
        }

        .edit {
            background: #f59e0b;
            color: white;
            padding: 7px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .delete {
            background: #dc2626;
            color: white;
            padding: 7px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .edit:hover {
            background: #d97706;
        }

        .delete:hover {
            background: #b91c1c;
        }

        /* MOBILE */

        @media (max-width: 768px) {

            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
                width: calc(100% - 200px);
                padding: 20px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>

</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="logo">
            Product System
        </div>

        <div class="menu-title">
            Main
        </div>

        <a href="<?= site_url('products'); ?>" class="active">
            📦 Products
        </a>

        <a href="<?= site_url('products/create'); ?>">
            ➕ Add Product
        </a>

        <div class="menu-title">
            System
        </div>

        <a href="#">
            👤 Users
        </a>

        <a href="#">
            ⚙️ Settings
        </a>

        <a href="#">
            🚪 Logout
        </a>

    </aside>


    <!-- MAIN CONTENT -->

    <main class="main">

        <div class="topbar">

            <div>
                <h1>Products</h1>
            </div>

            <a href="<?= site_url('products/create'); ?>" class="add-button">
                + Add Product
            </a>

        </div>


        <div class="card">

            <div class="card-header">

                <h2>Product Management</h2>

                <p>
                    Manage your products, inventory, prices and quantities.
                </p>

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
                                <?= htmlspecialchars($product['description']) ?>
                            </td>

                            <td>
                                ₱<?= htmlspecialchars($product['price']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($product['quantity']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($product['created_at']) ?>
                            </td>

                            <td>

                                <div class="actions">

                                    <a
                                        href="<?= site_url('products/edit/' . $product['id']); ?>"
                                        class="edit">
                                        Edit
                                    </a>

                                    <a
                                        href="<?= site_url('products/delete/' . $product['id']); ?>"
                                        class="delete"
                                        onclick="return confirm('Are you sure you want to delete this product?');">
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

    </main>

</div>

</body>

</html>