<?php 

require 'includes/funciones.php';


incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <source srcset="build/img/destacada3.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="imagen contacto">
        </picture>

        <h2>Llene el formulario de Contacto</h2>
        <form class="formulario">
            <fieldset>
                <legend>Informacion Personal</legend>

                <label for="nombre">Nombre</label> <!-- aqui va el nombre -->
                <input type="text" placeholder="Tu Nombre" id="nombre"> <!-- el id es para darle click -->

                <label for="email">E-mail</label>
                <input type="email" placeholder="Tu Email" id="email">

                <label for="telefono">Telefono</label>
                <input type="tel" placeholder="Tu teléfono" id="telefono">

                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje"></textarea>
            </fieldset> <!-- Aqui termina primero form-->
            
            <fieldset> <!-- aqui empieza el segundo form-->
                <legend>Informacion sobre la propiedad</legend>

                <label for="opciones">Vende o Compra:</label> <!--para dar opciones en el form-->
                <select id="opciones">
                    <option value="" disabled selected>-- Seleccione --</option> <!--que salga selecionar-->
                    <option value="Compra">Compra</option>
                    <option value="Vende">Vende</option>
                </select>
                <label for="presupuesto">Precio o Presupuesto</label>
                <input type="number" placeholder="Tu precio o presupuesto" id="presupuesto">
            </fieldset><!-- aqui termina el segundo form-->

            <fieldset> <!-- aqui empieza el tercer form-->
                <legend>Informacion sobre la propiedad</legend>

                <p>Como desea ser contactado</p>
                <div class="forma-contacto">
                    <label for="contactar-telefono">Telefono</label>
                    <input name="contacto" type="radio" value="telefono" id="contactar-telefono"> <!-- el name permite que solo se eliga una opccion-->

                    <label for="contactar-email">Email</label>
                    <input name="contacto" type="radio" value="email" id="contactar-email">
                </div>

                <p>Si eligio teléfono, elija la fecha y hora</p>
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha">

                <label for="hora">Hora</label>
                <input type="time" id="hora" min="09:00" max="18:00">
            </fieldset>    
            <input type="submit" value="Enviar" class="boton-verde">
        </form>
    </main>

    <?php 
incluirTemplate('footer'); 
?>
