<?php
session_start();

$conn = new mysqli("localhost", "root", "", "info");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST['login_email']) &&
    isset($_POST['login_password'])
) {
    $login_email = trim($_POST['login_email']);
    $login_password = trim($_POST['login_password']);

    $stmt = $conn->prepare("SELECT password FROM user WHERE email = ?");
    $stmt->bind_param("s", $login_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        if (password_verify($login_password, $stored_password)) {
            $_SESSION['email'] = $login_email; 
            header("Location: requestaqi.php");
            exit();
        }
    }

    header("Location: register.html?showLogin=1&loginError=1");
    exit();
}

if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    !isset($_POST['login_email'])
) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $rawPassword = $_POST['password'];
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);
    $dob = htmlspecialchars($_POST['dob']);
    $country = htmlspecialchars($_POST['country']);
    $gender = htmlspecialchars($_POST['gender']);
    $bgColor = htmlspecialchars($_POST['bgColor']);

    $stmt = $conn->prepare("INSERT INTO user (username, email, password, dob, country, gender) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $email, $password, $dob, $country, $gender);
    $stmt->execute();
    $stmt->close();
    $conn->close();
} else if (!isset($_POST['login_email'])) {
    header("Location: register.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Your Data</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color:#FFFFFF
        }
        .box {
            border: 2px solid #349061;
            padding: 18px;
            width: 270px;
            margin: 40px auto;
            background-color: <?= $bgColor ?>;
        }
        table {
            margin: 0 auto 10px;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 3px;
        }
        .btns {
            display: flex;
            justify-content: space-between;
        }
        .btns form {
            margin: 0;
        }
        button {
            padding: 5px 5px;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        .cancel-btn {
            background-color: red;
        }
        .confirm-btn {
            background-color: green;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>Confirm Your Information</h2>
    <table>
        <tr><th>Username</th><td><?= $username ?></td></tr>
        <tr><th>Email</th><td><?= $email ?></td></tr>
        <tr><th>Password</th><td><?= htmlspecialchars($rawPassword) ?></td></tr>
        <tr><th>Date of Birth</th><td><?= $dob ?></td></tr>
        <tr><th>Country</th><td><?= $country ?></td></tr>
        <tr><th>Gender</th><td><?= $gender ?></td></tr>
        <tr><th>Background Color</th><td><?= $bgColor ?></td></tr>
    </table>

    <div class="btns">
        <form action="register.html">
            <button type="submit" class="cancel-btn">Cancel</button>
        </form>
        <form action="register.html?showLogin=1" method="get">
            <?php
            setcookie("bgColor", $bgColor, time() + 3600);
            setcookie("username", $username, time() + 3600);
            setcookie("email", $email, time() + 3600);
            setcookie("dob", $dob, time() + 3600);
            setcookie("country", $country, time() + 3600);
            setcookie("gender", $gender, time() + 3600);
            ?>
            <input type="hidden" name="showLogin" value="1">
            <button type="submit" class="confirm-btn">Confirm</button>
        </form>
    </div>
</div>
</body>
</html>
