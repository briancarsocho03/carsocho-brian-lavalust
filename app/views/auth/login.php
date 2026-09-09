<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Product System</title>

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
            background: #f8fafc;
            color: var(--text);
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 25px;

            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            width: 450px;
            height: 450px;
            background: rgba(37, 99, 235, 0.08);
            border-radius: 50%;
            top: -180px;
            right: -150px;
        }

        body::after {
            content: "";
            position: fixed;
            width: 400px;
            height: 400px;
            background: rgba(79, 70, 229, 0.06);
            border-radius: 50%;
            bottom: -180px;
            left: -150px;
        }

        .login-container {
            width: 100%;
            max-width: 430px;
            position: relative;
            z-index: 2;
        }

        .login-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 38px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .brand {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }

        .brand-icon {
            width: 65px;
            height: 65px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: linear-gradient(135deg, #1e3a8a, #2563eb, #4f46e5);

            color: white;

            border-radius: 18px;

            font-size: 25px;

            box-shadow: 0 12px 25px rgba(37, 99, 235, 0.22);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }

        .error {
            display: flex;
            align-items: center;
            gap: 10px;

            background: #fef2f2;
            color: #dc2626;

            border: 1px solid #fecaca;

            padding: 12px 14px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-size: 12px;
            line-height: 1.5;
        }

        .error i {
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            color: #334155;

            font-size: 12px;
            font-weight: 600;

            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 14px;
            top: 50%;

            transform: translateY(-50%);

            color: #94a3b8;

            font-size: 14px;

            pointer-events: none;
        }

        input {
            width: 100%;

            padding: 13px 44px 13px 42px;

            background: #f8fafc;

            color: #0f172a;

            border: 1px solid #dbe3ed;

            border-radius: 10px;

            font-family: 'Inter', Arial, sans-serif;

            font-size: 13px;

            transition: all 0.2s ease;
        }

        input::placeholder {
            color: #94a3b8;
        }

        input:hover {
            border-color: #cbd5e1;
        }

        input:focus {
            outline: none;

            background: white;

            border-color: #2563eb;

            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        input:focus + .input-icon {
            color: #2563eb;
        }

        .password-toggle {
            position: absolute;

            right: 12px;
            top: 50%;

            transform: translateY(-50%);

            border: none;

            background: transparent;

            color: #94a3b8;

            cursor: pointer;

            width: 30px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 7px;

            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            color: #2563eb;
            background: #eff6ff;
        }

        .login-button {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;

            padding: 13px;

            background: linear-gradient(135deg, #2563eb, #4f46e5);

            color: white;

            border: none;

            border-radius: 10px;

            font-family: 'Inter', Arial, sans-serif;

            font-weight: 700;

            cursor: pointer;

            font-size: 13px;

            transition: all 0.25s ease;

            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.18);

            margin-top: 5px;
        }

        .login-button:hover {
            transform: translateY(-2px);

            box-shadow: 0 12px 25px rgba(37, 99, 235, 0.25);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .credentials {
            margin-top: 25px;

            padding: 15px;

            background: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 11px;

            color: #64748b;

            font-size: 11px;

            line-height: 1.7;
        }

        .credentials-title {
            display: flex;
            align-items: center;
            gap: 8px;

            color: #334155;

            font-size: 11px;
            font-weight: 700;

            margin-bottom: 6px;
        }

        .credentials-title i {
            color: #2563eb;
        }

        .credentials strong {
            color: #334155;
        }

        .footer {
            text-align: center;

            margin-top: 22px;

            color: #94a3b8;

            font-size: 11px;
        }

        @media (max-width: 500px) {

            body {
                padding: 18px;
            }

            .login-card {
                padding: 28px 22px;
                border-radius: 18px;
            }

            .brand-icon {
                width: 58px;
                height: 58px;
                font-size: 22px;
            }

            .login-header h1 {
                font-size: 25px;
            }

        }

    </style>

</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="brand">

                <div class="brand-icon">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>

            </div>

            <div class="login-header">

                <h1>Welcome Back</h1>

                <p>
                    Sign in to access the Product Management System.
                </p>

            </div>

            <?php if (isset($error)): ?>

                <div class="error">
                    <i class="fa-solid fa-circle-exclamation"></i>

                    <span>
                        <?= htmlspecialchars($error); ?>
                    </span>
                </div>

            <?php endif; ?>

            <form
                action="<?= site_url('login/authenticate'); ?>"
                method="POST"
            >

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-user input-icon"></i>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-lock input-icon"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="passwordToggle"
                            onclick="togglePassword()"
                            aria-label="Show password"
                        >
                            <i class="fa-solid fa-eye"></i>
                        </button>

                    </div>

                </div>

                <button
                    type="submit"
                    class="login-button"
                >
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Login
                </button>

            </form>

        </div>

        <div class="footer">
            Product Management System
        </div>

    </div>

    <script>

        function togglePassword() {

            const password = document.getElementById('password');
            const toggle = document.getElementById('passwordToggle');
            const icon = toggle.querySelector('i');

            if (password.type === 'password') {

                password.type = 'text';

                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

                toggle.setAttribute('aria-label', 'Hide password');

            } else {

                password.type = 'password';

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

                toggle.setAttribute('aria-label', 'Show password');

            }

        }

    </script>

</body>

</html>