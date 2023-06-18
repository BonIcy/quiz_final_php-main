<?php
  header('Content-Type: application/json');

  require_once("../config/conectar.php");
  require_once("../models/Constructoras.php");

  $constructora = new Constructoras();

  $body = json_decode(file_get_contents("php://input"),true); 

  switch($_GET['op']){
      case "GetAll":
          $datos = $contructora->get_constructora();
          echo json_encode($datos);
      break;
      
      case "GetId":
          $dato = $constructora->get_constructora_id($body['id_constructora']);
          echo json_encode($dato);
      break;

      case "insert":
          $datos = $constructora->insert_constructora($body['id_constructora'],
          $body['nombre'],
          $body['direccion'],
          );
          echo json_encode("Insertado Correctamente");
      break;
  }


?>