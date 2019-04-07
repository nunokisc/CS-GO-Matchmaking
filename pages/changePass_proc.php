<?php 
Include "../conf/conn.php";
session_start();
//recebe informaчуo por post
$oldpassword = $_POST['oldpassword'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];

if(isset($_SESSION['uId'])){
	$uId = $_SESSION['uId'];
	//seleciona os dados do user em causa
	$query = "SELECT * FROM users where id='$uId'";
	$result = $conn->query($query);
	$r = mysqli_fetch_assoc($result);
	//confirma se a password antiga dada щ igual с fornecida 
	$confpassword = md5($oldpassword);
	$salt = sha1(md5($r['username']));
	$oldsaltedpassword = md5($salt.$confpassword);
	
	if ($password == $repassword and $password != "" and $repassword != "" and $oldsaltedpassword == $r['password'] ){
		//transforma password dada em md5
		$npassword = md5($password);
		// junta a password md5 com a salt key
		$saltedpassowrd = md5($salt.$npassword);
		//faz update da nova password
		$query = "UPDATE users SET salt='$salt',password='$saltedpassowrd' WHERE id='$uId'";
		$result = $conn->query($query);
		echo "Password alterada com sucesso!!";
	} else if($oldsaltedpassword != $r['password'] and $password != "" and $repassword != "") {
		echo "Password antiga incorrecta";
	} elseif ($password != $repassword and $password != "" and $repassword != "") {
		echo "Passwords nуo coincidem.";
	} else {
		echo "Algum campo vazio!";
	}
}
?>