<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="port" content="=device-width initial-scale=.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/3efc37e746.js" crossorigin="anonymous"></script>
</head>
<body>
    <video autoplay loop muted plays-inline class="back-video">
            <source src="Car Rentel Website Images/img/stock5_3_1.mp4" type="video/mp4" controllist="nodownload">
    </video>
    <div class="container">
    <span  class="icon-close"><a href="home.php"><i class="fa-solid fa-x"></i></a></span>
    <h2>CHANGE PASSWORD</h2>
    <p>Create a new password that is at least 6 characters long. A strong password has a combination of letters, digits and punctuation marks.</p>
    
    <?php
    session_start();
    include 'config.php';
    $email = $_SESSION['email'];

    if (isset($email)) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];

            if ($password == $cpassword) {
                /*$password = md5($password);*/ // Hash the password before storing it in the database
                $sql = "UPDATE user SET Password='$password' WHERE email='$email'";
                $result = $conn->query($sql);

                if ($result) {
                    echo "<script>
                    alert('Password changed successfully!!');
                    window.location.href='home.php';
                    </script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "<p style='color:red;'>Passwords do not match.</p>";
            }
        }
    } else {
        echo "<script>window.location.href='login.php';</script>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <input type="password" name="password" value="" placeholder="" required>
            <label for="">New Password</label>
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="form-group">
            <input type="password" name="cpassword" value="" placeholder="" required>
            <label for="">Confirm New Password</label>
            <i class="fa-solid fa-lock"></i>
        </div>
        <input type="submit" name="submit" value="Save Changes" id="btn">
    </form>
    </div>
    <script>
    document.getElementById('passwordForm1').addEventListener('submit', function(event) {
    var newPassword = document.getElementById('password1').value;
    if(newPassword.length < 6) {
        alert('Password must be at least 6 characters long.');
        event.preventDefault();
    }
});
</script>
</body>
</html>