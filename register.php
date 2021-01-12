<?php 
    // db connection
    include_once 'core/Database.php';
    // utility file
    include_once 'core/utilities.php';

    // process the form
    if(isset($_POST['registerBtn'])) {
        //initialize an array to store error messages
        $form_errors = array();

        // form validation
        $required_fields = array('first_name', 'last_name', 'username', 'email', 'password', 'confirm_password', 'gender', 'month', 'day', 'year');

        //call the function to check empty field and merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        //Fields that requires checking for minimum length
        $fields_to_check_length = array('first_name' => 2, 'last_name' => 2, 'username' => 4, 'password' => 8, 'confirm_password' =>8);

        //Fields that requires checking for maximum length
        $fields_to_check_max_length = array('first_name' =>15 , 'last_name' =>15 , 'username' => 30, 'password' => 30, 'confirm_password' => 30);

        //call the function to check minimum required length and merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

        //call the function to check maximum required length and merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_max_length($fields_to_check_max_length));
    
        //email validation / merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_email($_POST));

        //password validation / merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_passwords()); 

        //check if error arry is empty, if yes proceed with insert record
        if(empty($form_errors)){

        // collect form data and store in variables
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rePassword = $_POST['confirm_password'];
        $gender = $_POST['gender'];
        $month = $_POST['month'];
        $day = $_POST['day'];
        $year = $_POST['year'];
        $birthday = "{$year}-{$month}-{$day}";

        // encrypt the password 
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try{
            // create SQL insert statement
            $sqlInsert = "INSERT INTO users (first_name, last_name, username, email, password, gender, birthday, joined)
                        VALUES (:first_name, :last_name, :username, :email, :password, :gender, :birthday, now())";

            // use PDO prepared to sanitize data
            $statement = $db->prepare($sqlInsert);

            // use PDO prepared to sanitize data
            $statement = $db->prepare($sqlInsert);

            // add the data into the database
            $statement->execute(array(':first_name' => $firstName,':last_name' => $lastName,':username' => $username, ':email' => $email, ':password' => $hashedPassword, ':gender' => $gender, ':birthday' => $birthday));

            //check if one new row was created
            if($statement->rowCount() == 1){
                $result = "<p style='padding: 20px; border: 1px solid gray; color: green;'> Registration Successful!</p>";
            }

        }catch (PDOException $ex){
            $result = "<p style='padding: 20px; border: 1px solid gray; color: red;'> An error occured: ".$ex->getMessage()."</p>";
        }
    }

    else{
        if(count($form_errors) == 1){
            $result = "<p style='color: red;'> There was 1 error in the form<br>";

        }else{
            $result ="<p style='color: red;'> There were " .count($form_errors). " errors in the form<br>";

            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Registration Page</title>
</head>
<body>
    <h1>Security Based Registration System</h1>
    <hr>
    <h3>Registration Form</h3>

    <?php if(isset($result)) echo $result; ?>
    <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

    <form action="register.php" method="POST">
        <table>
            <div class="name">
                <h5>Name</h5>
                <tr><input type="text" name="first_name" class="form-group" placeholder="First Name" value="">
                <input type="text" name="last_name" class="form-group" placeholder="Last Name" value=""></tr>																	
            </div>        
            <div>
                <h5>Username</h5>
                <tr><td></td><input type="text" name="username" class="form-control" placeholder="Username" value=""></td></tr>
            </div> 
            <br>
            <div>
                <h5>Email</h5>
                <tr><td></td><input type="email" name="email" class="form-control" placeholder="Email" value=""></td></tr>
            </div>
            <br>
            <div>
                <h5>Password</h5>
                <tr><input type="password" name="password" class="form-group" placeholder="Password">
                <input type="password" name="confirm_password" class="form-group" placeholder="Confirm Password"></tr>
            </div>
            <div>
                <fieldset>
                    <legend>Gender</legend>
                    <input id="male" type="hidden" name="gender" value="">
                    <input id="male" type="radio" name="gender" value="male">
                    <label for="male">
                        Male
                    </label>
                    <input id="female" type="radio" name="gender" value="female">
                    <label for="female">
                        Female
                    </label>
                    <input id="idrathernotsay" type="radio" name="gender" value="idrathernotsay">
                    <label for="idrathernotsay">
                        I'd rather not say
                    </label> 
                </fieldset>
            </div>
            <hr>
            <div>
                <fieldset class="date">
                    <legend>Date of Birth</legend>
                    <label for="month">Month</label>
                    <select id="month_start" name="month" />
                    <option  value="" selected>Month</option>    
                    <option value="1">January</option>      
                    <option value="2">February</option>      
                    <option value="3">March</option>      
                    <option value="4">April</option>      
                    <option value="5">May</opcenter>      
                    <option value="6">June</option>      
                    <option value="7">July</option>      
                    <option value="8">August</option>      
                    <option value="9">September</option>      
                    <option value="10">October</option>      
                    <option value="11">November</option>      
                    <option value="12">December</option>      
                    </select> -
                    <label for="day_start">Day</label>
                    <select id="day_start" name="day" />
                    <option  value="" selected>Day</option>    
                    <option>1</option>      
                    <option>2</option>      
                    <option>3</option>      
                    <option>4</option>      
                    <option>5</option>      
                    <option>6</option>      
                    <option>7</option>      
                    <option>8</option>      
                    <option>9</option>      
                    <option>10</option>      
                    <option>11</option>      
                    <option>12</option>      
                    <option>13</option>      
                    <option>14</option>      
                    <option>15</option>      
                    <option>16</option>      
                    <option>17</option>      
                    <option>18</option>      
                    <option>19</option>      
                    <option>20</option>      
                    <option>21</option>      
                    <option>22</option>      
                    <option>23</option>      
                    <option>24</option>      
                    <option>25</option>      
                    <option>26</option>      
                    <option>27</option>      
                    <option>28</option>      
                    <option>29</option>      
                    <option>30</option>      
                    <option>31</option>      
                    </select> -
                    <label for="year_start">Year</label>
                    <select id="year_start" name="year" />
                    <option  value="" selected>Year</option>
                    <option>1915</option>
                    <option>1916</option>
                    <option>1917</option>
                    <option>1918</option>
                    <option>1919</option>
                    <option>1920</option>
                    <option>1921</option>
                    <option>1922</option>
                    <option>1923</option>
                    <option>1924</option>
                    <option>1925</option>
                    <option>1926</option>
                    <option>1927</option>
                    <option>1928</option>
                    <option>1929</option>
                    <option>1930</option>
                    <option>1931</option>
                    <option>1932</option>
                    <option>1933</option>
                    <option>1934</option>
                    <option>1935</option>
                    <option>1936</option>
                    <option>1937</option>
                    <option>1938</option>
                    <option>1939</option>
                    <option>1940</option>
                    <option>1941</option>
                    <option>1942</option>
                    <option>1943</option>
                    <option>1944</option>
                    <option>1945</option>
                    <option>1946</option>
                    <option>1947</option>
                    <option>1948</option>
                    <option>1949</option>
                    <option>1950</option>
                    <option>1951</option>
                    <option>1952</option>
                    <option>1953</option>
                    <option>1954</option>
                    <option>1955</option>
                    <option>1956</option>
                    <option>1957</option>
                    <option>1958</option>
                    <option>1959</option>
                    <option>1960</option>
                    <option>1961</option>
                    <option>1962</option>
                    <option>1963</option>
                    <option>1964</option>
                    <option>1965</option>
                    <option>1966</option>
                    <option>1967</option>
                    <option>1968</option>
                    <option>1969</option>
                    <option>1970</option>
                    <option>1971</option>
                    <option>1972</option>
                    <option>1973</option>
                    <option>1974</option>
                    <option>1975</option>
                    <option>1976</option>
                    <option>1977</option>
                    <option>1978</option>
                    <option>1979</option>
                    <option>1980</option>
                    <option>1981</option>
                    <option>1982</option>
                    <option>1983</option>
                    <option>1984</option>
                    <option>1985</option>
                    <option>1986</option>
                    <option>1987</option>
                    <option>1988</option>
                    <option>1989</option>
                    <option>1990</option>
                    <option>1991</option>
                    <option>1992</option>
                    <option>1993</option>
                    <option>1994</option>
                    <option>1995</option>
                    <option>1996</option>
                    <option>1997</option>
                    <option>1998</option>
                    <option>1999</option>
                    <option>2000</option>
                    <option>2001</option>
                    <option>2002</option>
                    </select>
                    <span class="inst">(Month-Day-Year)</span>
                </fieldset>
            </div>
            <hr>
            <input type="submit" style="float: right;" name="registerBtn" value="Register">
        </table>
    </form>
    <p>Already have an account?<a href="login.php"> Sign in</a></p>
    <p><a href="index.php">Back</a></p> 
</body>
</html>