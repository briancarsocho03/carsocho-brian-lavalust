<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #0d0d12;
            color: #f5f5f5;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;

            background: #15151d;
            border: 1px solid #292933;

            border-radius: 20px;
            padding: 35px;

            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #999;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            color: #777;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin-bottom: 9px;
        }

        input {
            width: 100%;

            padding: 13px 15px;

            background: #0d0d12;

            color: #f5f5f5;

            border: 1px solid #33333d;

            border-radius: 8px;

            font-size: 14px;
        }

        input:focus {
            outline: none;

            border-color: #2589ff;

            box-shadow: 0 0 0 2px rgba(37, 137, 255, 0.08);
        }

        .login-button {
            width: 100%;

            padding: 13px;

            background: #ffffff;

            color: #0d0d12;

            border: none;

            border-radius: 8px;

            font-weight: bold;

            cursor: pointer;

            font-size: 14px;

            transition: 0.3s;
        }

        .login-button:hover {
            background: #2589ff;

            color: #ffffff;
        }

        .error {
            background: #211518;

            color: #ff6b6b;

            border: 1px solid #4a2727;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-size: 13px;
        }

        .credentials {
            margin-top: 20px;

            padding: 12px;

            background: #111118;

            border: 1px solid #292933;

            border-radius: 8px;

            color: #888;

            font-size: 12px;

            line-height: 1.6;
        }

    </style>

</head>

<body>

    <div class="login-card">

        <div class="login-header">

            <h1>Login</h1>

            <p>
                Login to access Product Management.
            </p>

        </div>


        <?php if (isset($error)): ?>

            <div class="error">
                <?= htmlspecialchars($error); ?>
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

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter username"
                    required
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >

            </div>


            <button
                type="submit"
                class="login-button"
            >
                Login
            </button>

        </form>


        <div class="credentials">

            <strong>Laboratory Account</strong><br>

            Username: admin<br>
            Password: admin123

        </div>

    </div>

</body>

</html>