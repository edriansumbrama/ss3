<?php
function calculateNetIncome($hourlyRate) {
    $hoursPerDay = 8;
    $workingDays = 26;
    $grossIncome = $hourlyRate * $hoursPerDay * $workingDays;
    
    if ($grossIncome <= 15000) {
        $tax = 0;
    } elseif ($grossIncome <= 30000) {
        $tax = ($grossIncome - 15000) * 0.05;
    } else {
        $tax = (15000 * 0.05) + (($grossIncome - 30000) * 0.10);
    }
    
    $netIncome = $grossIncome - $tax;
    return [$grossIncome, $tax, $netIncome];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['hourlyRate'])) {
        $hourlyRate = filter_input(INPUT_POST, 'hourlyRate', FILTER_VALIDATE_FLOAT);
        
        if ($hourlyRate === false || $hourlyRate <= 0) {
            echo "Invalid input. Please enter a valid hourly rate.";
        } else {
            list($grossIncome, $tax, $netIncome) = calculateNetIncome($hourlyRate);
            echo "<p>Hourly Rate: $" . number_format($hourlyRate, 2) . "</p>";
            echo "<p>Gross Income: $" . number_format($grossIncome, 2) . "</p>";
            echo "<p>Tax: $" . number_format($tax, 2) . "</p>";
            echo "<p>Net Income: $" . number_format($netIncome, 2) . "</p>";
        }
    } else {
        echo "No input received.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Income Calculating</title>
</head>
<body>
    <form method="POST">
        <label for="hourlyRate">Enter your hourly rate ($):</label>
        <input type="number" step="0.01" name="hourlyRate" id="hourlyRate" required>
        <button type="submit">Calculate Net Income</button>
    </form>
</body>
</html>
