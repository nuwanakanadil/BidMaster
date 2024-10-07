<?php
    session_start();
    
    //check if the user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== true) {
        header("Location: ../Login/Login.php");
        exit();
    }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Page</title>
    <!-- Link to external CSS files for styling -->
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="seller.css"> <!-- Additional CSS for seller page styling -->
</head>
<body>
    <!-- Main container for the content -->
    <div class="container">
    
    <!-- Header section with logo and navigation links -->
    <header>
        <img src="/Signup,Login,Forgotpsw,Delete Acnt/logo.jpg" alt="Logo" class="logo">
        <nav>
            <a href="../"><i class="fas fa-home"></i>Home</a> /
            <a href="/About Us, Seller Homepage, Seller Add Items, User Homepage/About Us/About.html"><i class="fas fa-info-circle"></i>About</a> /
            <a href="/Contact Us, Feedback/Contact Us/ContactUs.html"><i class="fas fa-envelope"></i>Contact Us</a>
        </nav>
    </header>
    <hr> <!-- Horizontal rule for separation -->

    <!-- Button for posting a new item, centered on the page -->
    <center>
        <a href="../SellerAddItems/selleritem.html"><button class="custom-button"><b>POST YOUR ITEM</b></button></a>
        <br><br>

        <!-- Include the PHP file to display seller items -->
        <?php include 'seller_Item_Read.php'; ?>
    </center>

    <!-- Footer section with additional navigation and social media links -->
    <footer>
        <nav class="footer-nav">
            <ul>
                <li><a href="/admin_dashboard, bids, home_signed, payment, user management/home_signed/home.html">Home</a></li>
                <li><a href="/About Us, Seller Homepage, Seller Add Items, User Homepage/About Us/About.html">About us</a></li>
                <li><a href="/Contact Us, Feedback/Contact Us/ContactUs.html">Contact us</a></li>
            </ul>
            
        </nav>
        <div class="social-media">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            
        </div>
        <div class="logo-container">
        <img src="/Signup,Login,Forgotpsw,Delete Acnt/logo.jpg" alt="Logo" class="footer-logo">
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 BIDMASTER ONLINE AUCTION. All rights reserved</p>
            <div class="legal-links">
                <a href="/login_admin, register_admin, admin_forgotpsd, Privacy Page, FAQs/FAQs/faq.html">FAQs</a>
                <a href="/login_admin, register_admin, admin_forgotpsd, Privacy Page, FAQs/Privacy Page/privacy page.html">Privacy Policy</a>
            </div>
        </div>
    </footer>
</body>
</html>
