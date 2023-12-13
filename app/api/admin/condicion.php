<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/condicion.php');

if (isset($_GET['action'])) {
    session_start();
    $condicion = new Condicion;
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    if (isset($_SESSION['idusuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $condicion->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay condiciones registradas';
                    }
                }
                break;
            case 'search':
                    $_POST = $condicion->validateForm($_POST);
                    if ($_POST['search'] != '') {
                        if ($result['dataset'] = $condicion->searchRows($_POST['search'])) {
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
                $_POST = $condicion->validateForm($_POST);
                if ($condicion->setCondicion($_POST['condicion'])) {
                    if ($condicion->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Condición creada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } else {
                    $result['exception'] = 'Condición incorrecta';
                }
                break;
            case 'readOne':
                if ($condicion->setId($_POST['idcondicion'])) {
                    if ($result['dataset'] = $condicion->readOne()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Condición inexistente';
                        }
                    }
                } else {
                    $result['exception'] = 'Condición incorrecta';
                }
                break;
            case 'update':
                $_POST = $condicion->validateForm($_POST);
                if ($condicion->setId($_POST['idcondicion'])) {
                    if ($data = $condicion->readOne()) {
                        if ($condicion->setCondicion($_POST['condicion'])) {
                            if ($condicion->updateRow()) {
                                $result['status'] = 1;
                                $result['message'] = 'Condición modificada correctamente';
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = 'Condición incorrecta';
                        }
                    } else {
                        $result['exception'] = 'Condición inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo incorrecto';
                }
                break;
            case 'delete':
                if ($condicion->setId($_POST['idcondicion'])) {
                    if ($data = $condicion->readOne()) {
                        if ($condicion->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Condición eliminada correctamente';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Condición inexistente';
                    }
                } else {
                    $result['exception'] = 'Condición incorrecta';
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
