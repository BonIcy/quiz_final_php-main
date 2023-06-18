<?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "campus", "campus2023", "alquilartemis");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Verificar si se ha enviado el formulario de agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $precioDia = $_POST["precio_dia"];
    $imagen = $_FILES["imagen"]["tmp_name"];
    // Verificar si se seleccionó una imagen
    if (!empty($imagen)) {
        // Leer el contenido de la imagen en forma de bytes
        $imagenContenido = addslashes(file_get_contents($imagen));

        // Insertar el producto en la base de datos
        $sql = "INSERT INTO productos (nombre, precio_dia, imagen) VALUES ('$nombre', '$precioDia', '$imagenContenido')";
        if ($conn->query($sql) === TRUE) {
            // Redirigir al usuario a la página de confirmación
            echo '<script>window.location.href = "../frontend/products";</script>';
            exit();
        } else {
            echo "Error al agregar el producto: " . $conn->error;
        }
    } else {
        echo "No se ha seleccionado ninguna imagen.";
    }
}

// Consultar los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?><?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "campus", "campus2023", "alquilartemis");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Verificar si se ha enviado el formulario de agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $precioDia = $_POST["precio_dia"];
    $imagen = $_FILES["imagen"]["tmp_name"];
    // Verificar si se seleccionó una imagen
    if (!empty($imagen)) {
        // Leer el contenido de la imagen en forma de bytes
        $imagenContenido = addslashes(file_get_contents($imagen));

        // Insertar el producto en la base de datos
        $sql = "INSERT INTO productos (nombre, precio_dia, imagen) VALUES ('$nombre', '$precioDia', '$imagenContenido')";
        if ($conn->query($sql) === TRUE) {
            // Redirigir al usuario a la página de confirmación
            echo '<script>window.location.href = "../frontend/products";</script>';
            exit();
        } else {
            echo "Error al agregar el producto: " . $conn->error;
        }
    } else {
        echo "No se ha seleccionado ninguna imagen.";
    }
}

// Consultar los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>