<?php
// submissions.php

// Basic HTTP Authentication
$valid_passwords = array("admin" => "StrongPassword123!"); // Replace with your password
$valid_users = array_keys($valid_passwords);

$user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
$pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
    header('WWW-Authenticate: Basic realm="Submissions Access"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Unauthorized';
    exit;
}

// Database credentials
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "artist_portfolio";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch submissions
$sql = "SELECT firstname, lastname, email, subject, submitted_at FROM submissions ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions | Jozey Nguyen</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <style>
        .submissions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .submissions-table th,
        .submissions-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .submissions-table th {
            background-color: var(--hover-color);
            color: var(--primary-color);
        }

        .submissions-table tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Jozey Nguyen</h1>
            <nav>
                <ul>
                    <li><a href="../index.html" class="nav-link button">Home</a></li>
                    <li><a href="../digitalart/digitalart.html" class="nav-link button">Digital Art</a></li>
                    <li><a href="../art/art.html" class="nav-link button">Art</a></li>
                    <li><a href="../photography/photography.html" class="nav-link button">Photography</a></li>
                    <li><a href="../about.html" class="nav-link button">About</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="submissions">
                <h2>Form Submissions</h2>
                <table class="submissions-table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No submissions found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>

        <footer>
            <div class="social-icons">
                <a href="mailto:nguyenjozey@gmail.com?Subject=Hello%20There" class="icon" aria-label="Email">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="https://www.instagram.com/joko.jo.jo/" class="icon" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://vimeo.com/user109355174" class="icon" aria-label="Vimeo">
                    <i class="fab fa-vimeo-v"></i>
                </a>
                <a href="https://www.linkedin.com/in/jozey-n-830639139/" class="icon" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
            <p>&copy; 2024 Jozey Nguyen. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
