<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        /* SIDEBAR */
        .navbar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
            background: #172554;
            padding: 35px 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .logo {
            color: white;
            font-size: 23px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 50px;
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .nav-links a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 14px 18px;
            border-radius: 8px;
            font-size: 15px;
            transition: 0.3s;
        }

        .nav-links a:hover {
            background: #2563eb;
            color: white;
        }

        /* MAIN CONTENT */
        .container {
            margin-left: 240px;
            padding: 50px;
            max-width: 1200px;
        }

        /* MESSAGE */
        .message {
            background: #ecfdf5;
            border-left: 5px solid #10b981;
            color: #047857;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        /* HEADER */
        .welcome {
            background: transparent;
            padding: 10px 0;
            text-align: left;
        }

        .welcome h1 {
            font-size: 38px;
            color: #172554;
            margin-bottom: 8px;
        }

        .welcome > p {
            color: #64748b;
            margin-bottom: 35px;
            font-size: 16px;
        }

        /* INFORMATION AREA */
        .student-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            margin-bottom: 30px;
        }

        .student-card p {
            background: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            color: #475569;
            border: 1px solid #e2e8f0;
            margin: 0;
        }

        .student-card strong {
            display: block;
            color: #2563eb;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        /* BUTTON */
        .button {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 14px 25px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
            margin-right: 10px;
        }

        .button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        /* FOOTER */
        footer {
            color: #94a3b8;
            font-size: 13px;
            margin-top: 50px;
            padding-bottom: 20px;
        }

        /* MOBILE */
        @media (max-width: 700px) {

            .navbar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 20px;
            }

            .logo {
                margin-bottom: 20px;
            }

            .nav-links {
                flex-direction: row;
                justify-content: center;
                flex-wrap: wrap;
            }

            .nav-links a {
                padding: 10px 15px;
            }

            .container {
                margin-left: 0;
                padding: 30px 20px;
            }

            .welcome h1 {
                font-size: 30px;
            }

            .student-card {
                grid-template-columns: 1fr;
            }

            .button {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">

        <div class="logo">
            Student Portal
        </div>

        <div class="nav-links">
            <a href="<?= site_url('student'); ?>">Home</a>
            <a href="<?= site_url('student/profile'); ?>">Profile</a>
            <a href="<?= site_url('users'); ?>">Users List</a>
        </div>

    </nav>

    <main class="container">

        <?php if (isset($_SESSION['middleware_message'])): ?>

            <div class="message">
                <?= $_SESSION['middleware_message']; ?>
            </div>

            <?php unset($_SESSION['middleware_message']); ?>

        <?php endif; ?>

        <section class="welcome">

            <h1>Welcome, <?= $student['name']; ?>!</h1>

            <p>
                Welcome to your student information page.
            </p>

            <div class="student-card">

                <p>
                    <strong>Student ID</strong>
                    <?= $student['student_id']; ?>
                </p>

                <p>
                    <strong>Course</strong>
                    <?= $student['course']; ?>
                </p>

                <p>
                    <strong>Year Level</strong>
                    <?= $student['year']; ?>
                </p>

                <p>
                    <strong>Section</strong>
                    <?= $student['section']; ?>
                </p>

                <p>
                    <strong>Email</strong>
                    <?= $student['email']; ?>
                </p>

                <p>
                    <strong>Contact Number</strong>
                    <?= $student['contact']; ?>
                </p>

            </div>

            <a class="button" href="<?= site_url('student/profile'); ?>">
                View Student Profile
            </a>

            <a class="button" href="<?= site_url('users'); ?>">
                Users List
            </a>

        </section>

        <footer>
            Student Information System
        </footer>

    </main>

</body>
</html>