<?php
// Establish a database connection
$conn = new mysqli("localhost", "root", "", "sitescape");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categoriessql = "SELECT * FROM `categories`";
$categoriesresult = $conn->query($categoriessql);

if ($categoriesresult && $categoriesresult->num_rows > 0) {
    $categoriesData = array(); // Initialize an empty array to store categories
    while($row = $categoriesresult->fetch_assoc()) {
        $categoriesData[] = $row; // Append each row to the categoriesData array
    }
    echo json_encode($categoriesData); // Output the JSON encoded array
} else {
    echo json_encode(array('error' => 'Failed to retrieve user categories.'));
}

$conn->close();
?>
