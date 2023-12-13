<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/adquisicion.php');

if (isset($_GET['action'])) {
    session_start();
    $adquisicion = new Adquisicion;
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    if (isset($_SESSION['idusuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $adquisicion->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay adquisiciones registradas';
                    }
                }
                break;
            case 'search':
                    $_POST = $adquisicion->validateForm($_POST);
                    if ($_POST['search'] != '') {
                        if ($result['dataset'] = $adquisicion->searchRows($_POST['search'])) {
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
                $_POST = $adquisicion->validateForm($_POST);
                if ($adquisicion->setAdquisicion($_POST['adquisicion'])) {
                    if ($adquisicion->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Adquisición creada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } else {
                    $result['exception'] = 'Adquisición incorrecta';
                }
                break;
            case 'readOne':
                if ($adquisicion->setId($_POST['idadquisicion'])) {
                    if ($result['dataset'] = $adquisicion->readOne()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Adquisición inexistente';
                        }
                    }
                } else {
                    $result['exception'] = 'Adquisición incorrecta';
                }
                break;
            case 'update':
                $_POST = $adquisicion->validateForm($_POST);
                if ($adquisicion->setId($_POST['idadquisicion'])) {
                    if ($data = $adquisicion->readOne()) {
                        if ($adquisicion->setAdquisicion($_POST['adquisicion'])) {
                            if ($adquisicion->updateRow()) {
                                $result['status'] = 1;
                                $result['message'] = 'Adquisición modificada correctamente';
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = 'Adquisición incorrecta';
                        }
                    } else {
                        $result['exception'] = 'Adquisición inexistente';
                    }
                } else {
                    $result['exception'] = 'Adquisición incorrecta';
                }
                break;
            case 'delete':
                if ($adquisicion->setId($_POST['idadquisicion'])) {
                    if ($data = $adquisicion->readOne()) {
                        if ($adquisicion->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Adquisición eliminada correctamente';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Adquisición inexistente';
                    }
                } else {
                    $result['exception'] = 'Adquisición incorrecta';
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
