<?php 

require_once __DIR__ . '/../includes/app.php';


use Controllers\DashboardController;
use Controllers\LoginController;
use MVC\Router;
$router = new Router();


//Login
$router->get('/',[LoginController::class, 'login']);
$router->post('/',[LoginController::class, 'login']);
$router->get('/logout',[LoginController::class, 'logout']);

//Creacion de cuentas
$router->get('/crear',[LoginController::class, 'crear']);
$router->post('/crear',[LoginController::class, 'crear']);

//Olvido password
$router->get('/olvide',[LoginController::class, 'olvide']);
$router->post('/olvide',[LoginController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/restablecer',[LoginController::class, 'restablecer']);
$router->post('/restablecer',[LoginController::class, 'restablecer']);

//Confirmarción de cuenta
$router->get('/mensaje',[LoginController::class, 'mensaje']);
$router->get('/confirmar',[LoginController::class, 'confirmar']);

// zona de proyectos
$router->get('/dashboard',[DashboardController::class, 'index']);
$router->get('/crear-proyecto',[DashboardController::class, 'crear']);
$router->get('/perfil',[DashboardController::class, 'perfil']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();