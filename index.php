<?php
session_start();

$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page != "Disclaimer.php" && $current_page != "index.php" && !isset($_SESSION['agreed_to_terms'])) {
    header("Location: Disclaimer.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Algonquin Bank</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
       <div class="logo">
            <img src="image.jpg" alt=""/>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="Disclaimer.php">Terms and Conditions</a></li>
                <li><a href="CustomerInfo.php">Customer Information</a></li>
                <li><a href="DepositCalculator.php">Calculator</a></li>
                <li><a href="Complete.php">Complete</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Welcome to Algonquin Bank</h1>
        <p>Algonquin Bank is Algonquin College students' most loved bank. We provide a set of tools for Algonquin College students to manage their finance.</p>
        <a href="Disclaimer.php">Deposit Calculator</a>
    </div>
    <footer>&copy; Algonquin College 2010-2023. All Rights Reserved</footer>
</body>
</html>
