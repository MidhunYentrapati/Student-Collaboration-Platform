<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="registration.css">
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
if (isset($_POST['username']))
{
    $var = 0;
    if(isset($_POST['Email']))
    {
    $username = ($_POST['username']);
    $Email = ($_POST['Email']);
    $password = ($_POST['password']);
    
    if(!filter_var($Email, FILTER_VALIDATE_EMAIL))
    {
        $msg = 'The Email you have entered is invalid, please try again.';
        echo $msg;
    }else{

        $query = "INSERT INTO `users` (`username`, `password`, `Email`) VALUES ('$username', '$password', '$Email');"; 
        $result1 = mysqli_query($conn,$query);

        if($result1)
        {
            echo "<div class='form'>
            <h3>You are registered successfully.</h3>
            <br/>Click here to start <a href='main_home.php'>Login</a></div>";
        }
  }  
  $conn->close();
    }
        }
else{
?>

<div class="form">
<h1>Register Here!!</h1>
<form name="registration" action="" method="post">
<input type="text" name="username" placeholder="username" required /><br>
<input type="Email" name="Email" placeholder="Email" required /><br>
<input type="password" name="password" placeholder="Password" required />
<br><br>
<input type="submit" name="submit" value="Click me to Register" id="reg_butt"/>
</form>
</div>
<div align="center">
   Already have an accout? <a href="index.php" id="reg-link">login</a>
</div>
<?php } ?>
</div>
</body>
</html>