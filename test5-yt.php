<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

    <?php

        $friends = array("Mike", "Alice", "John", "Oscar", 2, true, false); // this is array

        print_r($friends);

        echo "<hr>";

        // echo $friends[0]; // [1], [2], ...

        for($i=0; $i<count($friends); $i++)
        {
            echo "\n$friends[$i]";
        }

        // koniec filmu 1:50 ...

    ?>

</body>
</html>