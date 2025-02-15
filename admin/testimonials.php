<?php 
/*error_reporting(0);*/
$conn= mysqli_connect("localhost","root","","deno");

$res=mysqli_query($conn,"select * from brands");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="addcar.css">
    <title>Document</title>
</head>
<body>
<!--<video autoplay loop muted plays-inline class="back-video">
            <source src="Car Rentel Website Images/img/stock4.mp4" type="video/mp4" controllist="nodownload">
    </video>-->
    <!--<div class="container1">-->
    
    
    <h2>ADD NEW CAR</h2>
<form method="post" enctype="multipart/form-data">
<span  class="icon-close"><a href="index.php"><i class="fa-solid fa-x"></i></a>
    </span>

<div class="textbox">
        <div class="form-group">
            <input type="text" name="pname">
            <label for="">Client Name</label>
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="form-group">
        <input type="file" name="img">
            <label for="">User image</label>
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="form-group">
            <input type="text" name="comments">
            <label for="">Comments</label>
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
<input type="submit" name="submit" value="Submit" id="btn">
</form>
    
</body>

<?php
if(isset($_POST['submit'])){

    $name=$_POST['pname'];
    $image=$_FILES['img']['name'];
    $comment=$_POST['comments'];

    move_uploaded_file($_FILES['img'] ['tmp_name'],'image/'.$image);

    $sql="insert into testimonials (name,img_user,comments) values ('$name','$image','$comment')";
    $res1=mysqli_query($conn,$sql);

    if($res1){
    echo "<script>alert('insert successfully');</script> ";
    }
}



?>
</html>