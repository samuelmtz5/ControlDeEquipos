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
                FROM tipoequipo
                WHERE tipoequipo LIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tipoequipo(tipoequipo)
                VALUES(?)';
        $params = array($this->tipoe);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idtipoequipo, tipoequipo
                FROM tipoequipo
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
        $sql = 'UPDATE tipoequipo
                SET tipoequipo = ?
                WHERE idtipoequipo = ?';
        $params = array($this->tipoe, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tipoequipo
                WHERE idtipoequipo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readEquiposTipo()
    {
        $sql = 'SELECT t.tipoequipo, m.nombremarca, e.modelo, e.activo
        FROM equipo e
        INNER JOIN tipoequipo t on e.idtipoequipo = t.idtipoequipo
        INNER JOIN marca m ON e.idmarca = m.idmarca
        WHERE e.idtipoequipo = ?
        ORDER BY activo';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

}

