<?php
session_start();

// Redirect if not agreed to terms or if no user data
if (!isset($_SESSION['agreed_to_terms']) || !$_SESSION['agreed_to_terms'] || !isset($_SESSION['user_data'])) {
    header("Location: Disclaimer.php");
    exit();
}

$userData = $_SESSION['user_data'];

$contactTimes = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contactTimes = isset($_POST["contactTimes"]) ? $_POST["contactTimes"] : [];

    if (empty($contactTimes)) {
        $contactTimesError = "You must select contact times for us to call you";
    } else {
        $_SESSION['contact_times'] = $contactTimes;
        
        if ($userData['preferredContact'] === 'phone') {
            header("Location: DepositCalculator.php");
            exit();
        } else {
            header("Location: Complete.php");
            exit();
        }
    }
} else {
    // Retrieve previous selections if any
    $contactTimes = isset($_SESSION['contact_times']) ? $_SESSION['contact_times'] : [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Contact Time</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <!-- Header Content -->
    </header>
    <h1>Select Contact Time</h1>
    <form method="post">
        <div>
            <p>When can we contact you? Check all applicable:</p>
            <?php
            $timeSlots = [
                "9am - 10am",
                "10:00am - 11:00am",
                "11:00am - 12:00pm",
                "1:00pm - 2:00pm",
                "2:00pm - 3:00pm",
                "3:00pm - 4:00pm",
                "4:00pm - 5:00pm",
                "5:00pm - 6:00pm",
            ];

            foreach ($timeSlots as $index => $slot) {
                $isChecked = in_array($index, $contactTimes) ? 'checked' : '';
                echo "<label><input type='checkbox' name='contactTimes[]' value='$index' $isChecked>$slot</label><br>";
            }
            ?>
            <?php if (isset($contactTimesError)): ?>
                <p style="color: red;"><?php echo $contactTimesError; ?></p>
            <?php endif; ?>
        </div>
        <button type="submit">Next</button>
    </form>
    <?php if ($userData['preferredContact'] === 'phone'): ?>
        <a href="CustomerInfo.php">Back</a>
    <?php else: ?>
        <a href="DepositCalculator.php">Back</a>
    <?php endif; ?>
    <footer>&copy; Algonquin College 2010-2023. All Rights Reserved</footer>
</body>
</html>