<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Product</title>

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
            max-width: 1250px;
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
            padding: 30px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.05);
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 9px;
        }

        label::before {
            content: "";
            width: 6px;
            height: 6px;
            background: #3b82f6;
            border-radius: 50%;
        }

        input,
        textarea {
            width: 100%;
            padding: 14px 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #334155;
            font-family: inherit;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        input::placeholder,
        textarea::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        input:hover,
        textarea:hover {
            border-color: #cbd5e1;
            background: white;
        }

        input:focus,
        textarea:focus {
            outline: none;
            background: white;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid #e2e8f0;
        }

        button,
        .cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 13px 20px;
            border-radius: 10px;
            border: none;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        button {
            background: #2563eb;
            color: white;
        }

        button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
        }

        .cancel {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .cancel:hover {
            background: #e2e8f0;
            color: #334155;
            transform: translateY(-2px);
        }

        footer {
            color: #94a3b8;
            font-size: 12px;
            margin-top: 55px;
            padding-top: 20px;
            padding-bottom: 20px;
            border-top: 1px solid #e2e8f0;
        }

        @media (max-width: 850px) {
            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;
                padding: 30px;
            }

            .page-header h1 {
                font-size: 28px;
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

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .page-header h1 {
                font-size: 27px;
            }

            .card {
                padding: 22px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .buttons {
                flex-direction: column;
            }

            button,
            .cancel {
                width: 100%;
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

        <a href="<?= site_url('products'); ?>">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Products</span>
        </a>

        <a href="<?= site_url('products/create'); ?>" class="active">
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

                <div class="header-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>

                <div>
                    <div class="header-label">
                        Product Management
                    </div>

                    <h1>Add Product</h1>

                    <p>
                        Add a new product to your inventory.
                    </p>
                </div>

            </div>

        </div>

        <div class="section-heading">
            <h2>Product Information</h2>
            <span>Enter Product Details</span>
        </div>

        <div class="card">

            <form action="<?= site_url('products/store'); ?>" method="POST">

                <div class="form-group">

                    <label for="product_name">
                        Product Name
                    </label>

                    <input
                        type="text"
                        id="product_name"
                        name="product_name"
                        placeholder="Enter product name"
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
                        placeholder="Enter product description"
                    ></textarea>

                </div>

                <div class="form-row">

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
                            placeholder="Enter price"
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
                            placeholder="Enter quantity"
                            required
                        >

                    </div>

                </div>

                <div class="buttons">

                    <button type="submit">
                        <i class="fa-solid fa-plus"></i>
                        Add Product
                    </button>

                    <a
                        href="<?= site_url('products'); ?>"
                        class="cancel">
                        <i class="fa-solid fa-xmark"></i>
                        Cancel
                    </a>

                </div>

            </form>

        </div>

        <footer>
            Product Management System
        </footer>

    </main>

</body>

</html>