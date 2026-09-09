<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Product</title>

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
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        /* MAIN */

        .main {
            margin-left: 240px;
            width: calc(100% - 240px);
            padding: 30px;
        }

        .topbar {
            margin-bottom: 25px;
        }

        .topbar h1 {
            font-size: 28px;
        }

        .topbar p {
            color: #64748b;
            margin-top: 5px;
        }

        /* FORM */

        .card {
            background: white;
            max-width: 800px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 15px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button,
        .cancel {
            padding: 12px 20px;
            border-radius: 7px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #2563eb;
            color: white;
        }

        button:hover {
            background: #1d4ed8;
        }

        .cancel {
            background: #64748b;
            color: white;
        }

        .cancel:hover {
            background: #475569;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
                width: calc(100% - 200px);
                padding: 20px;
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

        <a href="<?= site_url('products'); ?>">
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


    <!-- MAIN -->

    <main class="main">

        <div class="topbar">

            <h1>Edit Product</h1>

            <p>
                Update the information of this product.
            </p>

        </div>


        <div class="card">

            <form
                action="<?= site_url('products/update/' . $product['id']); ?>"
                method="POST"
            >

                <div class="form-group">

                    <label for="product_name">
                        Product Name
                    </label>

                    <input
                        type="text"
                        id="product_name"
                        name="product_name"
                        value="<?= htmlspecialchars($product['product_name']); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                    ><?= htmlspecialchars($product['description']); ?></textarea>

                </div>


                <div class="form-group">

                    <label for="price">
                        Price
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        step="0.01"
                        min="0"
                        value="<?= htmlspecialchars($product['price']); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="quantity">
                        Quantity
                    </label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="0"
                        value="<?= htmlspecialchars($product['quantity']); ?>"
                        required
                    >

                </div>


                <div class="buttons">

                    <button type="submit">
                        Update Product
                    </button>

                    <a
                        href="<?= site_url('products'); ?>"
                        class="cancel">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </main>

</div>

</body>

</html> 