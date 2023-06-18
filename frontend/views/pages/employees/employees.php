<?php
error_reporting(0); // Desactivar la visualización de errores

// Conectar a la base de datos
$conn = new mysqli("localhost", "campus", "campus2023", "alquilartemis");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

//agregar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $salarioMensual = $_POST["salario_mensual"];
    $sexo = $_POST["sexo"];

    if (!empty($nombre) && !empty($salarioMensual) && !empty($sexo)) {
        $sql = "INSERT INTO empleados (nombre, salario_mensual, sexo) VALUES ('$nombre', '$salarioMensual', '$sexo')";
        if ($conn->query($sql) === TRUE) {
        
            echo '<script>window.location.href = "../frontend/employees";</script>';
            exit();
        } else {
            echo "Error al agregar el empleado: " . $conn->error;
        }
    } else {
        echo "Todos los campos son obligatorios";
    }
}

// eliminar
$sql = "SELECT * FROM empleados";
$result = $conn->query($sql);

if (isset($_POST['delete'])) {
    $idEmpleadoEliminar = $_POST['id_empleado'];
    $sqlDelete = "DELETE FROM empleados WHERE id_empleado = $idEmpleadoEliminar";
    if ($conn->query($sqlDelete) === TRUE) {
        echo '<script>window.location.href = "../frontend/employees";</script>';
        exit();
    } else {
        echo "Error al eliminar el empleado: " . $conn->error;
    }
}

// editar
if (isset($_POST['edit'])) {
    $idEmpleadoEditar = $_POST['id_empleado'];

    $sqlEditar = "SELECT * FROM empleados WHERE id_empleado = $idEmpleadoEditar";
    $resultEditar = $conn->query($sqlEditar);

    if ($resultEditar->num_rows > 0) {
        $rowEditar = $resultEditar->fetch_assoc();
        $nombreEmpleadoEditar = $rowEditar["nombre"];
        $salarioMensualEmpleadoEditar = $rowEditar["salario_mensual"];
        $sexoEmpleadoEditar = $rowEditar["sexo"];

        // Mostrar el formulario de edición con los datos del empleado
        echo "
        <form method='post'>
            <div class='form-group'>
                <label for='nombre'>Nombre:</label>
                <input type='text' name='nombre' id='nombre' value='$nombreEmpleadoEditar' required>
            </div>
            <div class='form-group'>
                <label for='salario_mensual'>Salario Mensual:</label>
                <input type='number' name='salario_mensual' id='salario_mensual' value='$salarioMensualEmpleadoEditar' required>
            </div>
            <div class='form-group'>
                <label for='sexo'>Sexo:</label>
                <select name='sexo' id='sexo' required>
                    <option value='M' " . ($sexoEmpleadoEditar == 'M' ? 'selected' : '') . ">Masculino</option>
                    <option value='F' " . ($sexoEmpleadoEditar == 'F' ? 'selected' : '') . ">Femenino</option>
                </select>
            </div>
            <input type='hidden' name='id_empleado' value='$idEmpleadoEditar'>
            <input type='hidden' name='update' value='update'> <!-- Agrega un campo oculto para indicar actualización -->
            <button type='submit' class='btn btn-primary'>Actualizar</button>
        </form>
        ";
    } else {
        echo "No se encontró el empleado";
    }
}
//actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $idEmpleadoActualizar = $_POST['id_empleado'];
    $nombreEmpleadoActualizar = $_POST['nombre'];
    $salarioMensualEmpleadoActualizar = $_POST['salario_mensual'];
    $sexoEmpleadoActualizar = $_POST['sexo'];

    // Validar los campos antes de actualizar el empleado
    if (!empty($nombreEmpleadoActualizar) && !empty($salarioMensualEmpleadoActualizar) && !empty($sexoEmpleadoActualizar)) {
        // Actualizar el empleado en la base de datos
        $sqlActualizar = "UPDATE empleados SET nombre='$nombreEmpleadoActualizar', salario_mensual='$salarioMensualEmpleadoActualizar', sexo='$sexoEmpleadoActualizar' WHERE id_empleado=$idEmpleadoActualizar";
        if ($conn->query($sqlActualizar) === TRUE) {
            // Redirigir al usuario a la página de empleados después de actualizar
            echo '<script>window.location.href = "../frontend/employees";</script>';
            exit();
        } else {
            echo "Error al actualizar el empleado: " . $conn->error;
        }
    } else {
        echo "Todos los campos son obligatorios";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Empleados</title>
</head>
<body>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Empleados</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!--Empleado Modal -->
                    <div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" role="dialog" aria-labelledby="modalAgregarEmpleadoLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAgregarEmpleadoLabel">Agregar Empleado</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nombre">Nombre:</label>
                                            <input type="text" name="nombre" id="nombre" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="salario_mensual">Salario Mensual:</label>
                                            <input type="number" name="salario_mensual" id="salario_mensual" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="sexo">Sexo:</label>
                                            <select name="sexo" id="sexo" required>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                            </select>
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

                    <!-- Empleados Tabla -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Empleados</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Salario Mensual</th>
                                        <th>Sexo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["id_empleado"] . "</td>";
                                            echo "<td>" . $row["nombre"] . "</td>";
                                            echo "<td>" . $row["salario_mensual"] . "</td>";
                                            echo "<td>" . $row["sexo"] . "</td>";
                                            echo "<td>";
                                            echo "<form method='post'>";
                                            echo "<input type='hidden' name='id_empleado' value='" . $row["id_empleado"] . "'>";
                                            echo "<button type='submit' name='delete' value='delete' class='btn btn-danger'>Eliminar</button>";
                                            echo "<button type='submit' name='edit' value='edit' class='btn btn-primary'>Editar</button>";
                                            echo "</form>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No se encontraron empleados</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
