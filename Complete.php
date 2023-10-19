<?php
session_start();

$name = $phoneNumber = $preferredContact = "";
$errors = [];

// Check and preserve user data for back-and-forth navigation
if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];
    $name = isset($user_data['name']) ? $user_data['name'] : "";
    $phoneNumber = isset($user_data['phoneNumber']) ? $user_data['phoneNumber'] : "";
    $preferredContact = isset($user_data['preferredContact']) ? $user_data['preferredContact'] : "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Complete</title>
    <style>
        /* Custom CSS styles for this page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        header {
            background-color: #007B5E;
            color: #fff;
            padding: 10px;
        }
        .container {
            background-color: #fff;
            margin: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
        }
        .complete-message {
            margin-top: 20px;
        }
        .error {
            color: #FF0000;
        }
    </style>
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
        <h1>Complete</h1>

        <?php if (!empty($name) && !empty($preferredContact)): ?>
    <div class="complete-message">
        <h2>Thank you, <?= htmlspecialchars($name) ?>, for using our deposit calculation tool.</h2>
        <?php if ($preferredContact === "phone"): ?>
            <p>Our customer service department will call you tomorrow at <?= htmlspecialchars($phoneNumber) ?>.</p>
        <?php else: ?>
            <p>You will receive an email confirmation at <?= htmlspecialchars($user_data['email']) ?>.</p>
        <?php endif; ?>
    </div>
    <?php 
    // Clear the session data related to the user here.
    session_unset();
    session_destroy();
    ?>
<?php else: ?>
    <div class="error">
        <p>There was a problem retrieving your information. Please go back and try again.</p>
    </div>
<?php endif; ?>

    </div>
    <footer>&copy; Algonquin College 2010-2023. All Rights Reserved</footer>
</body>
</html>