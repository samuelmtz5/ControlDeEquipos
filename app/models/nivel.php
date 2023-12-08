<?php

class Nivel extends Validator {
    private $id = null;
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

    public function setNivel($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
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

    public function getNivel()
    {
        return $this->nivel;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT idnivel, nivel
                FROM Nivel
                WHERE nivel LIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO Nivel(nivel)
                VALUES(?)';
        $params = array($this->nivel);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idnivel, nivel
                FROM Nivel
                ORDER BY nivel';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idnivel, nivel
                FROM Nivel
                WHERE idnivel = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE Nivel
                SET nivel = ?
                WHERE idnivel = ?';
        $params = array($this->nivel, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM Nivel
                WHERE idnivel = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}

