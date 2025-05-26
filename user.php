<?php
session_start();
$conn = new mysqli("localhost", "root", "", "info");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'] ?? $_POST['email'] ?? '';

$stmt = $conn->prepare("SELECT username, email, dob, country, gender FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Info</title>
    <style>
        body { font-family: Arial; text-align: center; background: #f0f0f0; }
        .box {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            width: 250px;
            box-shadow: 0 0 10px #aaa;
        }
        table { margin: auto; border-collapse: collapse; width: 100%; }
        th, td { padding: 4px; border: 1px solid #ccc; }
        .cancel-btn {
            background: red;
            color: white;
            padding: 4px 8px;
            border: none;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 3px;
        }
        .cancel-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>User Details</h2>
    <table>
        <tr><th>Username</th><td><?= htmlspecialchars($user['username']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
        <tr><th>Date of Birth</th><td><?= htmlspecialchars($user['dob']) ?></td></tr>
        <tr><th>Country</th><td><?= htmlspecialchars($user['country']) ?></td></tr>
        <tr><th>Gender</th><td><?= htmlspecialchars($user['gender']) ?></td></tr>
    </table>
    <form action="requestaqi.php">
        <button class="cancel-btn">Back</button>
    </form>
</div>
</body>
</html>