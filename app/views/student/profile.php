```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>

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
            --sidebar: #0f172a;
            --background: #f8fafc;
            --card: #ffffff;
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

        .navbar {
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

        .nav-title {
            color: #64748b;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0 14px;
            margin-bottom: 12px;
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #94a3b8;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .nav-links a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateX(3px);
        }

        .nav-links a.active {
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            color: white;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }

        .container {
            margin-left: 250px;
            padding: 45px 50px;
            max-width: 1350px;
        }

        .profile {
            padding: 0;
        }

        .profile-header {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1e3a8a, #2563eb, #4f46e5);
            border-radius: 20px;
            padding: 35px 38px;
            margin-bottom: 28px;
            color: white;
            display: flex;
            align-items: center;
            gap: 25px;
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.18);
        }

        .profile-header::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            right: -60px;
            top: -90px;
        }

        .profile-header::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            right: 130px;
            bottom: -90px;
        }

        .avatar {
            position: relative;
            z-index: 2;
            width: 90px;
            height: 90px;
            flex-shrink: 0;
            background: rgba(255,255,255,0.18);
            color: white;
            border: 3px solid rgba(255,255,255,0.35);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
            font-weight: 800;
            backdrop-filter: blur(10px);
        }

        .profile-header-content {
            position: relative;
            z-index: 2;
        }

        .profile-label {
            font-size: 11px;
            font-weight: 600;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 7px;
        }

        .profile-header h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .profile-header p {
            color: rgba(255,255,255,0.8);
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

        .profile-info {
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 8px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.05);
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid transparent;
            border-radius: 13px;
            padding: 20px;
            transition: all 0.25s ease;
        }

        .info-box:hover {
            background: white;
            border-color: #dbeafe;
            box-shadow: 0 5px 18px rgba(37, 99, 235, 0.08);
            transform: translateY(-2px);
        }

        .label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 9px;
        }

        .label::before {
            content: "";
            width: 6px;
            height: 6px;
            background: #3b82f6;
            border-radius: 50%;
        }

        .value {
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 13px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .back-button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
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
            .navbar {
                width: 210px;
            }

            .container {
                margin-left: 210px;
                padding: 30px;
            }

            .profile-header h1 {
                font-size: 28px;
            }
        }

        @media (max-width: 700px) {
            .navbar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 18px;
            }

            .logo {
                justify-content: center;
                margin-bottom: 20px;
            }

            .nav-title {
                display: none;
            }

            .nav-links {
                flex-direction: row;
                justify-content: center;
                flex-wrap: wrap;
            }

            .nav-links a {
                padding: 10px 14px;
            }

            .container {
                margin-left: 0;
                padding: 25px 18px;
            }

            .profile-header {
                padding: 28px 25px;
                flex-direction: column;
                text-align: center;
            }

            .profile-header h1 {
                font-size: 27px;
            }

            .profile-info {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }

            .back-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">

        <div class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>

            <div class="logo-text">
                Student Portal
                <span>Information System</span>
            </div>
        </div>

        <div class="nav-title">
            Navigation
        </div>

        <div class="nav-links">

            <a href="<?= site_url('student'); ?>">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>

            <a class="active" href="<?= site_url('student/profile'); ?>">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>

        </div>

    </nav>

    <main class="container">

        <section class="profile">

            <div class="profile-header">

                <div class="avatar">
                    <?= strtoupper(substr($student['name'], 0, 1)); ?>
                </div>

                <div class="profile-header-content">

                    <div class="profile-label">
                        Student Profile
                    </div>

                    <h1>
                        <?= $student['name']; ?>
                    </h1>

                    <p>
                        <?= $student['course']; ?>
                    </p>

                </div>

            </div>

            <div class="section-heading">
                <h2>Student Information</h2>
                <span>Personal Details</span>
            </div>

            <div class="profile-info">

                <div class="info-box">
                    <span class="label">Student ID</span>
                    <span class="value">
                        <?= $student['student_id']; ?>
                    </span>
                </div>

                <div class="info-box">
                    <span class="label">Year Level</span>
                    <span class="value">
                        <?= $student['year']; ?>
                    </span>
                </div>

                <div class="info-box">
                    <span class="label">Section</span>
                    <span class="value">
                        <?= $student['section']; ?>
                    </span>
                </div>

                <div class="info-box">
                    <span class="label">Course</span>
                    <span class="value">
                        <?= $student['course']; ?>
                    </span>
                </div>

                <div class="info-box">
                    <span class="label">Email</span>
                    <span class="value">
                        <?= $student['email']; ?>
                    </span>
                </div>

                <div class="info-box">
                    <span class="label">Contact Number</span>
                    <span class="value">
                        <?= $student['contact']; ?>
                    </span>
                </div>

            </div>

            <div class="actions">
                <a class="back-button" href="<?= site_url('student'); ?>">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Student Home
                </a>
            </div>

        </section>

        <footer>
            Student Information System
        </footer>

    </main>

</body>
</html>
```
