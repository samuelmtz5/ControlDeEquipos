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

CREATE TABLE TipoEquipo(
	idTipoEquipo INT NOT NULL PRIMARY KEY,
	tipoEquipo VARCHAR(30) NOT NULL
)

CREATE TABLE Condicion(
	idCondicion INT NOT NULL PRIMARY KEY,
	condicion VARCHAR(30) NOT NULL
)

CREATE TABLE AdquisicionEquipo(
	idAdquisicion INT NOT NULL PRIMARY KEY,
	adquisicion VARCHAR(30) NOT NULL
)


CREATE TABLE Nivel(
	idNivel INT NOT NULL PRIMARY KEY,
	nivel VARCHAR(30) NOT NULL
)

CREATE TABLE TipoUsuario(
	idTipoUsuario INT NOT NULL PRIMARY KEY,
	tipoUsuario VARCHAR(30) NOT NULL
)

CREATE TABLE Prestamo(
	idPrestamo INT NOT NULL PRIMARY KEY,
	fechaPrestamo DATE NOT NULL
)

CREATE TABLE Usuario(
	idUsuario INT NOT NULL PRIMARY KEY,
	nombres VARCHAR(20) NOT NULL,
	apellidos VARCHAR(20) NOT NULL,
	DUI VARCHAR(10) NOT NULL,
	correo VARCHAR(50) NOT NULL,
	username VARCHAR(10) NOT NULL,
	passwrd VARCHAR(100) NOT NULL,
	idTipoUsuario INT NOT NULL,
	CONSTRAINT fk_tipousuario FOREIGN KEY (idTipoUsuario) REFERENCES TipoUsuario(idTipoUsuario)
)

ALTER TABLE Usuario
ADD COLUMN idNivel INT,
ADD CONSTRAINT fk_nivelusuario FOREIGN KEY (idNivel) REFERENCES Nivel(idNivel)

CREATE TABLE Equipo(
	idEquipo INT NOT NULL PRIMARY KEY,
	modelo VARCHAR(30) NOT NULL,
	serie VARCHAR(10),
	activo VARCHAR(6),
	idTipoEquipo INT NOT NULL,
	CONSTRAINT fk_tipoequipo FOREIGN KEY (idTipoEquipo) REFERENCES TipoEquipo(idTipoEquipo),
	idAquisicion INT NOT NULL,
	CONSTRAINT fk_adquisicion FOREIGN KEY (idAquisicion) REFERENCES AdquisicionEquipo(idAdquisicion),
	idCondicion INT NOT NULL,
	CONSTRAINT fk_condicion FOREIGN KEY (idCondicion) REFERENCES Condicion(idCondicion),
	idEncargado INT,
	CONSTRAINT fk_encargado FOREIGN KEY (idEncargado) REFERENCES Usuario(idUsuario),
	idNivel INT,
	CONSTRAINT fk_nivelequipo FOREIGN KEY (idNivel) REFERENCES Nivel(idNivel)
 )
 
 CREATE TABLE EstadoPrestamo(
	 idEstadoPrestamo INT NOT NULL PRIMARY KEY,
	 estadoPrestamo VARCHAR(10) NOT NULL
 )

CREATE TABLE DetallePrestamo(
	idPrestamo INT NOT NULL,
	CONSTRAINT fk_prestamo FOREIGN KEY (idPrestamo) REFERENCES Prestamo(idPrestamo),
	idPrestador INT NOT NULL,
	CONSTRAINT fk_prestador FOREIGN KEY (idPrestador) REFERENCES Usuario(idUsuario),
	idReceptor INT NOT NULL,
	CONSTRAINT fk_receptor FOREIGN KEY (idReceptor) REFERENCES Usuario(idUsuario),	
	idEquipo INT NOT NULL,
	CONSTRAINT fk_equipoprestado FOREIGN KEY (idEquipo) REFERENCES Equipo(idEquipo),
	idEstadoPrestamo INT NOT NULL,
	CONSTRAINT fk_estadoprestamo FOREIGN KEY (idEstadoPrestamo) REFERENCES EstadoPrestamo(idEstadoPrestamo)
)

INSERT INTO MARCA VALUES (1,'Dell'),(2,'HP'),(3,'Lenovo'),(4,'XTech'),(5,'Epson'),(6,'Apple'),(7,'Xiaomi'),(8,'Samsung'),(9,'AOC'),(10,'Compac')

INSERT INTO Condicion VALUES (1,'Nuevo'),(2,'Inservible'),(3,'Desechado')

INSERT INTO AdquisicionEquipo VALUES (1,'Comprado'),(2,'Donado')

INSERT INTO Nivel VALUES (1,'Administración'),(2,'Académica'),(3,'Mantenimiento'),(4,'Ingeniería'),(5,'Clínica'),(6,'Sistemas'),
						 (7,'Básica'),(8,'Parvularia'),(9,'Tercer Ciclo'),(10,'Bachillerato')

INSERT INTO TipoUsuario VALUES (1,'Administrador'),(2,'Normal')

INSERT INTO Usuario VALUES(1,'Administrador','Administrador','00000000-1','administrador@gmail.com','admon','S0p0rteIT2024',1,6)
INSERT INTO Usuario VALUES(2,'Samuel Eduardo','Magaña Martínez','06508618-4','samuelmartinez5516@gmail.com','samuelmtz5','210503',1,6)
