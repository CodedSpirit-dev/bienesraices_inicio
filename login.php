<?php 
    require 'includes/config/database.php';
    $db = conectarDB();

    //Autenticar el usuario

    $errores = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) ;
        var_dump($email);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email) {
            $errores[] = "El email no es valido";
        }
        if(!$password) {
            $errores[] = "No hay password";
        }

        /* echo "<pre>";
        var_dump($errores);
        echo "</pre>"; */
    }

    //Incluye el header
    require 'includes/funciones.php';
    incluirTemplate('header', $inicio = false);
?>

    
    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar sesion</h1>
        
        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>


        <?php endforeach; ?>

        <form method="POST" class="formulario">
            <fieldset>
                    <label for="email">E-Mail</label>
                    <input type="email" name="email" placeholder="Tu E-mail" id="email" required>

                    <label for="telefono">Password</label>
                    <input type="password" name="password" placeholder="Tu password" id="password" required>
                </fieldset>
                <input type="submit" value="Iniciar sesion" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>