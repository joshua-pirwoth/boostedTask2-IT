<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap-offline/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="text-center mt-3">
            <h2>Welcome</h2>
        </div>
        <div class="d-flex flex-column  align-items-center mt-3">
            <?php if(isset($_SESSION['name'])){
                echo "<p><strong>Name: </strong>" . $_SESSION['name'] . "</p>";
            } ?>
            <?php if(isset($_SESSION['email'])){
                echo "<p><strong>Email: </strong>" . $_SESSION['email'] . "</p>";
            } ?>
       
            <button class="btn btn-outline-danger mt-2" onclick="logoutConfirm();">Logout</button>
        </div>
    </div>

    <!-- js and jquery files -->
    <script src="bootstrap-offline/js/bootstrap.js"></script>
    <script src="bootstrap-offline/js/code.jquery.com_jquery-3.6.0.js"></script>

    <!-- javascript code -->
    <script>
        function logoutConfirm(){
            if(confirm("Do you really want to logout?")){
                window.location.href = "logout.php";
                <?php
                    session_destroy();
                ?>
            }
        }
    </script>
</body>
</html>