<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {

    public static function login(Router $router){

        $alertas=[];
       

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth = new Usuario($_POST);
          
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //Verificar que el usuario exista
                $usuario = Usuario::where('email', $auth->email);

                if(!$usuario){
                    Usuario::setAlerta('error', 'El usuario no existe en la base de datos');
                }else{
                    if($usuario->confirmado != 1){
                        Usuario::setAlerta('error', 'El usuario no esta confirmado');
                    }else{
                        //El usuario existe y esta confirmado
                        if( password_verify($_POST['password'], $usuario->password) ){
                            //Iniciar sesion
                            session_start();
                            $_SESSION = [];
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['nombre'] = $usuario->nombre;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['login'] = true;

                            //redireccionar
                            header('Location: /dashboard');

                            

                        }else{
                            Usuario::setAlerta('error', 'Password incorrecto');
                        }
                    }
                }
                
            }
        }
        //Render a la vista

        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function logout(){
        session_start();

        $_SESSION=[];
        header('Location: /');
  
    }

    public static function crear(Router $router){
        $alertas = [];
        $usuario = new Usuario;
      
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)){

                $exiteUsuario = Usuario::where('email', $usuario->email);
                
                if($exiteUsuario){
        
                    Usuario::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    //Crear el nuevo usuario

                    //hash al password
                    $usuario->hashPassword();
                    //Eliminar password2
                    unset($usuario->password2);
                    //Generar token
                    $usuario->crearToken();

                    $resultado= $usuario->guardar();

                    //Enviar Email
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);

                    $email->enviarConfirmacion();

                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }

        //Render a la vista

        $router->render('auth/crear',[
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){
        
        $alertas =[];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $usuario = new Usuario($_POST);
            $alertas= $usuario->validarEmail();

            if(empty($alertas)){
                //Buscar el usuario
                $usuario = $usuario->where('email',$usuario->email);
                
                if($usuario && $usuario->confirmado === "1"){
                    //Generar un token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    //Actualizar el usuario
                    $usuario->guardar();
                    //Enviar el email
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarInstrucciones();
                    //Imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        //Render a la vista

        $router->render('auth/olvide',[
            'titulo' => 'Recuperar Password',
            'alertas' => $alertas
        ]);
    }

    public static function restablecer(Router $router){
        
        $token = s($_GET['token']);
        $mostrar = true;
        if(!$token){
            header('Location: /');
        }
        //Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no Válido');
            $mostrar=false;
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){
            //Añadir nuevo password
            $usuario->sincronizar(($_POST));

            //Validar el password
            $alertas = $usuario->validarPassword();

           if(empty($alertas)){
                //Hashear password
                $usuario->hashPassword();
                unset($usuario->password2);
                $usuario->token=null;
                $resultado = $usuario->guardar();

                if($resultado){
                    header('Location: /');
                }
           }
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista

        $router->render('auth/restablecer',[
            'titulo' => 'Restablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje',[
            'titulo' => 'Cuenta Creada'
        ]);
  
    }

    public static function confirmar(Router $router){

        $token = s($_GET['token']);

        if(!$token){
            header('Location: /');
        }
        //Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)){
            Usuario::setAlerta('error','Token no Válido');
        } else{
            //Confirmar la cuenta
            $usuario->confirmado=1;
            unset($usuario->password2);
            $usuario->token = null;
            
            $usuario->guardar();

            Usuario::setAlerta('exito','Cuenta comprobada Correctamente');

        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar',[
            'titulo' => 'Confirma tu cuenta',
            'alertas' => $alertas
        ]);
    }

}