<?php
/*session_start();
include_once "../functions.php";*/

    // get-subcategories.php;
    // retrieve the category_id from the query string;
    // perform database query to fetch the subcategories based on the category_id;

// check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
require_once "../authenticate-admin.php";

/*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
echo "GET ->"; print_r($_GET); echo "<hr><br>";
echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/

if (isset($_GET['category_id']) && ! empty($_GET['category_id'])) {

    if($category_id = filter_var($_GET['category_id'], FILTER_VALIDATE_INT)) { // category-id or false;

        query("SELECT sb.id_subkategorii, sb.nazwa, sb.id_kategorii FROM subcategories AS sb, categories AS kt WHERE sb.id_kategorii = kt.id_kategorii AND sb.id_kategorii = '%s'", "getSubcategories", $category_id);
        //              fetched subcategories;
        // id_subkategorii	    nazwa	     id_kategorii
        //     1	        Programowanie	     4
        //     2	        Web development	     4
    }
}
// Prepare the subcategories data as an array (e.g., from the database query result)
/* $subcategories = [
    ['id' => 1, 'name' => 'Subcategory 1'],
    ['id' => 2, 'name' => 'Subcategory 2'],
    ['id' => 3, 'name' => 'Subcategory 3']
];
// Return the subcategories as JSON response
header('Content-Type: application/json');
echo json_encode($subcategories); */
