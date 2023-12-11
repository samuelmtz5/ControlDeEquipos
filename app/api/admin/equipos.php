<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/equipos.php');

if (isset($_GET['action'])) {
    session_start();
    $equipo = new Equipos;
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    if (isset($_SESSION['idusuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $equipo->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay equipos registrados';
                    }
                }
                break;
            case 'search':
                $_POST = $equipo->validateForm($_POST);
                if ($_POST['search'] != '') {
                    if ($result['dataset'] = $equipo->searchRows($_POST['search'])) {
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
                $_POST = $equipo->validateForm($_POST);
                if ($equipo->setModelo($_POST['Modelo'])) {
                    if ($equipo->setSerie($_POST['Serie'])) {
                        if ($equipo->setActivo($_POST['Activo'])) {
                            if($equipo->setTipoEquipo($_POST['Tipo'])){
                                if($equipo->setAdquisicion($_POST['Adquisicion'])){
                                    if($equipo->setCondicion($_POST['Condicion'])){
                                        if($equipo->setEncargado($_POST['Encargado'])){
                                            if($equipo->setMarca($_POST['Marca'])){
                                                if($equipo->setNivel($_POST['Nivel'])){
                                                    if ($equipo->createRow()) {
                                                        $result['status'] = 1;
                                                        $result['message'] = 'Equipo creado correctamente';
                                                    } else {
                                                        $result['exception'] = Database::getException();
                                                    }
                                                }else{
                                                    $result['exception'] = 'Nivel incorrecto';
                                                }
                                            }else{
                                                $result['exception'] = 'Marca incorrecta';
                                            }
                                        }else{
                                            $result['exception'] = 'Encargado incorrecto';
                                        }
                                    }else{
                                        $result['exception'] = 'Condición incorrecta';
                                    }
                                }else{
                                    $result['exception'] = 'Adquisición incorrecta';
                                }
                            }else{
                                $result['exception'] = 'Tipo incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Activo incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Serie incorrecta';
                    }
                } else {
                    $result['exception'] = 'Modelo incorrecto';
                }
                break;
            case 'readOne':
                if ($equipo->setId($_POST['idEquipo'])) {
                    if ($result['dataset'] = $equipo->readOne()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Equipo inexistente';
                        }
                    }
                } else {
                    $result['exception'] = 'Equipo incorrecto';
                }
                break;
            case 'update':
                $_POST = $equipo->validateForm($_POST);
                if ($equipo->setId($_POST['idEquipo'])) {
                    if ($data = $equipo->readOne()) {
                        if ($equipo->setModelo($_POST['Modelo'])) {
                            if ($equipo->setSerie($_POST['Serie'])) {
                                if ($equipo->setActivo($_POST['Activo'])) {
                                    if($equipo->setTipoEquipo($_POST['Tipo'])){
                                        if($equipo->setAdquisicion($_POST['Adquisicion'])){
                                            if($equipo->setCondicion($_POST['Condicion'])){
                                                if($equipo->setEncargado($_POST['Encargado'])){
                                                    if($equipo->setMarca($_POST['Marca'])){
                                                        if($equipo->setNivel($_POST['Nivel'])){
                                                            if ($equipo->updateRow()) {
                                                                $result['status'] = 1;
                                                                $result['message'] = 'Equipo modificado correctamente';
                                                            } else {
                                                                $result['exception'] = Database::getException();
                                                            }
                                                        }else{
                                                            $result['exception'] = 'Nivel incorrecto';
                                                        }
                                                    }else{
                                                        $result['exception'] = 'Marca incorrecta';
                                                    }
                                                }else{
                                                    $result['exception'] = 'Encargado incorrecto';
                                                }
                                            }else{
                                                $result['exception'] = 'Condición incorrecta';
                                            }
                                        }else{
                                            $result['exception'] = 'Adquisición incorrecta';
                                        }
                                    }else{
                                        $result['exception'] = 'Tipo incorrecto';
                                    }
                                } else {
                                    $result['exception'] = 'Activo incorrecto';
                                }
                            } else {
                                $result['exception'] = 'Serie incorrecta';
                            }
                        } else {
                            $result['exception'] = 'Modelo incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Equipo inexistente';
                    }
                } else {
                    $result['exception'] = 'Equipo incorrecto';
                }
                break;
            case 'delete':
                if ($equipo->setId($_POST['idEquipo'])) {
                    if ($data = $equipo->readOne()) {
                        if ($equipo->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Equipo eliminado correctamente';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Equipo inexistente';
                    }
                } else {
                    $result['exception'] = 'Equipo incorrecto';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
