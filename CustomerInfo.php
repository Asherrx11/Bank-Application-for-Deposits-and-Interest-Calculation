<?php
session_start();

// Check if the user has agreed to the terms and conditions
if (!isset($_SESSION['agreed_to_terms']) || !$_SESSION['agreed_to_terms']) {
    header("Location: Disclaimer.php");
    exit();
}

$name = $postalCode = $phoneNumber = $email = $preferredContact = "";
$errors = [];

if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];
    $name = $user_data['name'];
    $postalCode = $user_data['postalCode'];
    $phoneNumber = $user_data['phoneNumber'];
    $email = $user_data['email'];
    $preferredContact = $user_data['preferredContact'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $postalCode = $_POST["postalCode"];
    $phoneNumber = $_POST["phoneNumber"];
    $email = $_POST["email"];
    $preferredContact = isset($_POST["preferredContact"]) ? $_POST["preferredContact"] : "";

    if (empty($name)) {
        $errors["name"] = "Name is required.";
    }

    if (!preg_match("/^[A-Za-z]\d[A-Za-z] ?\d[A-Za-z]\d$/", $postalCode)) {
        $errors["postalCode"] = "Incorrect Postal Code";
    }

    if (!preg_match("/^[2-9]\d{2}-[2-9]\d{2}-\d{4}$/", $phoneNumber)) {
        $errors["phoneNumber"] = "Incorrect Phone Number";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Incorrect Email Address";
    }

    if (empty($preferredContact)) {
        $errors["preferredContact"] = "Contact method is required";
    }

    if (empty($errors)) {
        $_SESSION['user_data'] = [
            'name' => $name,
            'postalCode' => $postalCode,
            'phoneNumber' => $phoneNumber,
            'email' => $email,
            'preferredContact' => $preferredContact,
        ];

        if ($preferredContact === 'email') {
            header("Location: DepositCalculator.php");
        } elseif ($preferredContact === 'phone') {
            header("Location: ContactTime.php");
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information</title>
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
    
    <h1>Customer Information</h1>
    <form method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?= $name ?>">
            <?php if (isset($errors["name"])) : ?>
                <div style="color: red;"><?= $errors["name"] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label for="postalCode">Postal Code:</label>
            <input type="text" name="postalCode" value="<?= $postalCode ?>">
            <?php if (isset($errors["postalCode"])) : ?>
                <div style="color: red;"><?= $errors["postalCode"] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" value="<?= $phoneNumber ?>" placeholder="(nnn-nnn-nnnn)">
            <?php if (isset($errors["phoneNumber"])) : ?>
                <div style="color: red;"><?= $errors["phoneNumber"] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label for="email">Email Address:</label>
            <input type="email" name="email" value="<?= $email ?>">
            <?php if (isset($errors["email"])) : ?>
                <div style="color: red;"><?= $errors["email"] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label>Preferred Contact Method:</label>
            <input type="radio" name="preferredContact" value="phone" <?= $preferredContact === "phone" ? 'checked' : '' ?>> Phone
            <input type="radio" name="preferredContact" value="email" <?= $preferredContact === "email" ? 'checked' : '' ?>> Email
            <?php if (isset($errors["preferredContact"])) : ?>
                <div style="color: red;"><?= $errors["preferredContact"] ?></div>
            <?php endif; ?>
        </div>
        <button type="submit">Next</button>
    </form>
    <footer>&copy; Algonquin College 2010-2023. All Rights Reserved</footer>
</body>
</html>