<?php

// https://www.geeksforgeeks.org/mysql-regular-expressions-regexp/

use function PHPSTORM_META\type;

/**
 * $term e.g. "af"
 * $searchType e.g. "ending", default is "any"
 */
function setSearchType($term, $searchType = "any")
{
    switch ($searchType) {
        case "any":
            return "%" . $term . "%";
        case "exact":
            return $term;
        case "starting":
            return $term . "%";
        case "ending":
            return "%" . $term;
    }
}

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$mysqli = new mysqli("localhost", "root", "", "ajax_db");

// Check connection
if ($mysqli === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

if (isset($_REQUEST["term"])) {
    // Prepare a select statement
    $sql = "SELECT * FROM countries WHERE name LIKE ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_term);

        // Set parameter (term and search type set by user)
        $param_term = setSearchType($_REQUEST["term"], $_REQUEST["searchType"]);
        print_r($param_term);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Check number of rows in the result set
            if ($result->num_rows > 0) {
                // Fetch result rows as an associative array
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    echo "<p>" . $row["name"] . "</p>";
                }
            } else {
                echo "<p>No matches found</p>";
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();
