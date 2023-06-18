
<?php
// Consultar los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

// Verificar si se ha enviado el formulario de eliminación
if (isset($_POST['delete'])) {
    $idProductoEliminar = $_POST['id_producto'];

    // Realizar la eliminación del producto
    $sqlDelete = "DELETE FROM productos WHERE id_producto = $idProductoEliminar";
    if ($conn->query($sqlDelete) === TRUE) {
        // Redirigir al usuario a la página de productos después de eliminar
        header("Location: ./products.php");
        exit();
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}
?>