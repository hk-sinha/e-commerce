<?php
$conn=mysqli_connect("localhost","root","","deno");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="signin.css">
    <script src="https://kit.fontawesome.com/3efc37e746.js" crossorigin="anonymous"></script>
</head>
<body>
<!-- <div class="lgt" style="text-align: center; position: absolute; top: 10%; left: 50%; transform: translate(-50%, -50%);">
            <p1><span>VISHWANATH DAGDOBA GADAM</span></p1>
        </div> -->
    <div class="container1">
    <span  class="icon-close"><a href="index.php"><i class="fa-solid fa-x"></i></a>
    </span>
    <h2>SIGN UP</h2>
    <p>Your password must be at least 6 characters long. Use a mix of letters, numbers, and special characters for better security.</p>
    <form method="post" id="passwordForm1">
        <div  id="form-group">
            <input type="text" name="FirstName" placeholder="" required>
            <label for="">First Name *</label>
            <i class="fa-solid fa-user"></i>
        </div>
        <div  id="form-group">
            <input type="text" name="LastName" placeholder="" >
            <label for="">Last Name (optional)</label>
            <i class="fa-solid fa-user"></i>
        </div>
        <div  id="form-group">
            <input type="email" name="email" placeholder="" required>
            <label for="">Email *</label>
            <i class="fa-solid fa-envelope"></i>
        </div>
        <div  id="form-group">
            <input type="tel" name="Phone" maxlength="10" 
            pattern="[0-9]{10}" required>
            <!--<input type="integer" name="Phone" placeholder="" required>-->
            <label for="">Phone *</label>
            <i class="fa-solid fa-phone"></i>
        </div>
        <div  id="form-group">
            <input type="password" name="password" id="password1" placeholder="" required>
            <label for="">Password *</label>
            <i class="fa-solid fa-lock"></i>
        </div>
        
        <input type="submit" name="submit" value="Register" id="btn">
        <p><a href="login.php">Already Signed Up? Sign In Now</a></p>
    </form>
    </div>
    <script>
document.getElementById('passwordForm1').addEventListener('submit', function(event) {
    // Get the input values
    var phone = document.getElementById('phone').value;
    var newPassword = document.getElementById('password1').value;

    // Check phone number length
    if (phone.length !== 10) {
        alert('Phone number must be exactly 10 digits.');
        event.preventDefault();
        return;
    }

    // Check password length
    if (newPassword.length < 6) {
        alert('Password must be at least 6 characters long.');
        event.preventDefault();
    }
});
</script>

</body>
<?php
if(isset($_POST['submit'])){
    $FirstName=$_POST['FirstName'];
    $LastName=$_POST['LastName'];
    $email=$_POST['email'];
    $Phone=$_POST['Phone'];
    $password=$_POST['password'];
    $res=mysqli_query($conn,"insert into user (FirstName,LastName,email,Phone,password) values ('$FirstName','$LastName','$email','$Phone','$password')");
    

    if($res){
        echo"<script>
        alert('register successfully');
        window.location.href='login.php';
        </script>";
    }
    else{
        echo "Error";
    }
}


?>


</html>