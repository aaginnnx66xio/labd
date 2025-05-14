<?php
if (!isset($_POST['cities'])) {
    die("No cities selected.");
}
echo "<h2>You have confirmed the selection of these cities:</h2><ul>";
foreach ($_POST['cities'] as $city) {
    echo "<li>" . htmlspecialchars($city) . "</li>";
}
echo "</ul>";
?>
