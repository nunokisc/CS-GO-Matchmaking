<?php
require("vendor/autoload.php");


use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;
$client = new Client(new Version1X('http://91.121.84.50:4001'));
$client->initialize();
$client->emit('update', [3]);
$client->close();
?>