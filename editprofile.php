<?php
session_start();
include 'config.php';
$email=$_SESSION['email'];
if (isset($email) ){
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $firstname = $row['FirstName'];
    $lastname = $row['LastName'];
    $mail = $row['email'];
    $phone = $row['Phone'];
    $dob = $row['dob'];
    $address = $row['address'];
    $userid=$row['user_id'];
    /*echo "Welcome, " . $firstname;*/
} else {
    echo "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/3efc37e746.js" crossorigin="anonymous"></script>
</head>
<body>
    <video autoplay loop muted plays-inline class="back-video">
            <source src="Car Rentel Website Images/img/stock4_1.mp4" type="video/mp4" controllist="nodownload">
    </video>
    <div class="container1">
    <span  class="icon-close"><a href="home.php"><i class="fa-solid fa-x"></i></a>
    </span>
    <h2>EDIT PROFILE</h2>
    <form method="post" onsubmit="return confirm('Save changes?')">
        <div class="form-group">
            <input type="text" name="FirstName" value="<?php echo "$firstname"; ?>" placeholder="" required>
            <label for="">First Name</label>
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="form-group">
            <input type="text" name="LastName" value="<?php echo "$lastname"; ?>" placeholder="" required>
            <label for="">Last Name</label>
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="form-group">
            <input type="email" name="email" value="<?php echo "$mail"; ?>" placeholder="" required>
            <label for="">Email</label>
            <i class="fa-solid fa-envelope"></i>
        </div>
        <div class="form-group">
            <input type="text" name="Phone" value="<?php echo "$phone"; ?>" placeholder="" required>
            <label for="">Phone</label>
            <i class="fa-solid fa-phone"></i>
        </div>
        <div class="form-group">
            <input type="text" name="address" value="<?php echo "$address"; ?>" placeholder="">
            <label for="dob">Address</label>
            <i class="fa-solid fa-location-dot"></i>
        </div>
        <div class="form-group">
            <input type="date" name="dob" value="<?php echo "$dob"; ?>" placeholder="">
            <label for="dob">Date Of Birth</label>
            <i class="fa-solid fa-calendar-days"></i>
        </div>
        
        <input type="submit" name="submit" value="Save Changes" id="btn">
        <!--<p><a href="login.php">Already Signed Up? Sign In Now</a></p>-->
    </form>
    </div>
    <?php
if(isset($_POST['submit'])){
    $firstname=$_POST['FirstName'];
    $lastname=$_POST['LastName'];
    $mail=$_POST['email'];
    $phone=$_POST['Phone'];
    $address=$_POST['address'];
    $dob = date('Y-m-d', strtotime($_POST['dob']));
    $res=mysqli_query($conn,"UPDATE `user` SET `email` = '$mail', `FirstName` = '$firstname', `LastName` = '$lastname', `Phone` = '$phone', `dob` = '$dob', `address` = '$address' WHERE `user`.`user_id` ='$userid';");
    

    if($res){
        echo"<script>
        alert('Profile Updated Successfully!!');
        window.location.href='home.php';
        </script>";
    }
    else{
        echo "Error";
    }
}


?>

</body>



</html>