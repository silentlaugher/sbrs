<?php 
    include_once 'core/session.php';
    include_once 'core/Database.php';
    include_once 'core/utilities.php';
    include_once 'partials/headers.php';
    include_once 'partials/nav.php';
    $page_title = "Edynak Security Based Registration System - Sign In Page -";

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
    <div class="logContainer">
        <div class="logColumn">
            <div class="logHeader">
            <h1>Edynak Security Based Registration System</h1>
                <hr>
                <h3>Login Form</h3>
                <br>
                <?php if(isset($result)) echo $result; ?>
                <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
            </div>
            <div class="logForm">
                <form action="login.php" method="POST">
                <div>
                    <label for="emailField" class="form-label">Email or Username</label>
                    <input type="text" class="form-control" name="email" id="emailField" placeholder="Enter your address or username">
                    <div id="emailMessage" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <br>
                <div>
                    <label for="passwordField" class="form-label">Password</label>
                    <input type="password" class="form-control" neme="password" id="passwordField" placeholder="Enter your password">
                </div>
                <div class="checkbox">
                    <label>
                        <input name="remember" type="checkbox"> Remember me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary pull-right" name="loginBtn" id="loginBtn">Sign in</button>
                <p class="forgotPassword">Forgot password?<a href="forgot_password.php"> Click here</a></p>
                Not yet a member?<a href="register.php"> Register here</a>
                <p class="lBack"><a href="index.php">Back</a></p>
                </form>
            </div>
        </div>
    </div> 
<?php include_once 'partials/footers.php'; ?>