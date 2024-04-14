<?php

namespace Controllers;

use MVC\Router;

class DashboardController{

    public static function index(Router $router){
        session_start();

        isAuth();
        $router->render('dashboard/index',[
           'titulo' => 'Proyectos'
        ]);
    }

    public static function crear(Router $router){

        session_start();

        isAuth();
        $router->render('dashboard/crear',[
           'titulo' => 'Crear Proyecto'
        ]);
    }
    public static function perfil(Router $router){

        session_start();

        isAuth();
        $router->render('dashboard/perfil',[
           'titulo' => 'Perfil'
        ]);
    }

    
}