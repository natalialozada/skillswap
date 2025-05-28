<?php
echo "saliendo";
session_start();  

session_destroy();


header('Location: ../index.php');
exit();

?>