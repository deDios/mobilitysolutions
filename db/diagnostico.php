<?php
header('Content-Type: text/plain');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "PHP: " . PHP_VERSION . "\n";
echo "mysqli loaded? " . (extension_loaded('mysqli') ? 'YES' : 'NO') . "\n";
echo "OpenSSL: " . (defined('OPENSSL_VERSION_TEXT') ? OPENSSL_VERSION_TEXT : 'N/A') . "\n";

$consts = ['MYSQLI_CLIENT_SSL','MYSQLI_OPT_SSL_VERIFY_SERVER_CERT','MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT'];
foreach ($consts as $c) {
  echo $c . ": " . (defined($c) ? 'DEFINED' : 'UNDEFINED') . "\n";
}
