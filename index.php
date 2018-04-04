<?php

include './Security.php';
define("PASSWORD_PUBLIC_KEY", "2465716786ABCDEFGHIJKLMMOPQRSTUabcdefghighijklng!@#$$%^&**1");

$security = new Security();
$password = $security->encrypt('kalpesh', PASSWORD_PUBLIC_KEY);
//$encript_password = utf8_encode($security->encrypt('kalpesh', PASSWORD_PUBLIC_KEY));
echo '<pre>';
print_r($password);
echo '<br>';
$decript_pass = $security->decrypt($password, PASSWORD_PUBLIC_KEY);
//$decript_pass = $security->decrypt(utf8_decode($dataarry9['database_host']), PASSWORD_PUBLIC_KEY);
echo '<pre>';
print_r($decript_pass);
echo '<br>';
