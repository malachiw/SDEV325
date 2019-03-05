<?php
session_start();

$username = $_SESSION['appusername'];
//echo $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
login_abuse_filter($username);

function login_abuse_filter($user){
	$pdo = new PDO('mysql:host=localhost;dbname=sdev325', 'root', '');
	$max_time_in_seconds = 60;
	$max_attempts = 3;
	delete_old_attempts($max_time_in_seconds, $pdo);

	if(login_attempt_count($user, $pdo) <= $max_attempts) {
		insert_attempt($user, $max_time_in_seconds, $pdo);
		header('Location:loginagain.html');
		

	} else {
		header('Location:stop.html');
		// Do not show the login form, since it may be a bot trying to log in.
	}
}
function login_attempt_count($user, $pdo) {
	$count = "SELECT count(*) as number FROM attempts where user = ?";
	$input = $pdo->prepare($count);
 	$input->execute([$user]);
 	$num = $input -> fetch();
	foreach($num as $attempt) {
		$attempts = $attempt[0];
 	 		return $attempts;
 	}
}

function delete_old_attempts($seconds, $pdo){
	$del_old = "DELETE FROM attempts WHERE `when` < ?";
 	$oldest = strtotime(date("Y-m-d H:i:s")." - ".$seconds." seconds");
 	$oldest = date("Y-m-d H:i:s",$oldest)."<br/>";
 	$del_data = array($oldest);
 	$remove = $pdo->prepare($del_old);
 	$remove->execute($del_data);
}

function insert_attempt($user, $seconds, $pdo){
	$insert = "INSERT INTO attempts (`user`,`ip`, `when`) VALUES (?, ?, ?)";
 	$data = array($user, '127.0.0.1', date("Y-m-d H:i:s"));
 	$input = $pdo->prepare($insert);
 	$input->execute($data);
 }
?>