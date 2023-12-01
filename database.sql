-- Database: ControlDeEquipos

-- DROP DATABASE IF EXISTS "ControlDeEquipos";

CREATE DATABASE "ControlDeEquipos"
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Spanish_Spain.1252'
    LC_CTYPE = 'Spanish_Spain.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;
	
CREATE TABLE Marca(
	idMarca INT NOT NULL PRIMARY KEY,
	nombreMarca VARCHAR(30) NOT NULL
)

CREATE TABLE Condicion(
	idCondicion INT NOT NULL PRIMARY KEY,
	condicion VARCHAR(30) NOT NULL
)

CREATE TABLE AquisicionEquipo(
	idAquisicion INT NOT NULL PRIMARY KEY,
	adquisicion VARCHAR(30) NOT NULL
)

CREATE TABLE TipoEquipo(
	idTipoEquipo INT NOT NULL PRIMARY KEY,
	tipoEquipo VARCHAR(30) NOT NULL
)

CREATE TABLE Nivel(
	idNivel INT NOT NULL PRIMARY KEY,
	nivel VARCHAR(30) NOT NULL
)

CREATE TABLE TipoUsuario(
	idTipoUsuario INT NOT NULL PRIMARY KEY,
	tipoUsuario VARCHAR(30) NOT NULL
)

CREATE TABLE Factura(
	idFactura INT NOT NULL PRIMARY KEY,
	fechaFactura date NOT NULL
)
