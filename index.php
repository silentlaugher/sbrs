<?php 
    include_once 'core/Database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Homepage</title>
</head>
<body>
    <h1>Security Based Registration System</h1>
        <p class="lead">You are currently not logged in <a href="login.php">Log in</a> Not yet a member? <a href="register.php">Register here</a></p>
        <br>
        <br>
        <p class="lead">You are currently signed in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href="logout.php">Sign out</a></p>
</body>
</html>