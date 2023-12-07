<?php
/*
*	Clase para manejar la tabla usuarios de la base de datos. Es clase hija de Validator.
*/
class Usuarios extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombres = null;
    private $apellidos = null;
    private $dui = null;
    private $correo = null;
    private $user = null;
    private $passwrd = null;
    private $tipo = null;
    private $nivel = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombres($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidos($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->apellidos = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDUI($value)
    {
        if ($this->validateAlphabetic($value, 1, 10)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if ($this->validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUser($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->user = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPasswrd($value)
    {
        if ($this->validatePassword($value)) {
            $this->passwrd = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipo($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNivel($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->nivel = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNombres()
    {
        return $this->nombres;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getDUI()
    {
        return $this->dui;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPasswrd()
    {
        return $this->passwrd;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getNivel()
    {
        return $this->nivel;
    }

    /*
    *   Métodos para gestionar la cuenta del usuario.
    */
    public function checkUser($user)
    {
        $sql = 'SELECT idUsuario FROM Usuario WHERE username = ?';
        $params = array($user);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['idusuario'];
            $this->user = $user;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($passwrd)
    {
        $sql = 'SELECT passwrd FROM usuario WHERE idusuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if ($passwrd === $data['passwrd']) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        // Se transforma la contraseña a una cadena de texto de longitud fija mediante el algoritmo por defecto.
        $hash = password_hash($this->passwrd, PASSWORD_DEFAULT);
        $sql = 'UPDATE usuario SET passwrd = ? WHERE idusuario = ?';
        $params = array($hash, $_SESSION['idusuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT idUsuario, nombres, apellidos, DUI, correo, username, nivel
                FROM Usuario
                INNER JOIN Nivel USING(idNivel)
                WHERE idUsuario = ?';
        $params = array($_SESSION['idUsuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE Usuario
                SET nombres = ?, apellidos = ?, DUI = ?, correo = ?, user = ?, idTipoUsuario = ?, idNivel = ? 
                WHERE idUsuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->dui, $this->correo, $this->user, $this->tipo, $this->nivel, $_SESSION['idUsuario']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idUsuario, nombres, apellidos, DUI, correo, username, tipoUsuario, nivel
                FROM Usuario 
                INNER JOIN TipoUsuario USING(idTipoUsuario)
                INNER JOIN Nivel USING(idNivel)
                WHERE apellidos ILIKE ? OR nombres ILIKE ?
                ORDER BY apellidos';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        // Se transforma la contraseña a una cadena de texto de longitud fija mediante el algoritmo por defecto.
        $hash = password_hash($this->passwrd, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO Usuario(nombres, apellidos, DUI, correo, username, passwrd, idTipoUsuario, idNivel)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->apellidos, $this->dui, $this->correo, $this->user, $hash, $this->tipo, $this->nivel);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idUsuario, nombres, apellidos, DUI, correo, username, tipoUsuario, nivel
                FROM Usuario 
                INNER JOIN TipoUsuario USING(idTipoUsuario)
                INNER JOIN Nivel USING(idNivel)
                ORDER BY apellidos';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idUsuario, nombres, apellidos, DUI, correo, username, idTipoUsuario, idNivel
                FROM Usuario 
                WHERE idusuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE Usuario 
                SET nombres = ?, apellidos = ?, DUI = ?, correo = ?
                WHERE idUsuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->dui, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM Usuario
                WHERE idUsuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
