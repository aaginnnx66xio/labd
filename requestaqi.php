<?php
session_start();

$conn = new mysqli("localhost", "root", "", "info");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT City FROM info LIMIT 20");
$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row['City'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Cities</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
        }
        .box {
            width: 180px;
            margin: 30px auto;
            padding: 25px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px #ccc;
            position: relative;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            row-gap: 2px;
            column-gap: 3px;
        }
        .grid label {
            display: flex;
            align-items: center;
            font-size: 12px;
        }
        input[type="submit"] {
            margin-top: 7px;
            padding: 2px 8px;
            border: none;
            background: rgb(52, 144, 97);
            color: white;
            cursor: pointer;
            border-radius: 3px;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .user-buttons {
            position: absolute;
            top: 5px;
            right: 12px;
            display: flex;
            flex-direction: column;
            gap: 1px;
        }
        .btn {
            font-size: 10px;
            padding: 2px 4px;
            background-color: rgb(139, 27, 62);
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
    <form action="showaqi.php" method="post" onsubmit="return validateSelection();">
        <h3>Select at least 10 cities</h3>
        <div class="grid">
            <?php foreach ($cities as $city): ?>
                <label><input type="checkbox" name="cities[]" value="<?= htmlspecialchars($city) ?>"> <?= htmlspecialchars($city) ?></label>
            <?php endforeach; ?>
        </div>
        <input type="submit" value="Load">
    </form>

    <div class="user-buttons">
        <form action="user.php" method="post">
            <input type="hidden" name="email" value="<?= $_SESSION['email'] ?? '' ?>">
            <button type="submit" class="btn username">Username</button>
        </form>
        <form action="register.html" method="get">
            <input type="hidden" name="showLogin" value="1">
            <button type="submit" class="btn logout">Logout</button>
        </form>
    </div>
</div>

<script>
    function validateSelection() {
        let selected = document.querySelectorAll('input[name="cities[]"]:checked').length;
        if (selected < 10) {
            alert("Please select at least 10 cities.");
            return false;
        }
        return true;
    }
</script>
</body>
</html>
