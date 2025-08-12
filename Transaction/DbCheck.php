<?php

// For Showing Database
$opt = SQL_Select("Product");
if (!empty($opt)) {
    echo "<table border='1' cellpadding='6' cellspacing='0'>";

    echo "<tr>";
    foreach (array_keys($opt[0]) as $column) {
        echo "<th>" . htmlspecialchars($column) . "</th>";
    }
    echo "</tr>";

    foreach ($opt as $row) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "⚠️No Data";
}
die();