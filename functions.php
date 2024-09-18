<?php

require_once 'config.php';

//This function check empty input fields in registration form

function emptyInputSignup($fname,$lname,$username,$email,$address,$nic,$phone_number,$psw,$Reenterpsw){
    $result;
    if(empty($fname) || empty($lname) || empty($username) || empty($email) || empty($address) 
    || empty($nic) || empty($phone_number) || empty($psw) || empty($Reenterpsw))
    {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

//This function check empty input fields in Login form

function emptyLogin($username,$psw)
{
    $result;
    if(empty($username) || empty($psw))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    
    return $result;

}

//This function check empty input fields in Password change form

function emptyChangePsw($username,$new_password,$re_new_passwprd)
{
    $result;
    if(empty($username) ||empty($new_password) || empty($re_new_passwprd))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

//This function check usernames which contain invalid characters in the username.

function invalidUid($username){
    $result;
    if(!preg_match("/[a-zA-Z0-9]+/", $username)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

//This function check valid emails.

function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

//This function check password and re-enter password are equal or not.

function pswmatch($psw,$Reenterpsw){
    $result;
    if($psw !== $Reenterpsw){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

//This function checks whether the username entered by the user has been taken or not.

function checkUsernameExists($username, $conn) {

    // Prepare an SQL statement

    $sql = "SELECT COUNT(*) as count FROM RegisteredBidder WHERE username = ?";
    
    // Prepare the statement

    $stmt = sqlsrv_prepare($conn, $sql, array(&$username));
    
    if ($stmt === false) {

        //if there is an error in executing sql querry,print the error

        die(print_r(sqlsrv_errors(), true));
    }
    
    // Execute the statement

    if (sqlsrv_execute($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    // Fetch the result

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    
    // Close the statement

    sqlsrv_free_stmt($stmt);
    
    // Return true if the username exists, false otherwise

    return $row['count'] > 0;
}

//This function checks whether the password entered by the user has been taken or not.

function checkPasswordExists($psw, $conn)
{
    // Prepare an SQL statement

    $sql = "SELECT COUNT(*) as count FROM RegisteredBidder WHERE Password = ?";

     // Prepare the statement

    $stmt = sqlsrv_prepare($conn, $sql, array(&$psw));

    if ($stmt === false) {

        //if there is an error in executing sql querry,print the error

        die(print_r(sqlsrv_errors(), true));
    }
    
    // Execute the statement

    if (sqlsrv_execute($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    // Fetch the result

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    
    // Close the statement

    sqlsrv_free_stmt($stmt);
    
    // Return true if the username exists, false otherwise
    
    return $row['count'] > 0;

}


?>