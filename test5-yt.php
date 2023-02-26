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

        echo '<div style="display: none;">';

        $friends = array("Mike", "Alice", "John", "Oscar", 2, true, false); // this is array

        print_r($friends);

        echo "<hr>";

        // echo $friends[0]; // [1], [2], ...

        for($i=0; $i<count($friends); $i++)
        {
            echo "\n$friends[$i]";
        }

        echo "</div>";

        // koniec filmu 1:50 ...
    ?>

    <hr style="border: 1px solid black;">

    <?php

        class Person {
            public $name;
            public $surname;
            public $age;

            public function say() {
                echo $this->name." ".$this->surname." ".$this->age."<br>";
            }
        }

        $person = new Person();

        $person->name = "Jakub";
        $person->surname = "Wojciechowksi";
        $person->age = 23;

        $person->say();

    ?>

</body>
</html>