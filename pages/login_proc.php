<?php 
Include "../conf/conn.php";
session_start();

// as variáveis login e password recebem os dados digitados na página anterior
$username = $_POST['username'];
$password = $_POST['password'];

$salt = sha1(md5($username));
$npassword = md5($password);
$saltedpassowrd = md5($salt.$npassword);


// A variavel $result pega as varias $login e $password, faz uma pesquisa na tabela de usuarios
$query = "SELECT * FROM users WHERE username = '$username' AND password= '$saltedpassowrd' AND salt= '$salt'";
$result = $conn->query($query);
$r = mysqli_fetch_row($result);

//echo $result;
/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
if(mysqli_num_rows ($result) > 0 )
{
$_SESSION['uId'] = $r[0];
$_SESSION['steamid'] = $r[5];
$_SESSION['steamid64'] = $r[7];
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
$_SESSION['team'] = $r[9];
header('location:index.php');
}
else{
	unset ($_SESSION['uId']);
	unset ($_SESSION['username']);
	unset ($_SESSION['password']);
	unset ($_SESSION['steamid']);
	unset ($_SESSION['steamid64']);
	unset ($_SESSION['team']);
	session_destroy();
	header('location:index.php?error=1');
	
	}

?>