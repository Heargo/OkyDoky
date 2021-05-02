<?php 

User::current()->disconnect();
header("Location: ./login");

?>