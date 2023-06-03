<?php 

    require 'includes/config/databases.php';
    $db = conectarDB();
    // Autenticar el usuario

    $errores = []; // se coloca afuera para que itere en cualquier lugar

    if($_SERVER['REQUEST_METHOD']=== 'POST') {
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db,  $_POST['password']);

        if(!$email) {
            $errores[] = "El email es obligatorio o no es valido";
        }
        if(!$password) {
            $errores[] = "El password es obligatorio";
        }
        
        if(empty($errores)) {

            //Revisar si el usuario existe 
            $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
            $resultado = mysqli_query($db, $query);


          

            if( $resultado-> num_rows ){
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // Verificar si el password es correcto o no 

                $auth = password_verify($password, $usuario['password']);
                
                if($auth) {
                    // El usuario esta autenticado
                    session_start();

                    //Llenar el arreglo de la sesion 
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');


                    // echo "<pre>";
                    // var_dump($_SESSION);
                    // echo "</pre>";

                 } else {
                    $errores[] = 'El password es incorrecto';
                }
            }  else {
                $errores[] = 'El usuario no existe';
            }
        }

    }

    //Incluye el header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error) : ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach ?>

        <form  method="POST" class="formulario">
        <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email">

                <label for="telefono">Password</label>
                <input type="password" name="password" placeholder="Tu password" id="password">

            </fieldset> <!-- Aqui termina primero form-->

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        
        </form>
    </main>

<?php 
    incluirTemplate('footer'); 
?>