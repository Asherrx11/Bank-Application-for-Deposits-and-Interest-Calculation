<?php
session_start();

if (!isset($_SESSION['agreed_to_terms']) || !$_SESSION['agreed_to_terms']) {
    header("Location: Disclaimer.php");
    exit();
}
$principal = $time = $interestRate = $total = $interest = 0;
$errors = [];

$previousPage = "CustomerInfo.php"; // default previous page

// Check if preferredContact is set and adjust the previous page accordingly
if (isset($_SESSION['user_data']['preferredContact'])) {
    $previousPage = $_SESSION['user_data']['preferredContact'] === "phone" ? "ContactTime.php" : "CustomerInfo.php";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $principal = isset($_POST["principal"]) ? floatval($_POST["principal"]) : 0;
    $time = isset($_POST["time"]) ? intval($_POST["time"]) : 0;

    if ($principal > 0 && $time > 0) {
        $interestRate = 0.03;
        $interest = $principal * $interestRate * $time;
        $total = $principal + $interest;
    } else {
        $errors[] = "Principal amount and time must be greater than 0.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Calculator</title>
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
        <h1>Deposit Calculator</h1>
        <p>Enter principal amount and select the number of years to deposit.</p>

        <form method="post">
            <!-- Your form fields here -->
            <div class="form-group">
                <label for="principal">Principal Amount:</label>
                <input type="text" id="principal" name="principal" value="<?= htmlspecialchars($principal) ?>">
            </div>

            <div class="form-group">
                <label for="time">Years to Deposit:</label>
                <select id="time" name="time">
                    <option value="">Select...</option>
                    <?php for ($i = 1; $i <= 15; $i++): ?>
                        <option value="<?= $i ?>"<?= $i === $time ? ' selected' : '' ?>><?= $i ?> Years</option>
                    <?php endfor; ?>
                </select>
            </div>

            <input type="submit" value="Calculate">
        </form>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($total > 0): ?>
            <h2>Results of the calculation at the current interest rate of 3%</h2>
            <table>
    <tr>
        <th>Year</th>
        <th>Principal at Year Start</th>
        <th>Interest for the Year</th>
    </tr>
    <?php
    $principalAtYearStart = $principal;
    for ($year = 1; $year <= $time; $year++) {
        $interestYear = $principalAtYearStart * $interestRate;
        $principalAtYearStart += $interestYear;
    ?>
    <tr>
        <td><?= $year ?></td>
        <td>$<?= number_format($principalAtYearStart, 2) ?></td>
        <td>$<?= number_format($interestYear, 2) ?></td>
    </tr>
    <?php } ?>
</table>

        <?php endif; ?>

        <a href="<?= $previousPage ?>"><input type="button" value="Previous"></a>
        <a href="javascript:void(0);" onclick="validateBeforeComplete();"><input type="button" value="Complete"></a>

    </div>
    <footer>&copy; Algonquin College 2010-2023. All Rights Reserved</footer>
    
    <script>
    function validateBeforeComplete() {
        var principal = parseFloat(document.getElementById("principal").value);
        var time = parseInt(document.getElementById("time").value);

        if (principal > 0 && time > 0) {
            window.location.href = "Complete.php"; // Navigate to the complete page
        } else {
            alert("Please enter a valid principal amount and time before completing.");
        }
    }
</script>

</body>
</html>