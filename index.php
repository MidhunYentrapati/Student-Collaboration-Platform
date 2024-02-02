<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>



<style>

</style>

</head>

<body>

    <header>
        <div class="container">
            <h1>Neo Project</h1>
            <nav>
                <a href="welcome.php">Home</a>
                <a href="welcome.php">About</a>
                <a href="welcome.php">services</a>
            </nav>
        </div>
    </header>
    <div class="grid-container">
        <div class="item1">
            <img src="images/img2.jpg" alt="Login Image">
        </div>
        <div class="item2">
            <?php
            require('db.php');
            session_start();
            
            if (isset($_POST['username'])){
            
                $username = $_REQUEST['username'];
                $password = ($_REQUEST['password']);
               
                $query = "SELECT * FROM `users` WHERE `username`='$username' and `password`='' + '$password'";
                $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
                $rows = mysqli_num_rows($result);
                    if($rows==1){
                    $_SESSION['username'] = $username;
                    header("Location: main_home.php");
                     }else{
                echo "<div class='form'>
            <h3>Username/password is incorrect.</h3>
            <br/>Click here to <a href='index.php'>Login</a></div>";
                }
                }else{
            ?>
            <div>
            <div class="form">
            <h1 id="logintext">Log In</h1>
            <form action="" method="post" name="login">
            
            
            
            
            
            
            <input type="text" name="username" placeholder="Username" required /><br>
            <input type="password" name="password" placeholder="Password" required />
            <br><br><br>
            <input name="submit" type="submit" value="Login" id="log_butt"/>
            </form>
            <p>Not registered yet? <a href='registration.php' id="reg-link">Register Here</a></p>
            </div>
            </div>
            <?php } ?>
    </div>
</body>
</html>