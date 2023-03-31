<?php 

    require '../../includes/app.php';
    use App\Vendedor;
    estaAutenticado();


    //Validar que sea un ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    //Obtener el arreglo del vendedor
    $vendedor = Vendedor::find($id);

    //Arreglo con mensaje de errores 
    $errores = Vendedor::getErrores();

    // Ejecutar el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Asignar los atributos
            $args = $_POST['vendedor'];
    
            $vendedor->sincronizar($args);
    
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
        <h1>Actualizar vendedor/a</h1>

        

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/vendedores/actualizar.php">
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Guardar cambios" class="boton boton-verde">
        </form>
        
    </main>

<?php 
    incluirTemplate('footer');
?> 
