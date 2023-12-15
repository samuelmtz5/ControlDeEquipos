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
    private $correo = null;
    private $user = null;
    private $passwrd = null;
    private $tipo = null;
    private $nivel = null;

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

    public function checkUser($user)
    {
        $sql = 'SELECT idusuario FROM usuario WHERE username = ?';
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
        if ($passwrd === $data['passwrd']) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuario SET passwrd = ? WHERE idusuario = ?';
        $params = array($this->passwrd, $_SESSION['idusuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT idusuario, nombres, apellidos, correo, username
                FROM usuario
                WHERE idusuario = ?';
        $params = array($_SESSION['idusuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuario
                SET nombres = ?, apellidos = ?, correo = ?, username = ?
                WHERE idusuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->user, $_SESSION['idusuario']);
        return Database::executeRow($sql, $params);
    }

    public function searchRows($value)
    {
        $sql = 'SELECT idusuario, nombres, apellidos, correo, username, tipousuario, nivel
                FROM usuario 
                INNER JOIN tipousuario USING(idtipousuario)
                INNER JOIN nivel USING(idnivel)
                WHERE apellidos ILIKE ? OR nombres ILIKE ?
                ORDER BY apellidos';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO Usuario(nombres, apellidos, correo, username, passwrd, idtipousuario, idnivel)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->user, $this->passwrd, $this->tipo, $this->nivel);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idusuario, nombres, apellidos, correo, username, tipousuario, nivel
                FROM usuario 
                INNER JOIN tipousuario USING(idtipousuario)
                INNER JOIN nivel USING(idnivel)
                ORDER BY apellidos';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idusuario, nombres, apellidos, correo, username, idtipousuario, idnivel
                FROM usuario 
                WHERE idusuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuario 
                SET nombres = ?, apellidos = ?, correo = ?, username = ?, idtipousuario = ?, idnivel = ?    
                WHERE idusuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->user, $this->tipo, $this->nivel, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuario
                WHERE idusuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
