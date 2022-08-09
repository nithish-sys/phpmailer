<?php
//db mysql connection------------------------------------------ 
include 'connect.php';
$subject = "otp to subscribe to kxcd comics";
$message = rand(100000, 999999);
$from = "nithishnithin999@gmail.com";
$headers = "From : $from";
$headers =  'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: KXCD comics <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
?>
<?php
require("smtp.php");
require("sasl.php"); //SASL authentication
$from="support@yourwebsite.com";
$smtp=new smtp_class;
$smtp->host_name="www.website.com"; // Or IP address
$smtp->host_port=25;
$smtp->ssl=0;
$smtp->start_tls=0;
$smtp->localhost="localhost";
$smtp->direct_delivery=0;
$smtp->timeout=10;
$smtp->data_timeout=0;
$smtp->debug=1;
$smtp->html_debug=1;
$smtp->pop3_auth_host="";
$smtp->user="support@website.com"; // SMTP Username
$smtp->realm="";
$smtp->password="password"; // SMTP Password
$smtp->workstation="";
$smtp->authentication_mechanism="";

if($smtp->SendMessage(
$from,
array(
$to
),
array(
"From: $from",
"To: $to",
"Subject: $subject"
),
"$message"))
{
echo "Message sent to $to OK.";
}
else{
echo "Cound not seend the message to $to.\nError: ".$smtp->error;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>random XKCD</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <h1 class="welcome" style="background-color:black; color:white;">Welcome to XKCD random comics section</h1>
    <marquee id="reg" behavior="alternate" direction="left">Signup to get random XKCD comics</marquee>
    <div class="box">
        <form id="login" method="POST">
            <label for="email" id="mail">Enter email</label>
            <input id="email" type="email" placeholder="enter mail" name="user_mail" required>
            <br>
            <input type="submit" name="register" class="sendOtp">
            <!-- <?php if (isset($_POST["register"])) {
                $to = $_POST['user_mail'];
                $users = array();
                $sql = "select * from `subscriber` where active=1";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $user = $row['userMail'];
                        array_push($users, $user);
                    }
                }
                if (!in_array($to, $users)) {
                    $sql = "insert into `subscriber` (userMail,otp)
        values('$to','$message')";
                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        if (mail($to, $subject, $message, $headers)) {
                            echo "mail send";
                        } else {
                            $msg = error_get_last();
                            echo $msg;
                        }
                        print_r($msg);
                        print_r(error_get_last());
                        $sql = "select * from `subscriber` order by id desc";
                        $result = mysqli_query($con, $sql);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['id'];
                        }
                        // header("location:otp.php?id=$id");
                    } else {
                        die(mysqli_error($con));
                    }
                } else {
                    echo "<p>already exist</p>";
                }
            } ?> -->
        </form>


    </div>
    <script src="index.js"></script>
</body>

</html>