<?php

    header('Content-Type: application/json');

    require_once("../config/conectar.php");
    require_once("../models/Empleados.php");

    $empleado = new Empleados();

    $body = json_decode(file_get_contents("php://input"),true); 

    switch($_GET['op']){
        case "GetAll":
            $datos = $empleado->get_empleado();
            echo json_encode($datos);
        break;
        
        case "GetId":
            $dato = $empleado->get_empleado_id($body['id_empleado']);
            echo json_encode($dato);
        break;

        case "insert":
            $datos = $empleado->insert_empleado($body['id_empleado'],
            $body['nombre'],
            $body['usuario'],
            $body['password'],
            );
            echo json_encode("Insertado Correctamente");
        break;
    }
?>