<?php
include_once '../dbconnection.php';
session_start();

session_destroy();

header('Location:login.php');
?>