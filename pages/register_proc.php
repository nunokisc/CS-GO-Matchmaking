<?php 
Include "../conf/conn.php";
// funчуo para converter steamids
function toSteamID($id) {
    if (is_numeric($id) && strlen($id) >= 16) {
        $z = bcdiv(bcsub($id, '76561197960265728'), '2');
    } elseif (is_numeric($id)) {
        $z = bcdiv($id, '2'); // Actually new User ID format
    } else {
        return $id; // We have no idea what this is, so just return it.
    }
    $y = bcmod($id, '2');
    return 'STEAM_0:' . $y . ':' . floor($z);
}
//recebe todas as variaveis do post
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];
$steamid64 = $_POST['steamid64'];


if ($password == $repassword and $password != "" and $repassword != "" and $steamid64 != ""  ){
	//transforma password dada em md5
	$npassword = md5($password);
	//cria a salt key com o sha1 do md5 do usernamme 
	$salt = sha1(md5($username));
	// junta a password md5 com a salt key
	$saltedpassowrd = md5($salt.$npassword);
	// retorna a steamid64
	$steamid = toSteamID($steamid64);
	$query = "INSERT INTO users (username,email,salt,password,steamid,steamid64) VALUES ('$username','$email','$salt','$saltedpassowrd','$steamid','$steamid64')";
	$result = $conn->query($query);
	//echo("Error description: " . mysqli_error($conn));
	echo "Registado com exito!!";
	session_unset();
	session_destroy();
	header('location:index.php');
} elseif ($password != $repassword) {
	echo "Passwords nуo coincidem.";
} elseif ($steamid64 == "") {
	echo "Steam id nao definida.";
} else {
	echo "Algum campo vazio!";
}
?>