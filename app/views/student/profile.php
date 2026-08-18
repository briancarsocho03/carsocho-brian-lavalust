<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>

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

        /* PROFILE HEADER */
        .profile {
            background: transparent;
            padding: 0;
        }

        .profile-header {
            background: white;
            padding: 35px;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 25px;
        }

        /* AVATAR */
        .avatar {
            width: 95px;
            height: 95px;
            flex-shrink: 0;
            background: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 35px;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.25);
        }

        .profile-header h1 {
            font-size: 32px;
            color: #172554;
            margin-bottom: 8px;
        }

        .profile-header p {
            color: #64748b;
            font-size: 15px;
        }

        /* INFORMATION */
        .profile-info {
            background: white;
            border-radius: 15px;
            padding: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            transition: 0.3s;
        }

        .info-box:hover {
            border-color: #2563eb;
            transform: translateY(-2px);
        }

        .info-box.full {
            grid-column: 1 / -1;
        }

        .label {
            display: block;
            color: #2563eb;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .value {
            color: #334155;
            font-size: 15px;
            font-weight: bold;
        }

        /* BACK BUTTON */
        .back-button {
            display: inline-block;
            margin-top: 25px;
            padding: 14px 24px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
        }

        .back-button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        /* FOOTER */
        footer {
            color: #94a3b8;
            font-size: 13px;
            margin-top: 45px;
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
            }

            .nav-links a {
                padding: 10px 15px;
            }

            .container {
                margin-left: 0;
                padding: 30px 20px;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-info {
                grid-template-columns: 1fr;
            }

            .info-box.full {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <nav class="navbar">

        <div class="logo">
            Student Portal
        </div>

        <div class="nav-links">
            <a href="<?= site_url('student'); ?>">Home</a>
            <a href="<?= site_url('student/profile'); ?>">Profile</a>
        </div>

    </nav>


    <!-- MAIN CONTENT -->
    <main class="container">

        <section class="profile">

            <!-- PROFILE HEADER -->
            <div class="profile-header">

                <div class="avatar">
                    <?= strtoupper(substr($student['name'], 0, 1)); ?>
                </div>

                <div>
                    <h1><?= $student['name']; ?></h1>
                    <p><?= $student['course']; ?></p>
                </div>

            </div>


            <!-- STUDENT INFORMATION -->
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


            <!-- BACK BUTTON -->
            <a class="back-button" href="<?= site_url('student'); ?>">
                ← Back to Student Home
            </a>

        </section>


        <footer>
            Student Information System
        </footer>

    </main>

</body>
</html>