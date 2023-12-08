<?php

class Tipos extends Validator {
    private $id = null;
    private $tipoe = null;

    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoE($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->tipoe = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipoE()
    {
        return $this->tipoe;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT idtipoequipo, tipoequipo
                FROM TipoEquipo
                WHERE tipoequipo LIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO TipoEquipo(tipoequipo)
                VALUES(?)';
        $params = array($this->tipoe);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idtipoequipo, tipoequipo
                FROM TipoEquipo
                ORDER BY tipoequipo';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idtipoequipo, tipoequipo
                FROM tipoequipo
                WHERE idtipoequipo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE TipoEquipo
                SET tipoequipo = ?
                WHERE idtipoequipo = ?';
        $params = array($this->tipoe, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM TipoEquipo
                WHERE idtipoequipo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readEquiposTipo()
    {
        $sql = 'SELECT tipoequipo, idequipo, marca, modelo, activo
                FROM Equipo 
                INNER JOIN TipoEquipo USING(idtipoequipo)
                INNER JOIN Marca USING(idmarca)
                WHERE idtipoequipo = ?
                ORDER BY activo';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

}

