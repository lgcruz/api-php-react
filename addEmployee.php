<?php
include_once "cors.php";
$employee = json_decode(file_get_contents("php://input"));
include_once "funciones.php";
$result = addEmployee($employee);
echo json_encode($result);