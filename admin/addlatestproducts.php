<?php 
/*error_reporting(0);*/
$conn= mysqli_connect("localhost","root","","deno");

$res=mysqli_query($conn,"select * from categories");
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
            <label for="">Product Name</label>
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="form-group">
        <select name="category">

    <option default>Select Category</option>
        <?php 
            while($rs=mysqli_fetch_array($res)){
        ?>
    <option value=<?php echo $rs['id'] ?>><?php echo $rs['name'] ?></option>
        <?php
        }
        ?>
        </select>
            <label for=""></label>
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="form-group">
            <input type="int" name="stock">
            <label for="">Stock</label>
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="form-group">
        <input type="file" name="img">
            <label for="">Product image</label>
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="form-group">
            <input type="decimal" name="pre-price">
            <label for="">Previuous Price</label>
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="form-group">
            <input type="decimal" name="price">
            <label for="">Product Price</label>
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
<input type="submit" name="submit" value="Submit" id="btn">
</form>
    
</body>

<?php
if(isset($_POST['submit'])){

    $name=$_POST['pname'];
    $category=$_POST['category'];
    $stock=$_POST['stock'];
    $img=$_FILES['img']['name'];
    $pre_price=$_POST['pre-price'];
    $price=$_POST['price'];

    move_uploaded_file($_FILES['img'] ['tmp_name'],'image/'.$img);

    $sql="insert into latest (product_name,product_img,pre_price, price) values ('$name','$img','$pre_price','$price')";
    $sql1="insert into products (product_name,category, product_img_main,stock, price) values ('$name','$category','$img','$stock','$price')";
    $res1=mysqli_query($conn,$sql);
    $res2=mysqli_query($conn,$sql1);

    if($res1 && $res2){
    echo "<script>alert('insert successfully');</script> ";
    }else{
        echo "<script>alert('insert failed');</script> ";
    }
}



?>
</html>