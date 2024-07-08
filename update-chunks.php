<?php

// List of IDs to be updated (replace this with your actual data)
$ids = [
    1,2,3
];

// Function to generate UPDATE statements in batches
function generateUpdateStatements($ids, $batchSize = 1000) {
    $totalIds = count($ids);
    $batches = array_chunk($ids, $batchSize);
    $statements = [];

    foreach ($batches as $batch) {
        $idsString = implode(',', $batch);
        $statements[] = "UPDATE zoodel.FinanceInterestIncome SET `isFullyPaidOrFullRefund` = '1' WHERE id IN ($idsString);";
    }

    return $statements;
}

// Generate the SQL statements
$updateStatements = generateUpdateStatements($ids);

// Print the SQL statements
foreach ($updateStatements as $statement) {
    echo $statement . "<br>" . PHP_EOL;
}

?>
