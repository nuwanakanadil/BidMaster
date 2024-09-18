<?php
require_once '../config.php';
require_once '../functions.php';

if (isset($_POST["submit"]))
{
   //Assign user entered values to php variables

    $username = $_POST["user-name"];
    $new_psw = $_POST["new-password"];
    $re_new_psw = $_POST["re-new-password"];
   


//calling error handling fucntions with parameters and Assign returned values of error handling fucntions which defined in function.php to php variables

$emptyInputFields =  emptyChangePsw($username,$new_psw,$re_new_psw);
$newPswMatch =  pswmatch($new_psw,$re_new_psw);
$PasswordExists = checkPasswordExists($new_psw,$conn);

//error handlings

if($emptyInputFields !== false)
{
    //if input sections are empty, system indicate an alert and exit from Passwrod changing process.

    echo "<script>alert('emptyinputs');
    window.location.href = '../Login.php?error=emptyinputs';
    </script>";
    exit();
}
if($PasswordExists !== false)
{
    //if password is already taken system indicate an alert and exit from password changing process

    echo "<script>alert('Password is already taken.use different password');
    window.location.href = './forgot_psw';
    </script>";
    exit();

}

if($newPswMatch !== false)
{
    //if password and re entered password don't match system indicate an alert and exit from Passwrod changing process

    echo "<script>alert('re-enter password is incorrect');
    window.location.href = './forgot_psw.html';
    </script>";
    exit();

}



// SQL query to check if the username exists in the database
$sql = "SELECT COUNT(*) AS userCount FROM RegisteredBidder WHERE UserName = ?";
$params = array($username);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the result
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($row['userCount'] > 0) {
    //create sql querry to update password in database and execute it using sqlsrv extension.  

    $sql = "UPDATE RegisteredBidder  SET Password = ? WHERE UserName = ?";
    $param = array($new_psw,$username);       //add variables into an array
    $stmt = sqlsrv_query($conn,$sql,$param);     //pass connection,sql querry and its parameters

    if($stmt === false)
    {
        //if there is an error in executing sql querry,print the error

        die(print_r(sqlsrv_errors(),true));
    }
    else
    {
        //give and alert to user password changed successfull and redirect to login page.

        echo "<script>alert('Password changed successfully');
            window.location.href = '../Login/Login.html';
            </script>";

    }

}
else {
    // If the username does not exist, alert 'Invalid user'
    echo "<script>
            alert('Invalid user.please register to the system');
            window.location.href = '../Signup/signup.html';
          </script>";
          exit();
}




// Close the connection

sqlsrv_close($conn);

}