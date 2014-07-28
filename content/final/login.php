<?php
session_start();

if( !empty($_POST) ) {
    if( !empty($_POST['email']) && !empty($_POST['password']) ) {
        foreach($_POST as $key => $value) {
            if (!is_array($key)) {
                // sanitize the input data
                if ($key != 'ct_message') $value = strip_tags($value);
                $_POST[$key] = htmlspecialchars(stripslashes(trim($value)));
            }
        }
        $email = $_POST['email'];
        $password = $_POST['password'];

        
        if( preg_match('/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/i', $email) ) {

            $con=mysqli_connect("localhost","root","**********","MiddleBrain");
            // Check connection
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            } else {
                echo "Successfully connected.";
            }
            
            $result = mysqli_query($con, "SELECT * FROM Users WHERE email='$email'");
            $row = mysqli_fetch_array($result);

            $user = $row['email'];
            $pwd = $row['password'];
            if( strcasecmp($user, $email) == 0 ) {
                $salt = "to hell with georgia";
                $encrypted_password = sha1($salt.$password);
                if( $row['password'] == $encrypted_password ) {
                    $_SESSION['username']=$user;
                    header( 'Location: default.php' ) ;
                }
            }
        }
    }
}




?>
