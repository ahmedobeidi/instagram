<?php
// $_SESSION["userexist"] = false;
session_start();
unset($_SESSION['user']);
header('location: ../frontend/pages/connexion.php');
?>