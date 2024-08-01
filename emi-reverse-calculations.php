<?php 
$principal = 3639000.00; // Principal amount
$commissionAmount = 704146.50; // Total interest amount
$totalMonths = 6; // Total number of installments

// Function to calculate EMI for a given annual interest rate and principal
function calculateEMI($principal, $annualRate, $totalMonths) {
    $monthlyRate = ($annualRate / 12) / 100;
    $emi = $principal * $monthlyRate * pow(1 + $monthlyRate, $totalMonths) / (pow(1 + $monthlyRate, $totalMonths) - 1);
    return $emi;
}

// Function to calculate the total interest given a fixed EMI
function calculateTotalInterest($principal, $emi, $totalMonths, $annualRate) {
    $totalInterest = 0;
    $remainingPrincipal = $principal;

    for ($month = 1; $month <= $totalMonths; $month++) {
        $monthlyRate = ($annualRate / 12) / 100;
        $interestPayment = $remainingPrincipal * $monthlyRate;
        $principalPayment = $emi - $interestPayment;
        $totalInterest += $interestPayment;
        $remainingPrincipal -= $principalPayment;

        if ($remainingPrincipal < 0) {
            $remainingPrincipal = 0;
        }
    }

    return $totalInterest;
}

// Function to find the appropriate annual interest rate to match the total interest
function findAnnualRate($principal, $commissionAmount, $totalMonths) {
    $low = 0;
    $high = 100;
    $epsilon = 0.01; // Acceptable error margin

    while (($high - $low) > $epsilon) {
        $mid = ($low + $high) / 2;
        $emi = calculateEMI($principal, $mid, $totalMonths);
        $totalInterest = calculateTotalInterest($principal, $emi, $totalMonths, $mid);

        if ($totalInterest < $commissionAmount) {
            $low = $mid;
        } else {
            $high = $mid;
        }
    }

    return ($low + $high) / 2;
}

// Find the annual interest rate
$annualInterestRate = findAnnualRate($principal, $commissionAmount, $totalMonths);

// Calculate EMI using the found annual interest rate
$fixedEMI = calculateEMI($principal, $annualInterestRate, $totalMonths);

// Initialize variables for calculation
$remainingPrincipal = $principal;
$installments = [];
$totalInterest = 0.00;

// Calculate monthly installments
for ($month = 1; $month <= $totalMonths; $month++) {
    $monthlyRate = ($annualInterestRate / 12) / 100;
    $interestPayment = $remainingPrincipal * $monthlyRate;
    $principalPayment = $fixedEMI - $interestPayment;
    
    // Store the installment details
    $installments[] = [
        'month' => $month,
        'emi' => round($fixedEMI, 2),
        'principal_payment' => round($principalPayment, 2),
        'interest_payment' => round($interestPayment, 2),
        'remaining_principal' => round(max($remainingPrincipal - $principalPayment, 0), 2)
    ];

    // Accumulate the total interest
    $totalInterest += $interestPayment;

    // Update remaining principal
    $remainingPrincipal -= $principalPayment;

    // Correct the final payment to ensure the remaining principal is zero
    if ($month == $totalMonths && $remainingPrincipal > 0) {
        $installments[$month - 1]['emi'] = round($remainingPrincipal + $interestPayment, 2);
        $installments[$month - 1]['principal_payment'] = round($remainingPrincipal, 2);
        $installments[$month - 1]['interest_payment'] = round($installments[$month - 1]['emi'] - $installments[$month - 1]['principal_payment'], 2);
        $installments[$month - 1]['remaining_principal'] = 0;
    }
}

// Display the installments
foreach ($installments as $payment) {
    echo "Month: " . $payment['month'] . "<br/>";
    echo "EMI: " . $payment['emi'] . "<br/>";
    echo "Principal Payment: " . $payment['principal_payment'] . "<br/>";
    echo "Interest Payment: " . $payment['interest_payment'] . "<br/>";
    echo "Remaining Principal: " . $payment['remaining_principal'] . "<br/>";
    echo "----------------------<br/>";
}

echo "<br/><br/>Total interest: " . round($totalInterest, 2) . ", and should match with " . $commissionAmount . "<br/>";
?>
