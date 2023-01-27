<?
session_start();
findInSession("user")->delete($user);
header('Location: index.php');



?>