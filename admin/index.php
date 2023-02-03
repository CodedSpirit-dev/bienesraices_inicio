<?php


$resultado = $_GET['resultado'] ?? null;
    require '../includes/funciones.php';
    incluirTemplate('header', $inicio = false);
?>

    
    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if( intval($resultado)  === 1): ?>
            <p class="alerta exito">Anuncio Creado Correctamente</p>
            <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Casa en el Lago</td>
                    <td><img src="/build/img/anuncio1.jpg" class="imagen" alt="anuncio1"></td>
                    <td>$3,000,000</td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" value="1" name="id">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=1" class="boton-amarillo-block">Actualizar</a>
                </tr>
            </tbody>
        </table>

    <?php
    incluirTemplate('footer');
    ?>