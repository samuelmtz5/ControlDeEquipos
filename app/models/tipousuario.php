<?php

class TipoUsuario extends Validator {
    private $id = null;
    private $tipou = null;

    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoU($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->tipou = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipoU()
    {
        return $this->tipou;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT idtipousuario, tipousuario
                FROM tipousuario
                WHERE tipousuario LIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tipousuario(tipousuario)
                VALUES(?)';
        $params = array($this->tipou);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idtipousuario, tipousuario
                FROM tipousuario
                ORDER BY tipousuario';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idtipousuario, tipousuario
                FROM tipousuario
                WHERE idtipousuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tipousuario
                SET tipousuario = ?
                WHERE idtipousuario = ?';
        $params = array($this->tipou, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tipousuario
                WHERE idtipousuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}

