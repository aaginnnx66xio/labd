<?php
session_start();

if (!isset($_POST['cities']) || count($_POST['cities']) < 10) {
    die("Error: Please select at least 10 cities.");
}

$conn = new mysqli("localhost", "root", "", "info");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cities = $_POST['cities'];
$placeholders = implode(',', array_fill(0, count($cities), '?'));

$stmt = $conn->prepare("SELECT City, Country, AQI FROM info WHERE City IN ($placeholders)");
$stmt->bind_param(str_repeat('s', count($cities)), ...$cities);
$stmt->execute();
$result = $stmt->get_result();

$bgColor = isset($_COOKIE['bgColor']) ? $_COOKIE['bgColor'] : '#ffffff';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Selected AQI Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f0f0f0;
        }
        .box {
            width: 350px;
            height: 420px;
            border: 2px solid #349061;
            padding: 20px;
            box-sizing: border-box;
            background-color: <?= htmlspecialchars($bgColor) ?>;
            overflow-y: auto;
            text-align: center;
            margin: 60px auto;
            position: relative;
        }
        h2 {
            font-size: small;
            margin-top: 0;
        }
        table {
            margin: 10px auto;
            background-color: rgb(52, 144, 97);
            color: white;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }
        table th, table td {
            padding: 5px;
            border: 1px solid #ffffff;
        }
        .user-buttons {
            position: absolute;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .btn {
            font-size: 10px;
            padding: 4px 4px;
            background-color:rgb(139, 27, 62);
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="user-buttons">
            <form action="user.php" method="post">
                <button type="submit" class="btn">Username</button>
            </form>
            <form action="register.html?showLogin=1" method="get">
                <button type="submit" class="btn">Logout</button>
            </form>
        </div>

        <h2>Selected City AQI Information</h2>
        <table>
            <tr>
                <th>City</th>
                <th>Country</th>
                <th>AQI</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['City']) ?></td>
                <td><?= htmlspecialchars($row['Country']) ?></td>
                <td><?= htmlspecialchars($row['AQI']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>