<?php
// Data to be inserted (replace this with your actual data)
$data = [
    // Example data rows, add your data here
    [
        'payOrderRecordDetailId' => 1,
        'zpayUniqid' => 'uniqid1',
        'orderCodes' => 'code1',
        'installmentId' => 101,
        'dailyInterest' => 1.5,
        'noOfInstalments' => 5,
        'status' => 1,
        'marketCode' => 'codeMarket',
        'orderType' => 'type1',
        'installmentCreatedAt' => '2024-01-01 00:00:00',
        'installmentUpdatedAt' => '2024-01-02 00:00:00',
        'isKnox' => 0,
        'zpiLoanId' => 0,
        'isKnoxLoan' => 0,
        'isNaimixLoan' => 0,
        'dueMonthType' => 'monthly',
        'pNewStatus' => 'newStatus',
        'receivablesForAccounting' => 100.00,
        'receivablesForRisks' => 50.00,
        // Add other fields as needed
    ],
    // More rows can be added here
];

// Table columns and their default values
$columns = [
    'payOrderRecordDetailId' => 'NOT NULL',
    'zpayUniqid' => 'NOT NULL',
    'orderCodes' => 'NOT NULL',
    'installmentId' => 'NOT NULL',
    'dailyInterest' => 'NOT NULL',
    'noOfInstalments' => 'NOT NULL',
    'status' => 'NOT NULL',
    'marketCode' => 'NOT NULL',
    'orderType' => 'NOT NULL',
    'installmentCreatedAt' => 'NOT NULL',
    'installmentUpdatedAt' => 'NOT NULL',
    'isKnox' => 'NOT NULL',
    'zpiLoanId' => 'NOT NULL DEFAULT 0',
    'isKnoxLoan' => 'NOT NULL DEFAULT 0',
    'isNaimixLoan' => 'NOT NULL DEFAULT 0',
    'dueMonthType' => 'NOT NULL',
    'pNewStatus' => 'NOT NULL',
    'receivablesForAccounting' => 'NOT NULL',
    'receivablesForRisks' => 'NOT NULL',
    'interest' => 'DEFAULT NULL',
    'outstandingBalance' => 'DEFAULT NULL',
    'payablePrinciple' => 'DEFAULT NULL',
    'installmentStatus' => 'DEFAULT NULL',
    'payStatus' => 'DEFAULT NULL',
    'instalmentTotalAmount' => 'DEFAULT NULL',
    'instalmentAmount' => 'DEFAULT NULL',
    'instalmentDueOn' => 'DEFAULT NULL',
    'interestincome0Part' => 'DEFAULT NULL',
    'interestincome0PartRefundAmount' => 'DEFAULT NULL',
    'interestincome1Part' => 'DEFAULT NULL',
    'interestincome1PartRefundAmount' => 'DEFAULT NULL',
    'interestincome2Part' => 'DEFAULT NULL',
    'interestincome2PartRefundAmount' => 'DEFAULT NULL',
    'instalmentDueOnYear' => 'DEFAULT NULL',
    'instalmentDueOnMonthId' => 'DEFAULT NULL',
    'RNO' => 'DEFAULT NULL',
    'soldPortfolioDate' => 'DEFAULT NULL',
    'refundCreationTime' => 'DEFAULT NULL',
    'originMonthType' => 'DEFAULT NULL',
    'grossInterestIncome' => 'DEFAULT NULL',
    'InterecIncomeCheck' => 'DEFAULT NULL',
    'interestincome0PartV2' => 'DEFAULT NULL',
    'interestincome0PartRefundAmountV2' => 'DEFAULT NULL',
    'interestincome1PartV2' => 'DEFAULT NULL',
    'interestincome1PartRefundAmountV2' => 'DEFAULT NULL',
    'interestincome2PartV2' => 'DEFAULT NULL',
    'interestincome2PartRefundAmountV2' => 'DEFAULT NULL',
    'totalAmount' => 'DEFAULT NULL',
    'amount' => 'DEFAULT NULL',
    'originalAmount' => 'DEFAULT NULL',
    'newStatus' => 'DEFAULT NULL',
    'instalmentPaidAt' => 'DEFAULT NULL',
    'state' => 'DEFAULT NULL',
    'DateTimecreated' => 'DEFAULT NULL',
    'dateOfSnapshot' => 'DEFAULT NULL',
    'monthOfReport' => 'DEFAULT NULL',
    'yearOfReport' => 'DEFAULT NULL',
    'reportMonthYear' => 'DEFAULT NULL',
    'isFullyPaidOrFullRefund' => 'DEFAULT NULL',
    'fullyPaidMonthYear' => 'DEFAULT NULL',
    'fullRefundMonthYear' => 'DEFAULT NULL',
    'isOffline' => 'DEFAULT 0',
    'loanType' => 'DEFAULT NULL',
    'loanCode' => 'DEFAULT NULL',
    'dataCollectionMethod' => 'DEFAULT 1',
];

// Function to get default value for a column
function getDefaultValue($column, $value, $columns) {
    if (isset($value)) {
        return $value;
    }

    if ($columns[$column] === 'NOT NULL') {
        return "''"; // Empty string for NOT NULL columns with no default
    } elseif (strpos($columns[$column], 'DEFAULT') !== false) {
        return explode(' ', $columns[$column])[2]; // Extract default value
    }

    return 'NULL'; // Use NULL if no default specified
}

// Generate INSERT statements
$insertStatements = [];
$insertPrefix = "INSERT INTO `FinanceInterestIncome` (" . implode(", ", array_keys($columns)) . ") VALUES ";
$values = [];
$counter = 0;

foreach ($data as $row) {
    $rowValues = [];
    foreach ($columns as $column => $default) {
        $rowValues[] = getDefaultValue($column, $row[$column] ?? null, $columns);
    }
    $values[] = "(" . implode(", ", $rowValues) . ")";
    $counter++;

    if ($counter % 500 == 0) {
        $insertStatements[] = $insertPrefix . implode(", ", $values) . ";";
        $values = [];
    }
}

if (!empty($values)) {
    $insertStatements[] = $insertPrefix . implode(", ", $values) . ";";
}

// Output or save the insert statements
foreach ($insertStatements as $statement) {
    echo $statement . PHP_EOL;
}

?>
