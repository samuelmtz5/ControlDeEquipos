<?php

class Adquisicion extends Validator {
    private $id = null;
    private $adquisicion = null;

    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAdquisicion($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->adquisicion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAdquisicion()
    {
        return $this->adquisicion;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT idadquisicion, idadquisicion
                FROM AdquisiconEquipo
                WHERE adquisicion LIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO AdquisicionEquipo(adquisicion)
                VALUES(?)';
        $params = array($this->adquisicion);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idadquisicion, adquisicion
                FROM AdquisicionEquipo
                ORDER BY adquisicion';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idadquisicion, adquisicion
                FROM AdquisicionEquipo
                WHERE idadquisicion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE AdquisicionEquipo
                SET adquisicion = ?
                WHERE idadquisicion = ?';
        $params = array($this->adquisicion, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM AdquisicionEquipo
                WHERE idadquisicion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}