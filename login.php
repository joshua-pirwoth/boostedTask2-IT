<?php
    session_start();
    include 'authentication.php'; // open database connection
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $password = $_POST['password'];

        $stmt = $conn -> prepare("SELECT * FROM user WHERE name = ?");
        $stmt -> bind_param("s", $name);
        $stmt -> execute();
        $result = $stmt -> get_result();

        if($result -> num_rows > 0) {
            $user = $result -> fetch_assoc();

            if(password_verify($password, $user['password'])){
                $_SESSION['name'] = $user['name'];
                
                header('location: home.php');
            }
            else {
                echo '<p class="text-bg-danger">Incorrect Password!</p>';
            }
        }
        else {
            echo '<p class="text-bg-danger">User Not Found!</p>';
        }
       
        $stmt -> close();
        mysqli_close($conn); // close database connection
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap-offline/css/bootstrap.css" type="text/css">
</head>
<body>
<div class="container">
        <div class="text-center mt-3">
            <h2>Login</h2>
            <p class="lead">Hi and welcome! Hop right in</p>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-lg-6">
                <form action="login.php" class="form-control" name="login_form" method="POST">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="id" class="form-control" name="name" required>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" class="form-control" name="password" required>
                    <input type="submit" class="form-control btn btn-primary mt-3 mb-2" onclick="validate_login();">
                </form>
                <div class="text-center mt-3">
                    <p>Not a member yet? <a class="link-primary" href="register.php">Register here!</a></p>
                </div>
            </div>
         </div>
    </div>

    <!-- js and jquery bootstrap links -->
    <script src="bootstrap-offline/js/bootstrap.js"></script>
    <script src="bootstrap-offline/js/code.jquery.com_jquery-3.6.0.js"></script>

    <!-- javascript code -->
    <script type="text/javascript">

    function validate_login() {
        // validating the name
        if(document.register_form.name.value.trim() == "") {
            alert("Please provide your name!");
            document.register_form.name.focus();
            return false;
        }

        // validating the password
        if(document.register_form.password.value.trim() == "") {
            alert("Please provide your password!");
            document.register_form.password.focus();
            return false;
        }
        else {
            // validating the password length
            if((document.login_form.password.value).length < 8) {
                alert("Please provide a password with at least 8 characters!");
                document.login_form.password.focus();
                return false;
            }
        }
    return true;
}
    </script>
</body>
</html>