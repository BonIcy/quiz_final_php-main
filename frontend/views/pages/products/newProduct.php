<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $idProducto = $_POST["id_producto"];
    $nombre = $_POST["nombre"];
    $precioDia = $_POST["precio_dia"];

    // Conectar a la base de datos
    $conn = new mysqli("localhost", "yisuss", "campus2023", "alquilarartemis");
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Insertar el producto en la base de datos
    $sql = "INSERT INTO productos (id_producto, nombre, precio_dia) VALUES ('$idProducto', '$nombre', '$precioDia')";
    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado exitosamente.";
    } else {
        echo "Error al agregar el producto: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Producto</title>
</head>
<body>
    <h2>Nuevo Producto</h2>
    <form method="post" action="newProduct.php">
        <label for="idProducto">ID Producto:</label>
        <input type="number" name="id_producto" id="idProducto" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br><br>

        <label for="precioDia">Precio por Día (Dolares):</label>
        <input type="number" step="0.25" name="precio_dia" id="precioDia" required><br><br>

        <input type="submit" value="Agregar Producto">
    </form>
    <button><a href="../page/products.php">Volver</a></button>
</body>
</html>