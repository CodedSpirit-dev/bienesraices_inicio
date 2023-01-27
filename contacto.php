<?php 
    require 'includes/funciones.php';
    incluirTemplate('header', $inicio = false);
?>

    
    <main class="contenedor seccion">
        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <source srcset="build/img/destacada3.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen contacto">
        </picture>
        <h2>Llene el formulario de contacto</h2>

        <form class="formulario">
            <fieldset>
                <legend>Información Personal</legend>
                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Tu Nombre" id="nombre">

                <label for="email">E-Mail</label>
                <input type="email" placeholder="Tu E-mail" id="email">

                <label for="telefono">Telefono</label>
                <input type="tel" placeholder="Telefono" id="telefono">

                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje"> </textarea>
            </fieldset>
            <fieldset>
                <legend>Informacion sobre la propiedad</legend>
                <label for="mensaje">Vende o compra</label>
                <select id="opciones">
                    <option value="" disabled selected>Seleccione</option>
                    <option value="Compra">Compra</option>
                    <option value="Vende">Vende</option>
                </select>
                <label for="presupuesto">Precio</label>
                <input type="number" placeholder="Tu precio o presupuesto" id="presupuesto">

            </fieldset>
            <fieldset>
                <legend>Informacion sobre la propiedad</legend>
                <p>Como desea ser contactado</p>
                <div class="forma-contacto">
                    <label for="contactar-telefono">Telefono</label>
                    <input name="contacto" type="radio" value="telefono" id="contactar-telefono">

                    <label for="contactar-email">E-Mail</label>
                    <input name="contacto" type="radio" value="telefono" id="contactar-email">
                </div>
                <p>Si eligio telefono, elija la fecha y hora para ser contactado</p>

                <label for="fecha">Fecha</label>
                <input type="date" id="fecha">

                <label for="hora">Hora</label>
                <input type="time" id="hora" min="09:00" max="19:00">

            </fieldset>
            <input type="submit" value="Enviar" class="boton-verde">
        </form>
    </main>


    <?php
    incluirTemplate('footer');
    ?>