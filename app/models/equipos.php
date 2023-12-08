<?php

class Equipos extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $modelo = null;
    private $serie = null;
    private $activo = null;
    private $tipoequipo = null;
    private $adquisicion = null;
    private $condicion = null;
    private $encargado = null;
    private $nivel = null;
    private $marca = null;

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

    public function setModelo($value)
    {
        if ($this->validateAlphanumeric($value, 1, 30)) {
            $this->modelo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSerie($value)
    {
        if ($this->validateAlphanumeric($value, 1, 10)) {
            $this->serie = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setActivo($value)
    {
        if ($this->validateAlphanumeric($value, 1, 6)) {
            $this->activo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoEquipo($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->tipoequipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAdquisicion($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->adquisicion = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCondicion($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->condicion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEncargado($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->encargado = $value;
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

    public function setMarca($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->marca = $value;
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

    public function getModelo()
    {
        return $this->modelo;
    }

    public function getSerie()
    {
        return $this->serie;
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function getTipoEquipo()
    {
        return $this->tipoequipo;
    }

    public function getAdquisicion()
    {
        return $this->adquisicion;
    }

    public function getCondicion()
    {
        return $this->condicion;
    }

    public function getEncargado()
    {
        return $this->encargado;
    }
    public function getNivel()
    {
        return $this->nivel;
    }
    public function getMarca()
    {
        return $this->marca;
    }


    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT e.idequipo, e.modelo, e.serie, e.activo, te.tipoequipo, ae.adquisicion, c.condicion, u.nombres, m.nombremarca, n.nivel
                FROM equipo e
                INNER JOIN TipoEquipo te ON e.idTipoEquipo = te.idTipoEquipo
                INNER JOIN AdquisicionEquipo ae ON e.idAdquisicion = ae.idAdquisicion
                INNER JOIN Condicion c ON e.idCondicion = c.idCondicion
                INNER JOIN Usuario u ON e.idusuario = u.idusuario
                INNER JOIN Marca m ON e.idmarca = m.idmarca
                INNER JOIN Nivel n ON e.idnivel = n.idnivel';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, id_categoria, id_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->imagen, $this->estado, $this->categoria, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto, nombre_categoria, estado_producto
                FROM productos INNER JOIN categorias USING(id_categoria)
                ORDER BY nombre_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, id_categoria, estado_producto
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? $this->deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE productos
                SET imagen_producto = ?, nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, estado_producto = ?, id_categoria = ?
                WHERE id_producto = ?';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->precio, $this->estado, $this->categoria, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para generar gráficas.
    */
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, COUNT(id_producto) cantidad
                FROM productos INNER JOIN categorias USING(id_categoria)
                GROUP BY nombre_categoria ORDER BY cantidad DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }
}
