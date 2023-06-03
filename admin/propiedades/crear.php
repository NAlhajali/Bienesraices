<?php 

        require '../../includes/funciones.php';
        $auth = estaAuntenticado();

        if(!$auth) {
            header('Location: /');
        }
    // Base de datos
    require '../../includes/config/databases.php';
    $db =conectarDB();

    //Consulta para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    // Arreglo con mensaje de errores
    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamientos = '';
    $vendedores_Id = '';


    //Eejecutas el codigo despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // echo"<pre>";
        // var_dump($_POST);
        // echo"</pre>";

        echo"<pre>";
        var_dump($_FILES); // sirve para ver imagenes
        echo"</pre>";


    //     $numero = "1hola";
    //     $numero2 = 1;


    //    // SANITIZAR -- NO PERMITIR CODIGOS MALICIOS CUANDO LLENEN EL FORM LOS CLIENTES 
    //     $resultado = filter_var($numero, FILTER_SANITIZE_NUMBER_INT);
        
    //     $resultado = filter_var($numero2, FILTER_VALIDATE_INT );
        

    //     var_dump($resultado);

    //     exit;
        
        
        $titulo = mysqli_real_escape_string( $db,  $_POST['titulo'] );
        $precio = mysqli_real_escape_string( $db,   $_POST['precio'] );
        $descripcion = mysqli_real_escape_string( $db,   $_POST['descripcion'] );
        $habitaciones = mysqli_real_escape_string( $db,   $_POST['habitaciones'] );
        $wc = mysqli_real_escape_string( $db,   $_POST['wc'] );
        $estacionamientos = mysqli_real_escape_string( $db,   $_POST['estacionamientos'] );
        $vendedores_Id = mysqli_real_escape_string( $db,   $_POST['vendedor'] );
        $creado = date('Y/m/d');

        // Asignar files hacia una variable
        $imagen = $_FILES['imagen'];


        if(!$titulo) {
            $errores[] = 'Debes añadir el titulo';
        }
        if(!$precio) {
            $errores[] = 'Debes añadir el precio';
        }
        if(strlen( $descripcion ) < 50) { // strlen obliga al usuario a escribir 50 caractares 
            $errores[] = 'La descripcion debe tener al menos 50 caractares';
        }
        if(!$habitaciones) {
            $errores[] = 'El campo de habitaciones es obligatorio';
        }
        if(!$wc) {
            $errores[] = 'El campo de wc es obligatorio';
        }
        if(!$estacionamientos) {
            $errores[] = 'El campo de estacionamientos es obligatorio';
        }
        if(!$vendedores_Id) {
            $errores[] = 'Elije un vendedor';
        }
        if(!$imagen ['name'] || $imagen['error'] ) {
            $errores[] = 'La imagen es obligatoria';
        }
        // Validar por tamaño (1mb maximo) solo para mostrar como se hace
            $medida = 1000 * 1000;

            if($imagen['size'] >$medida) {
                $errores[] = 'La imagen es muy pesada';
            }



        // echo"<pre>";
        // var_dump($errores);
        // echo"</pre>";

        // Revisar que el arreglo de error este vacio 
        if(empty($errores)) {

            /** SUBIDA DE ARCHIVOS , PARA GUARDARLAS  */

            //Crear carpeta 
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)) { /** este es el if  */
                mkdir($carpetaImagenes); /** mkdir sirve para crear directorios siempre poner un if */
            }
            //generar un nombre unico a la imagen o archivo
            $nombreImagen = md5( uniqid( rand(), true )) . ".jpg";

            // Subir imgen a la carpeta creada con mkdir 

            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes .  $nombreImagen );
                


                //Insertar en la base de datos 
        $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamientos, 
        creado, vendedores_Id ) VALUES ( '$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', 
        '$estacionamientos', '$creado', '$vendedores_Id' ) ";

        // echo $query;

        $resultado = mysqli_query($db, $query);

        if($resultado) {
    // redireccioanr al usuario luego de enviar la info en el form
            header ('Location: /admin?resultado=1'); // redireccione al usuario luego de enviar el form
        }
        }
        // //Insertar en la base de datos 
        // $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamientos, vendedores_Id ) VALUES ( '$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamientos', '$vendedores_Id' ) ";

        // // echo $query;

        // $resultado = mysqli_query($db, $query);
        // if($resultado) {
        //     echo "Insertado Correctamente";
        // }
    }   

    
    incluirTemplate('header');
    ?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error ): ?> 
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo;?>">

            <label for="titulo">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio;?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion;?></textarea>

        </fieldset> 

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="12" value="<?php echo $habitaciones;?>">

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="12"value="<?php echo $wc;?>">

            <label for="estacionamientos">Estacionamientos:</label>
            <input type="number" id="estacionamientos" name="estacionamientos" placeholder="Ej: 3" min="1" max="12"value="<?php echo $estacionamientos;?>"> <!--se agrega el value con php para guardar lo rellenado en el campo  -->

        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedor">
                <option value="">--Seleccione--</option> 
                <?php  while($vendedores = mysqli_fetch_assoc($resultado) ):?> <!-- asi se hace el arreglo y la parte de abajo -->
                    <option <?php echo $vendedores_Id === $vendedores['id'] ? 'selected' : ''; ?>  value="<?php echo $vendedores['id']; ?>"> <?php echo $vendedores['nombre'] . "" . $vendedores['apellido']; ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php 
    incluirTemplate('footer'); 
    ?>