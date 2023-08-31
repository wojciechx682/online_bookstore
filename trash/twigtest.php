



<?php

require_once "../start-session.php";

/*use Twig\Environment;
use Twig\Loader\ArrayLoader;

require_once "../vendor/autoload.php";


$loader = new ArrayLoader([
    'index' => 'Hello {{ name }}!',
]);

$twig = new Environment($loader);

echo $twig->render('index', ['name' => 'Fabien']);*/

require_once "../vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('../template');
$twig = new \Twig\Environment($loader);


?>


<ul id="my-list">
    <?php
        query("SELECT DISTINCT nazwa FROM categories ORDER BY nazwa ASC", "get_categoriesTwig", "");
    ?>
</ul>

