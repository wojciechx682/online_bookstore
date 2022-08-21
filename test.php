<?php
	
	session_start();

	$var = "You've clicked me !";
?>


<button onclick="my_function()"> Click me ! </button>

<p id="demo"></p>


<script>

	function my_function() 
	{
		document.getElementById("demo").innerHTML = "<?php echo $var; ?>";
	}

</script>


<hr>
<br>

<form method="post">

	<input type="text" name="login">

	<input type="submit" value="Wyślij dane do skryptu">

</form>


<!-- -------------------------------------------------- -->


<form method="post">

	<label>
		
		<input type="checkbox" name="regulamin">
		
		Akceptuję regulamin

	</label>
	
	<input type="submit" value="Wyślij dane do skryptu">

</form>

<form method="post">

	<br>
	
	<b>Przetestuj htmlentities() : </b><br>

	<input type="text" name="test_html_ent" value="<script>document.write('abcde');</script>">
	
	<input type="submit" value="Wyślij dane do skryptu">	

</form>
	
<?php
	
	
	
	if(isset($_POST['regulamin']))
	{
		echo "<br> Checkbox jest zaznaczony <br>";		
	}
	
	$email = "jak;ub.wojciechowski.682@gm;ail.com";
	
	echo "<br> e-mail = $email";
	
	$email_sanitaze = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	$email_verify = filter_var($email_sanitaze, FILTER_VALIDATE_EMAIL);
	
	echo "<br><br> e-mail verify - FILTER_SANITIZE_EMAIL = $email_sanitaze";
	
	echo "<br><br> e-mail verify - FILTER_VALIDATE_EMAIL = $email_verify";
	
	echo "<br>";
	
	if(filter_var($email_sanitaze, FILTER_VALIDATE_EMAIL) == true)
	{
		echo "<br>TRUE<br>";
	}
	else
	{
		echo "<br>FALSE<br>";
	}
	
	///////////////////////////////////////////////////////////////////////////
	
	if((isset($_POST['test_html_ent'])) && (!empty($_POST['test_html_ent'])))
	{
		$test_html_ent = $_POST['test_html_ent'];
	
		echo "<br>test_html_ent = $test_html_ent";
		
		$result_html_ent = htmlentities($test_html_ent, ENT_QUOTES, "UTF-8");
		
		echo "<br>result_html_ent = " . $result_html_ent . "<br>";
	
	}
	
	//exit();
	
	
		
		
		
	//exit();
?>

	



<?php

		//$v = '<script>document.write("abcde!");</script>';
		
	$haslo = 'qwerty';
	
	$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
	
	
		//$vh = htmlentities($login, ENT_QUOTES, "UTF-8"); 
		
		/*$v = htmlentities($v, ENT_QUOTES, "UTF-8");
		$vh = htmlentities($v, ENT_QUOTES, "UTF-8");
		
		
		require_once "connect.php"; 
		
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);	
		
		$ms = mysqli_real_escape_string($polaczenie, $vh); 	
		$ms = mysqli_real_escape_string($polaczenie, $vh); 	*/
	
	//echo "<br> haslo = $haslo";
	
	echo "<br> 148 haslo hash  = $haslo_hash";	
	
	//echo "<br> ms = $ms";
	
	///////////////////////////////////////////////////////////////////////////
	
	
	
	if(isset($_POST['login']))
	{
		$login = $_POST['login'];
		
		if((isset($login)) && (!empty($login)))
		{
			echo "<br> Zmienna login jest ustawiona (isset) i nie jest pusta (empty == false)";
			echo "<br> login = $login";	
		}	
	}	

	

	//unset($login);




	exit();

	$_SESSION['login'] = $login;	
	
	
	//unset($_SESSION['login']);
	
	echo "<br> Login = " . $_SESSION['login'] . " <br>";	
	
	exit();
		
?>






