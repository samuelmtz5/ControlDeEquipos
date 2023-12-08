<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/tipos.php');

if (isset($_GET['action'])) {
    session_start();
    $tipo = new Tipos;
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    if (isset($_SESSION['idusuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $tipo->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay tipos registrados';
                    }
                }
                break;
            case 'search':
                    $_POST = $tipo->validateForm($_POST);
                    if ($_POST['search'] != '') {
                        if ($result['dataset'] = $tipo->searchRows($_POST['search'])) {
                            $result['status'] = 1;
                            $rows = count($result['dataset']);
                            if ($rows > 1) {
                                $result['message'] = 'Se encontraron ' . $rows . ' coincidencias';
                            } else {
                                $result['message'] = 'Solo existe una coincidencia';
                            }
                        } else {
                            if (Database::getException()) {
                                $result['exception'] = Database::getException();
                            } else {
                                $result['exception'] = 'No hay coincidencias';
                            }
                        }
                    } else {
                        $result['exception'] = 'Ingrese un valor para buscar';
                    }
                    break;
            case 'create':
                $_POST = $tipo->validateForm($_POST);
                if ($tipo->setTipoE($_POST['tipoequipo'])) {
                    if ($tipo->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Tipo creado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } else {
                    $result['exception'] = 'Tipo incorrecto';
                }
                break;
            case 'readOne':
                if ($tipo->setId($_POST['idtipoequipo'])) {
                    if ($result['dataset'] = $tipo->readOne()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Tipo inexistente';
                        }
                    }
                } else {
                    $result['exception'] = 'Tipo incorrecto';
                }
                break;
            case 'update':
                $_POST = $tipo->validateForm($_POST);
                if ($tipo->setId($_POST['idtipoequipo'])) {
                    if ($data = $tipo->readOne()) {
                        if ($tipo->setTipoE($_POST['tipoequipo'])) {
                            if ($tipo->updateRow()) {
                                $result['status'] = 1;
                                $result['message'] = 'Tipo modificado correctamente';
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = 'Tipo incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Tipo inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo incorrecto';
                }
                break;
            case 'delete':
                if ($tipo->setId($_POST['idtipoequipo'])) {
                    if ($data = $tipo->readOne()) {
                        if ($tipo->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Tipo eliminado correctamente';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Tipo inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo incorrecto';
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
