<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login Page</title>
</head>
<body>
    <h1>Security Based Registration System</h1>
    <hr>
    <h3>Login Form</h3>
    <form action="login.php" method="POST">
        <table>
            <tr><td>Enter:</td><td><input type="text" name="email" class="form-control" placeholder="Email or Username"></td></tr>
            <br>
            <tr><td>Enter:</td><td><input type="password" name="password" class="form-control" placeholder="Password"></td></tr>
            <br>
            <div class="btn-div">
            <tr><td></td><td><input type="submit" style="margin-left: 115px;" name="loginBtn" value="Login" /></td></tr> 
            </div>
        </table>
    </form>
    <p>Not yet a member?<a href="register.php"> Register here</a></p>
    <p><a href="index.php">Back</a></p>
</body>
</html>