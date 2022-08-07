<?php

include 'connect.php';
$sql = "select * from `subscriber` order by id desc";
$result = mysqli_query($con,$sql);
if($result){
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $otp = $row['otp'];
    $userMail = $row['userMail'];
}
if(isset($_POST['conform'])){
    $conformotp = $_POST['conformotp'];
    if($otp === $conformotp){
        $sql = "delete from `subscriber` where userMail='$userMail'"; 
        $result = mysqli_query($con,$sql);
    if($result){
        header('location:index.php');
        echo "success";
    }else{
        die(mysqli_error($con));
        echo "<h3>wrong otp</h3>";
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XKCD Mailer</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <h1 class="welcome" style="background-color:black; color:white;">Welcome to XKCD random comics section</h1>
    <div class="box">
        <form id="login" action="" method="POST">
            <label style="font-size:1.5em;" for="otp" id="Lotp">Enter otp </label>
            <input style="    background-color:rgb(220, 201, 201);margin-left:2em;width: 15em;height:2em;" id="Cotp"
                type="number" placeholder="enter otp" name="conformotp" required>
            <br>
            <input type="submit" name="conform" class="sendOtp">
        </form>
    </div>
</body>

</html>