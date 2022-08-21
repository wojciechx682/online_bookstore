
<!DOCTYPE html>
  
<?php

	$cookie_name = "PHPSESSID";
	$cookie_value = $_COOKIE['PHPSESSID'];

	//echo $_COOKIE['PHPSESSID'];
	//exit();
	  
	// 86400 = 1 day
	setcookie($cookie_name, $cookie_value, time() - 3600, "/"); 
?>
  
<html>
<body>
    <?php

	    if(!isset($_COOKIE[$cookie_name])) 
	    {
	          echo "Cookie named '" . $cookie_name . "' is not set!";
	    } 

	    else 
	    {
	          echo "Cookie '" . $cookie_name . "' is set!<br>";
	          echo "Value is: " . $_COOKIE[$cookie_name];
	    }
    ?>
  
</body>
  
</html>