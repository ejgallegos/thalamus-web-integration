<?php
//require_once 'core/helpers/user.php';
//require_once 'modules/usuario/model.php';
//require_once 'modules/configuracionmenu/model.php';


class SessionBaseHandler {
    function checkin() {
		$usuario = filter_input(INPUT_POST, "usuario");
		$usuario = strtolower(trim($usuario));
        $user = hash(ALGORITMO_USER, $usuario);
        $clave = hash(ALGORITMO_PASS, filter_input(INPUT_POST, "contrasena"));
        $hash = hash(ALGORITMO_FINAL, $user . $clave);
        $usuariodetalle_id = User::get_usuariodetalle_id($hash);
        
        if ($usuariodetalle_id != 0) {
            $usuario_id = User::get_usuario_id($usuariodetalle_id);
            if ($usuario_id != 0) {
                $um = new Usuario();
                $um->usuario_id = $usuario_id;
                $um->get();

                $nivel_denominacion = ($um->nivel == 1) ? "Operador" : "";
                $nivel_denominacion = ($um->nivel == 2) ? "Analista" : $nivel_denominacion;
                $nivel_denominacion = ($um->nivel == 3) ? "Administrador" : $nivel_denominacion;
                $nivel_denominacion = ($um->nivel == 9) ? "Desarrollador" : $nivel_denominacion;
                $data_login = array(
                    "usuario-usuario_id"=>$um->usuario_id,
                    "usuario-denominacion"=>$um->denominacion,
                    "usuario-nivel"=>$um->nivel,
                    "nivel-denominacion"=>$nivel_denominacion,
                    "usuariodetalle-nombre"=>$um->usuariodetalle->nombre,
                    "usuariodetalle-apellido"=>$um->usuariodetalle->apellido,
                    "usuariodetalle-gerencia_id"=>$um->usuariodetalle->centrocosto->gerencia->gerencia_id,
                    "usuariodetalle-sector"=>$um->usuariodetalle->centrocosto->gerencia->denominacion,
                    "usuariodetalle-departamento"=>$um->usuariodetalle->centrocosto->denominacion,
                    "usuariodetalle-distrito"=>$um->usuariodetalle->unicom->denominacion,
                    "usuariodetalle-correoelectronico"=>$um->usuariodetalle->correoelectronico,
                    "usuario-configuracionmenu"=>$um->configuracionmenu->configuracionmenu_id);
                
                $_SESSION["data-login-" . APP_ABREV] = $data_login;
                $_SESSION['login' . APP_ABREV] = true;
                $redirect = URL_APP . "/usuario/panel";
            }
        } else {
            $_SESSION['login' . APP_ABREV] = false;
            $redirect = URL_APP . "/usuario/login/mError";
        }

        header("Location: $redirect");
    }

    function check_session() {
        if($_SESSION['login' . APP_ABREV] !== true) {
            $this->checkout();
        }
    }

    function check_panel($usr_nivel) {
        switch ($usr_nivel) {
            case 1:
                $panel = "operador";
                break;
            case 2:
                $panel = "analista";
                break;
            case 3:
                $panel = "administrador";
                break;
            case 9:
                $panel = "administrador";
                break;
            default:
                $panel = "operador";
                break;
        }

        return $panel;
    }

    function check_admin_level() {
        $level = $_SESSION["data-login-" . APP_ABREV]["usuario-nivel"]; 
        if ($level != 9) {
            $this->checkout();
        }
    }

    function check_level() {
        $level = $_SESSION["data-login-" . APP_ABREV]["usuario-nivel"]; 
        if ($level > 1 ) {
            $_SESSION['login' . APP_ABREV] = true;
        } else {
            $this->checkout();
        }
    }

    function checkout() {
        $_SESSION[] = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"], 
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        $_SESSION['data-login' . APP_ABREV] = false;
        $_SESSION['login' . APP_ABREV] = false;
        header("Location:" . URL_APP . "/usuario/login");
    }
}

function SessionHandler() { return new SessionBaseHandler();}