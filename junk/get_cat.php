<?php
// Include database connection
include('res/dbcon.php');

// Check if the database connection is successful
if (!$dbh) {
    // Return an error response
    http_response_code(500);
    echo json_encode(array("error" => "Unable to connect to the database."));
    exit();
}

// Define the SQL query to retrieve categories and associated sites
$query = "
    SELECT 
        c.category_id, 
        c.category_name, 
        s.site_id, 
        s.site_name, 
        s.site_company, 
        s.site_link, 
        s.site_image
    FROM 
        categories c
    LEFT JOIN 
        sites s ON c.category_id = s.category_id
";

// Prepare and execute the query
$stmt = $dbh->prepare($query);
$stmt->execute();

// Fetch results and organize them by category
$categories = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categoryId = $row['category_id'];
    if (!isset($categories[$categoryId])) {
        $categories[$categoryId] = array(
            'category_id' => $row['category_id'],
            'category_name' => $row['category_name'],
            'sites' => array()
        );
    }
    $categories[$categoryId]['sites'][] = array(
        'site_id' => $row['site_id'],
        'site_name' => $row['site_name'],
        'site_company' => $row['site_company'],
        'site_link' => $row['site_link'],
        'site_image' => $row['site_image']
    );
}

// Convert the associative array to a numeric array
$categoriesArray = array_values($categories);

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($categoriesArray);
