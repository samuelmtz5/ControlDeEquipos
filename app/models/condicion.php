<?php

class Condicion extends Validator {
    private $id = null;
    private $condicion = null;

    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCondicion($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->condicion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCondicion()
    {
        return $this->condicion;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT idcondicion, idcondicion
                FROM Condicion
                WHERE condicion LIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO Condicion(condicion)
                VALUES(?)';
        $params = array($this->condicion);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idcondicion, condicion
                FROM Condicion
                ORDER BY condicion';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idcondicion, condicion
                FROM Condicion
                WHERE idcondicion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE Condicion
                SET condicion = ?
                WHERE idcondicion = ?';
        $params = array($this->condicion, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM Condicion
                WHERE idcondicion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readEquiposCondicion()
    {
        $sql = 'SELECT c.condicion, m.nombremarca, e.modelo, e.activo
        FROM Equipo e
        INNER JOIN condicion c on e.idcondicion = c.idcondicion
        INNER JOIN Marca m ON e.idmarca = m.idmarca
        WHERE c.idcondicion = ?
        ORDER BY activo';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}