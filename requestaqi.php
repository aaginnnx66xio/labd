<?php
$conn = new mysqli("localhost", "root", "", "your_database_name");
$result = $conn->query("SELECT * FROM info LIMIT 20");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Cities</title>
</head>
<body>
    <form action="showaqi.php" method="post" onsubmit="return validateSelection()">
        <h2>Select at least 10 cities:</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <input type="checkbox" name="cities[]" value="<?= $row['City'] ?>"> 
            <?= $row['City'] ?> (<?= $row['Country'] ?>)<br>
        <?php endwhile; ?>
        <br>
        <input type="submit" value="Load">
    </form>

    <script>
        function validateSelection() {
            const selected = document.querySelectorAll('input[name="cities[]"]:checked').length;
            if (selected < 10) {
                alert("Please select at least 10 cities.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
