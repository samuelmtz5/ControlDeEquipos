<?php

class Marca extends Validator {
    private $id = null;
    private $marca = null;

    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMarca($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->marca = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT idmarca, nombremarca
                FROM Marca
                WHERE nombremarca LIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO Marca(nombremarca)
                VALUES(?)';
        $params = array($this->marca);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idmarca, nombremarca
                FROM Marca
                ORDER BY nombremarca';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idmarca, nombremarca
                FROM Marca
                WHERE idmarca = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE Marca
                SET nombremarca = ?
                WHERE idmarca = ?';
        $params = array($this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM Marca
                WHERE idmarca = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}