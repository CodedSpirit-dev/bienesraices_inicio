<?php
//Base de datos
require '../../includes/config/database.php';
$db = conectardb();

//Consultar para obtener los vendedores
$consulta = 'SELECT * FROM vendedores';
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedores_id = '';

//Ejecutar el codigo despues de que el usuario envia el formulario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*echo "<pre>";
        var_dump($_POST);
        echo "</pre>";*/

    $titulo = $_POST['titutlo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedores_id = $_POST['vendedor'];

    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }
    if (!$precio) {
        $errores[] = "Debes añadir el precio";
    }
    if (strlen(!$descripcion) > 50) {
        $errores[] = "Debes añadir una descripcion de al menos 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "Debes añadir el numero de habitaciones";
    }
    if (!$wc) {
        $errores[] = "Debes añadir el numero de baños";
    }
    if (!$estacionamiento) {
        $errores[] = "Debes añadir el numero de estacionamientos";
    }
    if (!$vendedores_id) {
        $errores[] = "Debes añadir el vendedor";
    }


    /* echo "<pre>";
        var_dump($errores);
        echo "</pre>"; */

    //Revisar que el arreglo de errores este vacio
    if (empty($errores)) {
        //Insertar en la base de datos

        $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedores_id) VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedores_id')";

        //echo $query;

        //Agregarlo a la base de datos
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            echo "Insertado Correctamente";
        }
    }


    //Insertar en la base de datos



}


require '../../includes/funciones.php';
incluirTemplate('header', $inicio = false);
?>


<main class="contenedor seccion">
    <h1>Crear</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>


    <a href="/admin/index.php" class="boton boton-verde">Volver</a>
    <form method="POST" action="/admin/propiedades/crear.php" class="formulario">

        <fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titutlo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="precio" accept="image/jpeg, image/png">

            <label for="descripcion">Descripcion</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>

            <legend>Informacion Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">WC:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">


        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="">-- Seleccione --</option>
                <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                    <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : '';  ?>       value="<?php echo $vendedor['id'] ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido'];?></option>
                <?php endwhile; ?>
                
            </select>
        </fieldset>
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">


    </form>
</main>

<?php
incluirTemplate('footer');
?>