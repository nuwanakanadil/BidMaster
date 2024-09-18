<?php

//start session

session_start();

require_once '../config.php';
require_once '../functions.php';

if (isset($_POST["submit"]))
{
   
    //Assign user entered values to php variables

    $username = $_POST["user-name"];
    $psw = $_POST["password"];
   

//calling error handling fucntions with parameters and Assign returned values of error handling fucntions which defined in function.php to php variables
    
$emptyFields = emptyLogin($username,$psw);

//error handlings

if($emptyFields !== false)
{

    //if input sections are empty, system indicate an alert and exit from Login process.


    echo "<script>alert('emptyinputs');
    window.location.href = './Login.html';
    </script>";
    exit();
}

//create sql querry to fetch username and its password  in database and execute it using sqlsrv extension.

$sql = "SELECT Password  FROM RegisteredBidder WHERE UserName = ?";
$param = array($username);  //add variable into an array
$stmt = sqlsrv_query($conn,$sql,$param);   //pass connection,sql querry and its parameters

if($stmt === false)
{
    //if there is an error in executing sql querry,print the error

    die(print_r(sqlsrv_errors(),true));
}

if($datarow = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))  //assign associate array which returned from sql querry into a variable
{
    //Check user entered password and database password

    if($psw === $datarow['Password'] )
    {
        //If password is correct,assign session variables

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        echo "<script>alert('Login Successful!');</script>";
    }
    else
    {
        //If password is incorrect,alert user and exit from the login process

        echo "<script>alert('Invalid password.Try again');
        window.location.href = './Login.html';
        </script>";
        exit();

    }
}
else
{
    //If Username is incorrect,alert user and exit from the login process

    echo "<script>alert('Invalid User.Register and try again.');
    window.location.href = '../Signup/signup.html';
    </script>";
    exit();

}

// Close the connection

sqlsrv_close($conn);

}


