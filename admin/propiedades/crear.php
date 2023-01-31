<?php 
    require '../../includes/funciones.php';
    incluirTemplate('header', $inicio = false);
?>

    
    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver</a>
        <form action="" class="formulario">

        <fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" placeholder="Titulo Propiedad">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" placeholder="Precio Propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="precio">



        </fieldset>


        </form>
    </main>

    <?php
    incluirTemplate('footer');
    ?>