<?php
$conn=mysqli_connect("localhost","root","","deno");
$sql = "SELECT name, img_user , comments FROM testimonials";
$result = $conn->query($sql);

$testimonials = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $testimonials[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($testimonials);

$conn->close();
?>