<?php 
    include_once 'core/Database.php';
    include_once 'core/utilities.php';
    include_once 'partials/headers.php';
    include_once 'partials/nav.php';
    $page_title = "Edynak Security Based Registration System - Reset Password -";

    //process the form if the reset password button is clicked
    if(isset($_POST['passwordResetBtn'])){
    //initialize an array to store any error message from the form
    $form_errors = array();

    //Form validation
    $required_fields = array('email', 'new_password', 'confirm_password');

    //call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    //Fields that requires checking for minimum length
    $fields_to_check_length = array('new_password' => 8, 'confirm_password' => 8);

    //call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    //email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));

    //check if error array is empty, if yes process form data and insert record
    if(empty($form_errors)){
        //collect form data and store in variables
        $email = $_POST['email'];
        $password1 = $_POST['new_password'];
        $password2 = $_POST['confirm_password'];

        //check if new password and confirm password is same
        if($password1 != $password2){
            $result = "<p style='padding:20px; border: 1px solid gray; color: red;'> New password and confirm password does not match</p>";
        }else{
            try{
                //create SQL select statement to verify if email address input exist in the database
                $sqlQuery = "SELECT email FROM users WHERE email =:email";

                //use PDO prepared to sanitize data
                $statement = $db->prepare($sqlQuery);

                //execute the query
                $statement->execute(array(':email' => $email));

                //check if record exist
                if($statement->rowCount() == 1){
                    //hash the password
                    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

                    //SQL statement to update password
                    $sqlUpdate = "UPDATE users SET password =:password WHERE email=:email";

                    //use PDO prepared to sanitize SQL statement
                    $statement = $db->prepare($sqlUpdate);

                    //execute the statement
                    $statement->execute(array(':password' => $hashed_password, ':email' => $email));

                    $result = flashMessage("Password Reset Successful", "Pass");
                }
                else{
                    $result =  flashMessage("The email address provided
                                does not exist in our database, please try again");
                }
            }catch (PDOException $ex){
                $result = flashMessage("An error occurred: " .$ex->getMessage());
            }
        }
    }
    else{
        if(count($form_errors) == 1){
            $result = flashMessage("There was 1 error in the form<br>");
        }else{
            $result = flashMessage("There were " .count($form_errors). " errors in the form<br>");
        }
    }
}
?>
    <div class="resetContainer">
        <div class="resetColumn">
            <div class="resetHeader">
                <h1>Edynak Security Based Registration System</h1>
                <hr>
                <h3>Password Reset Form</h3>
                <div>
                    <?php if(isset($result)) echo $result; ?>
                    <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
                </div>
            </div>
            <div class="resetForm">
                <div class="clearfix"></div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="emailField">Email:</label>
                        <input type="text" name="email" class="form-control" id="emailField" placeholder="Your Email Address">
                    </div>

                    <div class="form-group">
                        <label for="passwordField">New Password:</label>
                        <input type="password" name="new_password" class="form-control" id="passwordField" placeholder="New Password">
                    </div>

                    <div class="form-group">
                        <label for="passwordField">Confirm Password:</label>
                        <input type="password" name="confirm_password" class="form-control" id="passwordField" placeholder="Confirm Password">
                    </div>
                    <button type="submit" name="passwordResetBtn" class="btn btn-primary pull-right">Reset Password</button>
                    <p><a href="index.php">Back</a> </p>
            </form>
            </div>
        </div>
    </div>
<?php include_once 'partials/footers.php'; ?>