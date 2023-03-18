<?php
    //Incluye el header
    require 'includes/app.php';
    $db = conectarDB();

    //Autenticar el usuario

    $errores = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
/*         echo "<pre>";
        var_dump($_POST);
        echo "</pre>"; */

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) ;
        //var_dump($email);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email) {
            $errores[] = "El email no es valido";
        }
        if(!$password) {
            $errores[] = "No hay password";
        }

        if(empty($errores)) {
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email' ";
            $resultado = mysqli_query($db, $query);
            //var_dump($query);

            if ($resultado -> num_rows) {
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                //Verificar si el pass es correcto
                $auth = password_verify($password, $usuario['password']);

                if ($auth) {
                    //El usuario esta autenticado
                    session_start();


                    //Llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');




                } else {
                    $errores[] = 'El password es incorrecto';
                }


            } else {
                $errores[] = "El usuario no existe";
            }
            
        }

        /* echo "<pre>";
        var_dump($errores);
        echo "</pre>"; */
    }


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