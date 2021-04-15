<?php 

User::current()->disconnect();
$_SESSION["current_community"]=0;
header("Location: .");

?>