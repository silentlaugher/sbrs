<?php 
    include_once 'core/session.php';
    include_once 'core/Database.php';
    include_once 'core/utilities.php';

    if(isset($_POST['loginBtn'])){
        // array to hold errors
        $form_errors = array();
    
        // validate
        $required_fields = array('email', 'password');
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
    
        if(empty($form_errors)){
            // collect form data
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // check if user exist in the database
            $sqlQuery = "SELECT * FROM users WHERE email = :email";
            $statement = $db->prepare($sqlQuery);
            $statement->execute(array(':email' => $email));

            while($row = $statement->fetch()){
                $id = $row['id'];
                $email = $row['email'];
                $hashed_password = $row['password'];
                $username = $row['username'];

                if(password_verify($password, $hashed_password)){
                    $_SESSION['id'] = $id;
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $username;
                    redirectTo('index');
                }else{
                    $result = flashMessage("Your credentials are incorrect. Invalid email or password");
                }
            }
        }else{
            if(count($form_errors) == 1){
                $result = flashMessage("There was one error in the form");
            }else{
                $result = flashMessage("There were " .count($form_errors). " errors in the form");
            }
        }
    }
    
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

    <?php if(isset($result)) echo $result; ?>
    <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

    <form action="login.php" method="POST">
        <table>
            <h5>Email</h5>
            <tr><input type="text" name="email" class="form-control" placeholder="Email"></tr>
            <h5>Password</h5>
            <tr><input type="password" name="password" class="form-control" placeholder="Password"></tr>
            <p class="forgotPasswordMessage">Forgot password?<a href="forgot_password.php"> Click here</a></p>
            <br>
            <div class="btn-div">
            <tr><input type="submit" style="margin-left: 115px;" name="loginBtn" value="Login" /></tr> 
            </div>
        </table>
    </form>
    <p>Not yet a member?<a href="register.php"> Register here</a></p>
    <p><a href="index.php">Back</a></p>
</body>
</html>