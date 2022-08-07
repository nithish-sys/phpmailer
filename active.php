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

    <?php
        include 'connect.php';
        $users = array();
        $sql = "select * from `subscriber` where active=1";
        $result = mysqli_query($con,$sql);
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                array_push($users,$row['userMail']);
            }
        }
        print_r($users);
            

?>
    <?php
    $boundary = md5('random');
    $header_array = get_headers('https://c.xkcd.com/random/comic',1);
    $url_loc = $header_array['Location'][1];
    $url = $url_loc.'/info.0.json';
    $url_content = file_get_contents($url);
    $url_content = json_decode($url_content);
    $header = "From: XKCD Comics \nReply-To: nithishnithin999@gmail.com \nMIME-Version:1.0 \nContent-Type:multipart/mixed;charset=ISO-8859-1;boundary = $boundary \n";
    $img_content = file_get_contents($url_content->img); 
    $img_encoded_content = base64_encode($img_content);
    $comic_desc = str_replace(array('(', ')', 'alt', '<','>', '"..."', '...'), '', $url_content->transcript);
    $comic_desc = str_replace(array('#'), '<br>',$comic_desc);
    $comic_desc = str_replace(array('[[','{{'), '<br><b>',$comic_desc);
    $comic_desc = str_replace(array(']]','}}'), '<br></b>',$comic_desc);
    $message = "
    <body style='background-color:rgb(238,238,238);padding-top:0px;padding-bottom:10px;text-align:center;border:2px solid #36454F;'>
        <div style='padding:8px;margin:0px auto;background-color:rgb(248,248,248);'>
            <h2>".$url_content->title."</h2>
        </div>
        <img src='".$url_content->img."' alt='".$url_content->alt."'>
        <div style='padding:5px;margin:5px auto;'>
                    <p style='text-align:justify'>".$comic_desc."</p>
                </div>
        <div style='width:100%;text-align:center;padding-top:10px;'>
        <span><a href='#'>Click to Unsubscribe</a></span>
        </div>
    </body>
    ";
    $msg_body = "--$boundary\n";
    $msg_body .= "Content-Type: text/html; charset=ISO-8859-1\n";
    $msg_body .= "Content-Transfer-Encoding: base64\n";
    $msg_body .= chunk_split(base64_encode($message));



    $msg_body .="--$boundary\n";
    $msg_body .="Content-Type: image/*; name=".$url_content->num."\n";
    $msg_body .="Content-Disposition: attachment; filename=".$url_content->num.".png\n";
    $msg_body .="Content-Transfer-Encoding: base64\n";
    $msg_body .="X-Attachment-Id: ".rand(1000, 99999)."\n";
    $msg_body .= $img_encoded_content;
    foreach($users as $Auser){
        $user = $Auser; 
        if(mail($user,"#".$url_content->num." - ".$url_content->title,$msg_body,$header)){
            echo $user." Mail Sent";
        }else{
            echo $user." Mail Not Sent";
        }
    }
    
    ?>
</body>

</html>