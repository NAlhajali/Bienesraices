<?php 

require 'includes/funciones.php';


incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Guia para la Decoración de tu Hogar</h1>
        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada2.jpg" alt="imagen de la propiedad">
        </picture>
        <p class="informacion-meta">Escrito el: <span>20/06/2023</span> por: <span>Admin</span></p>

        <div class="resumen-propiedad">
            <p>Phasellus molestie quis ipsum eget euismod. Aliquam erat volutpat. Praesent id urna eu lorem rutrum posuere. Nullam sed arcu nec sem convallis aliquet. In hac habitasse platea dictumst. Nam tellus leo, aliquet cursus venenatis eget, ultrices id erat. Nulla dolor ligula, semper eget porttitor id, dignissim vel risus. Proin gravida eros id augue sodales, a mattis ipsum sollicitudin. Aliquam scelerisque, lorem vel iaculis consequat, arcu urna venenatis augue, sit amet cursus velit sapien ac dui. Curabitur vel lectus et tortor gravida tristique.</p>

            <p>Quisque facilisis convallis nisi, sed ultricies odio accumsan ut. Aenean sed lectus ornare, iaculis nulla hendrerit, sodales urna. Curabitur pellentesque ultricies laoreet. Aliquam erat volutpat. Quisque sed dolor magna. Morbi at ex erat. Nulla aliquam sit amet ligula vel lacinia. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ut convallis massa, iaculis hendrerit quam. Quisque dapibus ipsum lacus, a feugiat neque ultricies eleifend.</p>
        </div>
    </main>

     
<?php 

incluirTemplate('footer'); 
?>
