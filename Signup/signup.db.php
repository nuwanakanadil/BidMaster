<?php

//require autoload.php from composer to autoload the PHPMailer classes to send emails.

require '../vendor/autoload.php';
    
    //use namespaces

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

require_once '../config.php';
require_once '../functions.php';

if (isset($_POST["submit"]))
{
    //Assign user entered values to php variables

    $fname = $_POST["first-name"];
    $lname = $_POST["last-name"];
    $username = $_POST["user-name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $nic = $_POST["nic"];
    $phone_number = $_POST["phone-number"];
    $psw = $_POST["password"];
    $Reenterpsw = $_POST["re-password"];
   
  
    // Instantiation of PHPMailer

    $mail = new PHPMailer(true);



//calling error handling fucntions with parameters and Assign returned values of error handling fucntions which defined in function.php to php variables

$emptyInput = emptyInputSignup($fname,$lname,$username,$email,$address,$nic,$phone_number,$psw,$Reenterpsw);
$invalidUid =  invalidUid($username);
$invalidEmail=  invalidEmail($email);
$pswmatch   =  pswmatch($psw,$Reenterpsw);
$userNameExists = checkUsernameExists($username, $conn);
$PasswordExists = checkPasswordExists($psw,$conn);

//error handlings

if($emptyInput !== false){

    //if input sections are empty system indicate an alert and exit from submitting process.
    
    echo "<script>alert('emptyinputs');
    window.location.href = './signup.html';
    </script>";
    exit();

}
if($invalidUid !== false){

    //if username is invalid system indicate an alert and exit from submitting process.

    echo "<script>alert('Invalid UID');
     window.location.href = './signup.html';
    </script>";
    exit();
}
if($invalidEmail !== false){

    //if email is invalid system indicate an alert and exit from submitting process.

    echo "<script>alert('Invalid Email');
    window.location.href = './signup.html';
    </script>";
    exit();

}
if($pswmatch !== false){

    //if password and re entered password don't match system indicate an alert and exit from submitting process

    echo "<script>alert('re-enter password is incorrect');
    window.location.href = './signup.html';
    </script>";
    exit();

}
if($userNameExists !== false)
{
    //if username is already taken system indicate an alert and exit from submitting process

    echo "<script>alert('User name is already taken.Use different name'); 
    window.location.href = './signup.html';
    </script>";
    exit();
     
}
if($PasswordExists !== false)
{
    //if password is already taken system indicate an alert and exit from submitting process

    echo "<script>alert('Password is already taken.use different password');
    window.location.href = './signup.html';
    </script>";
    exit();

}

//create sql querry and execute it using sqlsrv extension.  
    
$sql = "INSERT INTO RegisteredBidder (F_Name,L_Name,UserName,Email,Address,NIC,Phone_No,Password) VALUES (?,?,?,?,?,?,?,?);";
$params = array($fname,$lname,$username,$email,$address,$nic,$phone_number,$psw);   //add variables into an array
$stmt = sqlsrv_query($conn,$sql,$params);    //pass connection,sql querry and its parameters


if ($stmt === false) {

    //if there is an error in executing sql querry,print the error

    die(print_r(sqlsrv_errors(), true));

} else {
   
    //create email template and it's configurations

    try {
        // Server settings

        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';  // Brevo SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = '7c3967001@smtp-brevo.com';  // Brevo username
        $mail->Password = 'LOGtfDadpWBzYjhE';  // Brevo password
        $mail->SMTPSecure = 'tls';  // Enable TLS encryption
        $mail->Port = 587;
    
        // Recipients

        $mail->setFrom('wwwabcdef577@gmail.com', 'BidMaster');
        $mail->addAddress($email, $username);
    
        // Email content

        $mail->isHTML(true);
        $mail->Subject = 'Welcome to BIDMASTER - Thank You for Registering!';
        $mail->Body    = "
        <!DOCTYPE html>
        <html lang=\"en\">
        <body style=\"font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;\">

            <div style=\"max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 10px;\">
                <h2 style=\"color: #0056b3;font-size: 20px;text-align:center;\">Welcome to <b>BIDMASTER!</b></h2>
                <p style = \"font-size: 15px;\">Hi <strong>$username</strong>,</p>
                <p style = \"font-size: 15px;\">Thank you for joining <b>BIDMASTER</b>! We are excited to have you on board.</p>
                <p style = \"font-size: 15px;\">You can now access your account and start exploring all the features we offer. Feel free to reach out if you have any questions or need any assistance.</p>
                <h3 style=\"color: black;font-size: 15px;\">Here's what you can do next:</h3>
                <ul style = \"font-size: 15px;\">
                    <li>Complete your profile</li>
                    <li>Browse through our products/services</li>
                    <li>Participate in upcoming auctions (if applicable)</li>
                </ul>
                <p style = \"font-size: 15px;\">We hope you enjoy your experience with us. If you have any issues, don't hesitate to contact our support team.</p>
                <p style=\"color: #777;\">Best regards, <br> BIDMASTER</p>
                <hr style=\"border: 1px solid #ddd;\">
                <p style=\"font-size: 12px; color: #999;\">You are receiving this email because you recently signed up for BIDMASTER . If this was not you, please contact us.</p>
            </div>

        </body>
        </html>";



        // Send the email

        $mail->send();
        
    } catch (Exception $e) {

        //if there is an error in sending email.

        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    //give and alert to user registration was successfull and redirect to login page.

    echo "<script>alert('Successfully Registered.Please check your email to confirmation.');
        window.location.href = '../Login/Login.html';
        </script>";

}


// Close the connection

sqlsrv_close($conn);

}
?>