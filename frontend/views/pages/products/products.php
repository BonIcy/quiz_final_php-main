<?php
error_reporting(0); // Desactivar la visualización de errores

// Conectar a la base de datos
$conn = new mysqli("localhost", "campus", "campus2023", "alquilartemis");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
//agregar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $nombre = $_POST["nombre"];
    $precioDia = $_POST["precio_dia"];
    $imagen = $_FILES["imagen"]["tmp_name"];
    if (!empty($imagen)) {
        $imagenContenido = addslashes(file_get_contents($imagen));

        $sql = "INSERT INTO productos (nombre, precio_dia, imagen) VALUES ('$nombre', '$precioDia', '$imagenContenido')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>window.location.href = "../frontend/products";</script>';
            exit();
        } else {
            echo "Error al agregar el producto: " . $conn->error;
        }
    } else {
        echo "No se ha seleccionado ninguna imagen.";
    }
}

// eliminar
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if (isset($_POST['delete'])) {
    $idProductoEliminar = $_POST['id_producto'];

    $sqlDelete = "DELETE FROM productos WHERE id_producto = $idProductoEliminar";
    if ($conn->query($sqlDelete) === TRUE) {

        echo '<script>window.location.href = "../frontend/products";</script>';
        exit();
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}
//editar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $idProductoEditar = $_POST['id_producto'];

    $sqlEditar = "SELECT * FROM productos WHERE id_producto = $idProductoEditar";
    $resultEditar = $conn->query($sqlEditar);

    if ($resultEditar->num_rows > 0) {
        $rowEditar = $resultEditar->fetch_assoc();
        $nombreProductoEditar = $rowEditar["nombre"];
        $precioDiaProductoEditar = $rowEditar["precio_dia"];
        echo "
        <form method='post' enctype='multipart/form-data'>
            <div class='form-group'>
                <label for='nombre'>Nombre:</label>
                <input type='text' name='nombre' id='nombre' value='$nombreProductoEditar' required>
            </div>
            <div class='form-group'>
                <label for='precioDia'>Precio por Día (Dolares):</label>
                <input type='number' step='0.25' name='precio_dia' id='precioDia' value='$precioDiaProductoEditar' required>
            </div>
            <div class='form-group'>
                <label for='imagen'>Imagen:</label>
                <input type='file' name='imagen' id='imagen' required>
            </div>
            <input type='hidden' name='id_producto' value='$idProductoEditar'>
            <button type='submit' name='update' class='btn btn-primary'>Actualizar</button>
        </form>
        ";
    } else {
        echo "No se encontró el producto a editar.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $idProductoActualizar = $_POST['id_producto'];
    $nombreProductoActualizar = $_POST['nombre'];
    $precioDiaProductoActualizar = $_POST['precio_dia'];
    $imagenProductoActualizar = $_FILES['imagen']['tmp_name'];
    if (!empty($imagenProductoActualizar)) {
        // leer el contenido de la img en forma de bytes
        $imagenContenidoActualizar = addslashes(file_get_contents($imagenProductoActualizar));
        $sqlActualizar = "UPDATE productos SET nombre = '$nombreProductoActualizar', precio_dia = '$precioDiaProductoActualizar', imagen = '$imagenContenidoActualizar' WHERE id_producto = $idProductoActualizar";
    } else {

        $sqlActualizar = "UPDATE productos SET nombre = '$nombreProductoActualizar', precio_dia = '$precioDiaProductoActualizar' WHERE id_producto = $idProductoActualizar";
    }

    if ($conn->query($sqlActualizar) === TRUE) {
        echo '<script>window.location.href = "../frontend/products";</script>';
        exit();
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
</head>
<body>
<?php
    ini_set('output_buffering', 'off'); // Desactivar el buffer de salida
    ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Productos</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Agregar Producto Modal -->
                    <div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAgregarProductoLabel">Agregar Producto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nombre">Nombre:</label>
                                            <input type="text" name="nombre" id="nombre" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="precioDia">Precio por Día (Dolares):</label>
                                            <input type="number" step="0.25" name="precio_dia" id="precioDia" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="imagen">Imagen:</label>
                                            <input type="file" name="imagen" id="imagen" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Agregar</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Productos Tabla -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Productos</h3>
                        </div>
                        <div class="card-body">
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Precio por Día</th>
                                        <th>Imagen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  if ($result->num_rows > 0) {
                                      while ($row = $result->fetch_assoc()) {
                                          echo "<tr>";
                                          echo "<td>" . $row["id_producto"] . "</td>";
                                          echo "<td>" . $row["nombre"] . "</td>";
                                          echo "<td>" . $row["precio_dia"] . "</td>";
                                          echo "<td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' width='100' height='100'></td>";
                                          echo "<td>";
                                          echo "<form method='post'>";
                                          echo "<input type='hidden' name='id_producto' value='" . $row["id_producto"] . "'>";
                                          echo "<button type='submit' name='delete' class='btn btn-danger'>Eliminar</button>";
                                          echo "</form>";
                                          echo "</td>";
                                          echo "<td>";
                                          echo "<form method='post'>";
                                          echo "<input type='hidden' name='id_producto' value='" . $row["id_producto"] . "'>";
                                          echo "<button type='submit' name='edit' class='btn btn-primary'>Editar</button>";
                                          echo "</form>";
                                          echo "</td>";
                                          echo "</tr>";
                                      }
                                  } else {
                                      echo "<tr><td colspan='6'>No se encontraron productos.</td></tr>";
                                  }
                                  ?>
                                </tbody>

                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">Agregar Producto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
