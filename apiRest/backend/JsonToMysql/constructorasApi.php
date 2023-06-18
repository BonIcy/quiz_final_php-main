<?php
ini_set("display_errors", 1);

ini_set("display_startup_errors", 1);

error_reporting(E_ALL);
//json_decode  ->  Takes a JSON encoded string and converts it into a PHP value.
//json_encode  ->  Returns the JSON representation of a value

//PDO_MYSQL 
//is a driver that implements the PHP Data Objects (PDO) interface to enable 
//access from PHP to MySQL databases.


//MySQLi
//PDO will work on 12 different database systems, whereas MySQLi will only work with MySQL databases


  $constructoras = '[
    {
      "id_constructora":  1,
      "nombre": "Artemis",
      "direccion": "calle 12"
     
    },
    {
      "id_constructora":  2,
      "nombre": "Spuknit",
      "direccion": "calle 13"
  
    }
  ]';



$datosconstructoras = json_decode($constructoras, true);

$server = "localhost";
$user = "campus";
$pass = "campus2023";
$bd = "alquilartemis";

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");


foreach ($datosconstructoras as $constructora) {
    
    mysqli_query($conexion,"INSERT INTO constructoras (id_constructora,nombre,direccion) 
    VALUES ('".$constructora['id_constructora']."','".$constructora['nombre']."','".$constructora['direccion']."')");	
        
}	


mysqli_close($conexion);

?>