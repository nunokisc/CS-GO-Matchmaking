<?php
ob_start();
//session_start();

if (isset($_GET['getSteamId'])){
	require 'openid.php';
	try {
		require 'SteamConfig.php';
		$openid = new LightOpenID($steamauth['domainname']);
		
		if(!$openid->mode) {
			$openid->identity = 'http://steamcommunity.com/openid';
			header('Location: ' . $openid->authUrl());
		} elseif ($openid->mode == 'cancel') {
			echo 'User has canceled authentication!';
		} else {
			if($openid->validate()) { 
				$id = $openid->identity;
				$ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
				preg_match($ptn, $id, $matches);
				
				$_SESSION['steamid64'] = $matches[1];
				if (!headers_sent()) {
					header('Location: index.php?page=register');
					exit;
				} else {
					?>
					<script type="text/javascript">
						window.location.href="index.php?page=register";
					</script>
					<noscript>
						<meta http-equiv="refresh" content="0;url=index.php?page=register" />
					</noscript>
					<?php
					exit;
				}
			} else {
				echo "User is not logged in.\n";
			}
		}
	} catch(ErrorException $e) {
		echo $e->getMessage();
	}
}

// Version 3.2

?>
