<?php

session_start();
include_once "../functions.php";

// get_subcategories.php

// Retrieve the category_id from the query string


// Perform database query to fetch the subcategories based on the category_id
// ...

if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {

    if($category_id = filter_var($_GET['category_id'], FILTER_VALIDATE_INT)) { // cat-id or false;
        query("SELECT sb.id_subkategorii, sb.nazwa, sb.id_kategorii FROM subkategorie AS sb, kategorie AS kt WHERE sb.id_kategorii = kt.id_kategorii AND sb.id_kategorii = '%s'", "getSubcategories", $category_id); // fetched subcategories;





        //print_r($result);






    }
}










// Prepare the subcategories data as an array (e.g., from the database query result)
/*$subcategories = [
    ['id' => 1, 'name' => 'Subcategory 1'],
    ['id' => 2, 'name' => 'Subcategory 2'],
    ['id' => 3, 'name' => 'Subcategory 3']
];

// Return the subcategories as JSON response
header('Content-Type: application/json');
echo json_encode($subcategories);*/

