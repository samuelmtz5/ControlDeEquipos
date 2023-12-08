<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/tipousuario.php');

if (isset($_GET['action'])) {
    session_start();
    $tipou = new TipoUsuario;
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    if (isset($_SESSION['idusuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $tipou->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay niveles registrados';
                    }
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        header('content-type: application/json; charset=utf-8');
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
