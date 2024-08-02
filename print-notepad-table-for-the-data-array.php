<?php

$data = [
    [
        'Month' => 1,
        'EMI' => 114666.42,
        'Principal Payment' => 68708.67,
        'Interest Payment' => 45957.75,
        'Remaining Principal' => 985291.33,
    ],
    [
        'Month' => 2,
        'EMI' => 114666.42,
        'Principal Payment' => 71704.58,
        'Interest Payment' => 42961.83,
        'Remaining Principal' => 913586.75,
    ],
    [
        'Month' => 2,
        'EMI' => 114666.42,
        'Principal Payment' => 74831.13,
        'Interest Payment' => 39835.28,
        'Remaining Principal' => 838755.61,
    ],
];


// Call Print Table
printTable($data);


function printTable($data) {
    // Calculate column widths
    $columns = ['Month', 'EMI', 'Principal Payment', 'Interest Payment', 'Remaining Principal'];
    $widths = array_fill_keys($columns, 0);
    foreach ($columns as $column) {
        $widths[$column] = strlen($column);
    }
    foreach ($data as $row) {
        foreach ($columns as $column) {
            $widths[$column] = max($widths[$column], strlen((string) $row[$column]));
        }
    }

    // Print header
    foreach ($columns as $column) {
        echo str_pad($column, $widths[$column] + 2);
    }
    echo PHP_EOL;

    // Print separator
    foreach ($columns as $column) {
        echo str_repeat('-', $widths[$column] + 2);
    }
    echo PHP_EOL;

    // Print data rows
    foreach ($data as $row) {
        foreach ($columns as $column) {
            echo str_pad($row[$column], $widths[$column] + 2);
        }
        echo PHP_EOL;
    }
}
