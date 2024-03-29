<?php

class Adquisicion extends Validator {
    private $id = null;
    private $adquisicion = null;

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

    public function setAdquisicion($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->adquisicion = $value;
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

    public function getAdquisicion()
    {
        return $this->adquisicion;
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

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

    public function readEquiposAdq()
    {
        $sql = 'SELECT ad.adquisicion, m.nombremarca, e.modelo, e.activo
        FROM Equipo e
        INNER JOIN adquisicionequipo ad on e.idadquisicion = ad.idadquisicion
        INNER JOIN Marca m ON e.idmarca = m.idmarca
        WHERE ad.idadquisicion = ?
        ORDER BY activo';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}