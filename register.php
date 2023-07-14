<?php
include 'authentication.php'; // open database connection

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = array(); // array that stores error messages as strings
    // validate the name
    if(empty($_POST['name'])){
        $errors[] = "Name is required"; // error message added as a string member of the array $errors[]
    }
    else{
        $name = $_POST['name'];
    }

    // validate the password
    if(empty($_POST['password'])){
        $errors[] = "Password is required";
    }
    else{
        $password = $_POST['password'];

        //check for password length
        if(strlen($password)<8){
            $errors[] = 'Password should have at least 8 characters';
        }
        else{
            // password hashing
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    // validate the email
    if(empty($_POST['email'])){
        $errors[] = "Email is required";
    }
    else{
        $email = $_POST['email'];

        // validating the email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors []= "Invalid email format";
        }
    }    
    
    // inserting data into the database if there are no errors encountered
    if(empty($errors)){
        $stmt = $conn -> prepare("INSERT INTO user(name, email, password) VALUES(?,?,?)");
        $stmt -> bind_param("sss", $name, $email, $password);
        $stmt -> execute();
        $stmt -> close();

        // Redirect user to login at login.php
        header("Location: login.php");
        // exit;
    }
    else{
        echo '<h1>Errors!</h1>
              <p>Error(s) Encountered:<br>';

            foreach($errors as $msg){
                echo "- $msg <br>";
            }
            echo '</p><p>PLEASE <a href="register.php">TRY AGAIN</a>!</p>';
    }

    mysqli_close($conn); // close database connection
}
?>

<!-- HTML code, with JavaScript within -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="bootstrap-offline/css/bootstrap.css">
</head>
<body>
<div class="container">
        <div class="text-center mt-3">
            <h2>Register</h2>
            <p class="lead">Not a member yet? Jump in to get the best experience!</p>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-lg-6">
                <form action="register.php" class="form-control" name="register_form" method="POST">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="id" class="form-control" name="name" required>
                    <label for="email" class="form-label">Email</label>
                    <input type="text" id="email" class="form-control" name="email" required>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" class="form-control" name="password" required>
                    <label for="confPassword" class="form-label">Confirm Password</label>
                    <input type="password" id="confPassword" class="form-control" name="confPassword" required>
                    <input type="submit" class="form-control btn btn-primary mt-3 mb-2" onclick="validate_reg();">
                </form>
                <div class="text-center mt-3">
                    <p>Already have an account? <a class="link-primary" href="login.php">Login here!</a></p>
                </div>
            </div>
         </div>
    </div>

    <!-- js and jquery bootstrap links -->
    <script src="bootstrap-offline/js/bootstrap.js"></script>
    <script src="bootstrap-offline/js/code.jquery.com_jquery-3.6.0.js"></script>

    <!-- javascript code -->
    <script type="text/javascript">
        function validate_reg() {
    // validating the name
    if(document.register_form.name.value.trim() == "") {
        alert("Please provide your name!");
        document.register_form.name.focus();
        return false;
    }
    
    // validating the email
    if(document.register_form.email.value.trim() == "") {
        alert("Please provide your email!");
        document.register_form.email.focus();
        return false;
    }
    else {
        // validating the email format
        var emailInput = document.register_form.email.value;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var isValid = emailRegex.test(emailInput);
  
        if (!isValid) {
          alert("Invalid email address!");
          return false;
        }        
    }

    // validating the password
    if(document.register_form.password.value.trim() == "") {
        alert("Please provide your password!");
        document.register_form.password.focus();
        return false;
    }
    else {
        // validating the password length
        if((document.register_form.password.value).length < 8) {
            alert("Please provide a password with at least 8 characters!");
            return false;
        }
    }

    // validating the confirmation password
    if(document.register_form.confPassword.value.trim() == "") {
        alert("Please provide your confirmation password!");
        document.register_form.confPassword.focus();
        return false;
    }
    else {
        //validating the similarity of the two passwords
        if(document.register_form.password.value != document.register_form.confPassword.value) {
            alert("Please provide passwords that are exactly the same!");
            return false;
        } 
    }
    return true;
}
    </script>
</body>
</html>