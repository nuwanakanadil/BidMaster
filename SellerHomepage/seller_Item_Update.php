<?php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Isellername = $_POST["sellerName"];
$Icondition = $_POST["condition"];
$Ibrand = $_POST["brand"];
$Imodel = $_POST["model"];
$Iprice = $_POST["price"];
$Idescription = $_POST["description"];
$Iimages = $_POST["image_path"];
$ItemID = $_POST["Item_ID"];

if(empty($Isellername)||empty($Icondition)||empty($Ibrand)||empty($Imodel)||empty($Iprice)||empty($Idescription)||empty($Iimages)){

    echo "All required";
}
else{
     $updateItemSQL = "UPDATE  bid_items set seller_name= '$Isellername', Condition='$Icondition', Brand='$Ibrand', Model='$Imodel', Price='$Iprice', Description='$Idescription', image_path='$Iimages', WHERE Item_ID = '$ItemID'";
     $updateBidSQL = "UPDATE bids 
                     SET price = '$Iprice' 
                     WHERE Item_ID = '$ItemID'";

if ($conn->query($updateItemSQL) === TRUE && $conn->query($updateBidSQL) === TRUE) {
    echo "Item details updated successfully.";
} else {
    echo "Error updating item: " . $conn->error;
}
}

?>