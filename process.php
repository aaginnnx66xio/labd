<!-- Save as display.php -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $dob = htmlspecialchars($_POST['dob']);
  $country = htmlspecialchars($_POST['country']);
  $gender = htmlspecialchars($_POST['gender']);
  $bgColor = htmlspecialchars($_POST['bgColor']);
} else {
  header("Location: register.html");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Confirm Your Data</title>
</head>
<body style="font-family: Arial; text-align: center; background-color: white;">
  <h2>Confirm Your Information</h2>
  <table border="1" align="center" cellpadding="6" style="background-color: <?= $bgColor ?>;">
    <tr><th>Username</th><td><?= $username ?></td></tr>
    <tr><th>Email</th><td><?= $email ?></td></tr>
    <tr><th>Password</th><td><?= $password ?></td></tr>
    <tr><th>Date of Birth</th><td><?= $dob ?></td></tr>
    <tr><th>Country</th><td><?= $country ?></td></tr>
    <tr><th>Gender</th><td><?= $gender ?></td></tr>
    <tr><th>Background Color</th><td><?= $bgColor ?></td></tr>
  </table>

  <form action="register.html" style="margin-top: 10px;">
    <button type="submit" style="padding: 10px 10px; background-color: green; color: white;">Confirm</button>
  </form>
</body>
</html>
