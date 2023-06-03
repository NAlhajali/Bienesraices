<?php 

        require '../../includes/funciones.php';
        $auth = estaAuntenticado();

        if(!$auth) {
            header('Location: /');
        }

        // Validar la URL que sea un id valido
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin'); // se redirecciona a la pagina admin si no estas haciendo las cpsas bien 
        }


        // Base de datos
        require '../../includes/config/databases.php';
        $db =conectarDB();

        // Otra consulta a base de datos para obtener los datos de la propiedad
        $consulta = "SELECT * FROM propiedades WHERE id = {$id}";
        $resultado = mysqli_query($db, $consulta); // no hay problema que se mezcle con el resultado de abajo (porque la parte de abajo se hace el fetch_assoc)
        $propiedad = mysqli_fetch_assoc($resultado); // aqui asigno los resultado , asi no choca con el resultado de abajo. se usa fetch assoc porque solo es uno, sino se usara WHILE

        // echo "<pre>";
        // var_dump($propiedad);
        // echo "</pre>";


        //Consulta para obtener los vendedores
        $consulta = "SELECT * FROM vendedores";
        $resultado = mysqli_query($db, $consulta);

        // Arreglo con mensaje de errores
        $errores = [];

        $titulo = $propiedad['titulo'];
        $precio = $propiedad['precio'];
        $descripcion = $propiedad['descripcion'];
        $habitaciones = $propiedad['habitaciones'];
        $wc = $propiedad['wc'];
        $estacionamientos = $propiedad['estacionamientos'];
        $vendedores_Id = $propiedad['vendedores_id'];
        $imagenPropiedad = $propiedad['imagen'];


        //Eejecutas el codigo despues de que el usuario envia el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            echo"<pre>";
            var_dump($_POST);
            echo"</pre>";

            

            // echo"<pre>";
            // var_dump($_FILES); // sirve para ver imagenes
            // echo"</pre>";


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

            // comenta la imagen porque ya no es obligatoria en actualizar la propiedad.
            // if(!$imagen ['name'] || $imagen['error'] ) {
            //     $errores[] = 'La imagen es obligatoria'; 
            // }


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

                            // //Crear carpeta 
                $carpetaImagenes = '../../imagenes/';

                if(!is_dir($carpetaImagenes)) { /** este es el if  */
                    mkdir($carpetaImagenes); /** mkdir sirve para crear directorios siempre poner un if */
                }

                $nombreImagen = '';

                
                /** SUBIDA DE ARCHIVOS , PARA GUARDARLAS  */
            
                if($imagen['name']) {
                    // Elimar imagen anterior ya subida , para agregar la nueva 
                    
                    unlink($carpetaImagenes . $propiedad['imagen']); // con unlink se elimina la imagen anterior y se sube  la nueva.
            
                            // //generar un nombre unico a la imagen o archivo
                    $nombreImagen = md5( uniqid( rand(), true )) . ".jpg";

                            // // Subir imgen a la carpeta creada con mkdir 
                    move_uploaded_file($imagen['tmp_name'], $carpetaImagenes .  $nombreImagen );
                
                } else {
                    $nombreImagen = $propiedad['imagen'];
                }

                    //Insertar en la base de datos 
            $query = " UPDATE propiedades SET titulo = '{$titulo}', precio = '{$precio}', imagen = '{$nombreImagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamientos = {$estacionamientos}, vendedores_Id = '{$vendedores_Id}' WHERE id = {$id} ";
            
            // echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado) {
            // redireccioanr al usuario luego de enviar la info en el form
                header ('Location: /admin?resultado=2'); // redireccione al usuario luego de enviar el form
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
            <h1>Actualizar propiedades</h1>

            <a href="/admin" class="boton boton-verde">Volver</a>

            <?php foreach($errores as $error ): ?> 
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo;?>">

                <label for="titulo">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio;?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <img src="/imagenes/<?php echo $imagenPropiedad; ?>" class="imagen-small">

                
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

            <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
            </form>
        </main>

        <?php 
        incluirTemplate('footer'); 
        ?>