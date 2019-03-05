<?php 
 	$username = $_POST['username'];
 	$password = $_POST['password'];

	if (ctype_alnum($username)) {
 	session_start(); 
 	$_SESSION['appPassword'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
 	$_SESSION['appusername'] = $username;
		try 
    		{
        		$pdo = new PDO('mysql:host=localhost;dbname=sdev325', 'root', '');
        		$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        		$stmt -> execute([$username]);
        		$user = $stmt -> fetch();

      			if (password_verify($_POST['password'], $user['password'])) { //Password matches, so create the session 
 					$_SESSION['appPassword'] = $_POST["password"];
 					header("Location:landing.php");}
   				else{ 
   					header("Location:attemptcounter.php");
   					} 
   	   			$pdo = null;
    		}
    	catch (PDOException $e) 
    	{
        	echo "<br><br>";
        	echo $e->getMessage();
        	echo "<br><br>";
    	}
	}
else {
        header("Location: attemptcounter.php");
    }
?>