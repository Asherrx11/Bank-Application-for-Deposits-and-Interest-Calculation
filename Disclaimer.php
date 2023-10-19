<?php
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agree"])) {
        // Set a session variable to track the agreement
        $_SESSION['agreed_to_terms'] = true;
        header("Location: CustomerInfo.php");
        exit();
    } else {
        $error = "You must agree to the terms and conditions!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

    <!-- Add necessary CSS styles here if needed -->
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
    
    <div>
        <h1>Terms and Conditions</h1>
        <p>I agree to abide by the Bank's Terms and Conditions and rules in force and the changes thereto in Terms and Conditions from time to time relating to my account as communicated and made available on the Bank's website.</p>
        <p>I agree that the bank, before opening any deposit account, will carry out a due diligence as required under Know Your Customer guidelines of the bank. I would be required to submit necessary documents or proofs, such as identity, address, photograph, and any such information. I agree to submit the above documents again at periodic intervals, as may be required by the Bank.</p>
        <p>I agree that the Bank can at its sole discretion amend any of the services/facilities given in my account either wholly or partially at any time by giving me at least 30 days' notice and/or provide an option to me to switch to other services/facilities.</p>
    </div>
    <form method="post">
        <label for="agree">I have read and agree with the terms and conditions</label>
        <input type="checkbox" name="agree" required>
        <button type="submit">Start</button>
    </form>
    <?php if (isset($error)) : ?>
        <div style="color: red;">You must agree to the terms and conditions!</div>
    <?php endif; ?>
        <footer>&copy; Algonquin College 2010-2023. All Rights Reserved</footer>
</body>
</html>