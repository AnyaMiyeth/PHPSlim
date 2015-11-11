<?php

require_once('datos/usuarios_model_pdo.php');

//Buen Manual
//https://manuais.iessanclemente.net/index.php/Introduccion_a_API_REST_y_framework_Slim_de_PHP

// Activamos las sesiones para el funcionamiento de flash['']
@session_start();
 
require 'Slim/Slim.php';
// El framework Slim tiene definido un namespace llamado Slim
// Por eso aparece \Slim\ antes del nombre de la clase.
\Slim\Slim::registerAutoloader();

// Creamos la aplicación.
$app = new \Slim\Slim();

// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
#$app->contentType('text/html; charset=utf-8');

// Definimos conexion de la base de datos.
// Lo haremos utilizando PDO con el driver mysql.

//$db->exec("set names utf8");
 

$app->get('/', function() {
            echo "Pagina de gestión API REST de mi aplicación.";
        });

        // Cuando accedamos por get a la ruta /usuarios ejecutará lo siguiente:
$app->get('/usuarios', function() {
            // Si necesitamos acceder a alguna variable global en el framework
            // Tenemos que pasarla con use() en la cabecera de la función. Ejemplo: use($db)
            // Va a devolver un objeto JSON con los datos de usuarios.
            // Preparamos la consulta a la tabla.
            $usuario1 = new Usuario();
            // Devolvemos ese array asociativo como un string JSON.
            echo json_encode($usuario1->get_all());
});

// Accedemos por get a /usuarios/ pasando un id de usuario. 
// Por ejemplo /usuarios/veiga
// Ruta /usuarios/id
// Los parámetros en la url se definen con :parametro
// El valor del parámetro :idusuario se pasará a la función de callback como argumento
$app->get('/usuarios/:email', function($email)  {
            // Va a devolver un objeto JSON con los datos de usuarios.
            // Preparamos la consulta a la tabla.
            $usuario1 = new Usuario();
            // Devolvemos ese array asociativo como un string JSON.
            echo json_encode($usuario1->get($email));
        });

// Alta de usuarios en la API REST
$app->post('/usuarios',function() use($app) {
    // Los datos serán accesibles de esta forma:
    $p = json_decode($app->request->getBody());
    //echo json_encode($p->nombre);
    $usuario = new Usuario();
    $usuario->id=$p->id;
    $usuario->apellido=$p->apellido;
    $usuario->nombre=$p->nombre;
    $usuario->email=$p->email;
    $estado = $usuario->save();
    
    if ($estado)
        echo json_encode(array('estado'=>true,'mensaje'=>'Datos insertados correctamente. ','id'=> $usuario->id));
    else
        echo json_encode(array('estado'=>false,'mensaje'=>"Error al insertar datos en la tabla.",'id'=> ''));
});

        
$app->run();        
?>
