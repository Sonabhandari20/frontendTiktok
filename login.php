<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'tiktokapplication';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $user_password = $_POST['password'];

    if (empty($email) || empty($user_password)) {
        echo "<p style='color: red;'>Both fields are required.</p>";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($user_password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: home.html');
            exit();
        } else {
            echo "<p style='color: red;'>Invalid email or password.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signin-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .signin-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .input-field:focus {
            border-color: #007bff;
            outline: none;
        }

        .signin-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .signin-btn:hover {
            background-color: #0056b3;
        }

        .signin-footer {
            text-align: center;
            margin-top: 10px;
        }

        .signin-footer a {
            color: #007bff;
            text-decoration: none;
        }

        .signin-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <div class="signin-container">
        <h2>Sign In</h2>
        <form action="home.html" method="POST">
            <input type="text" name="username" class="input-field" placeholder="Username" required>
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            <button type="submit" class="signin-btn">Sign In</button>
        </form>
        <div class="signin-footer">
            <p>Don't have an account? <a href="/signup">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
