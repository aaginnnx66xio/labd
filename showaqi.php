<?php
$conn = new mysqli("localhost", "root", "", "your_database_name");

if (!isset($_POST['cities']) || count($_POST['cities']) < 10) {
    die("You must select at least 10 cities.");
}

$cities = $_POST['cities'];
$placeholders = implode(',', array_fill(0, count($cities), '?'));

$stmt = $conn->prepare("SELECT City, Country, AQI FROM info WHERE City IN ($placeholders)");
$stmt->bind_param(str_repeat('s', count($cities)), ...$cities);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selected AQI Info</title>
</head>
<body>
    <h2>Selected Cities' AQI Information</h2>
    <table border="1">
        <tr>
            <th>City</th>
            <th>Country</th>
            <th>AQI</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['City'] ?></td>
            <td><?= $row['Country'] ?></td>
            <td><?= $row['AQI'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br><br>
    <form method="post" action="confirm.php">
        <?php foreach ($cities as $city): ?>
            <input type="hidden" name="cities[]" value="<?= htmlspecialchars($city) ?>">
        <?php endforeach; ?>
        <input type="submit" value="Confirm">
    </form>
</body>
</html>
