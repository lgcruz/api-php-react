<?php

    function getEmployees()
    {
        $bd = getConnection();
        $sentencia = $bd->query("SELECT employeeID, name, gender, birthday, hireDate, departmentID FROM employee");
        return $sentencia->fetchAll();
    }

    function getDepartments()
    {
        $bd = getConnection();
        $sentencia = $bd->query("SELECT departmentID, name, description FROM department");
        return $sentencia->fetchAll();
    }

    function addEmployee($employee)
    {
        $bd = getConnection();
        $sentencia = $bd->prepare("INSERT INTO employee(name, gender, birthday, hireDate, departmentID) VALUES (?, ?, ?, ?, ?)");
        return $sentencia->execute([$employee->name, $employee->gender, $employee->birthday, $employee->hireDate, $employee->departmentID]);
    }

    function addSalary($employee)
    {
        $bd = getConnection();
        $sentencia = $bd->prepare("INSERT INTO salary(employeeID, salary, dateOfLastRaise) VALUES (?, ?, ?)");
        return $sentencia->execute([$employee->name, $employee->gender, $employee->birthday, $employee->hireDate, $employee->departmentID]);
    }


    function obtenerVariableDelEntorno($key)
    {
        if (defined("_ENV_CACHE")) {
            $vars = _ENV_CACHE;
        } else {
            $file = "env.php";
            if (!file_exists($file)) {
                throw new Exception("El archivo de las variables de entorno ($file) no existe. Favor de crearlo");
            }
            $vars = parse_ini_file($file);
            define("_ENV_CACHE", $vars);
        }
        if (isset($vars[$key])) {
            return $vars[$key];
        } else {
            throw new Exception("La clave especificada (" . $key . ") no existe en el archivo de las variables de entorno");
        }
    }

    function getConnection()
    {
        $password = obtenerVariableDelEntorno("MYSQL_PASSWORD");
        $user = obtenerVariableDelEntorno("MYSQL_USER");
        $dbName = obtenerVariableDelEntorno("MYSQL_DATABASE_NAME");
        $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
        $database->query("set names utf8;");
        $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $database;
    }
?>