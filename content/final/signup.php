<?php

if( !empty($_POST) ) {
echo "Starting database connection...\n";
$con=mysqli_connect("localhost","root","dominate12","MiddleBrain");

    foreach($_POST as $key => $value) {
        if (!is_array($key)) {
            // sanitize the input data
            if ($key != 'ct_message') $value = strip_tags($value);
            $_POST[$key] = htmlspecialchars(stripslashes(trim($value)));
        }
    }
    
    if( !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmpassword']) ) {
        if( strcmp($_POST['password'], $_POST['confirmpassword']) == 0 && preg_match('/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/i', $_POST['email']) ) {
            $email = $_POST['email'];
            $highscore = 0;
            $password = $_POST['password'];
            $captcha = $_POST['captcha_code'];

            require_once 'libs/securimage/securimage.php';
            $securimage = new Securimage();

            if ($securimage->check($captcha) == true) {
                $salt = "to hell with georgia";
                $encrypted_password = sha1($salt.$password);
                
                mysqli_query($con,"INSERT INTO Users (email, highscore, password) VALUES ('".$email."',".$highscore.", '".$encrypted_password."')");
            }


            
            }
        }   
    }

mysqli_close($con);


?> 