<?php
include_once "cors.php";
include_once "funciones.php";
$departments = getDepartments();
echo json_encode($departments);