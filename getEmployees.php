<?php
include_once "cors.php";
include_once "funciones.php";
$employees = getEmployees();
echo json_encode($employees);