<?php 
    require '../../includes/app.php';

    use App\Vendedor;

    estaAutenticado();

    $vendedor = new Vendedor;

    //Arreglo con mensaje de errores 
    $errores = Vendedor::getErrores();

        // Ejecutar el código después de que el usuario envia el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validar
            $errores = $vendedor->validar();

            // Revisar que el arreglo de errores esté vacío
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Registrar vendedor/a</h1>

        

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/vendedores/crear.php">
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Registrar vendedor" class="boton boton-verde">
        </form>
        
    </main>

<?php 
    incluirTemplate('footer');
?> 