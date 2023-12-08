-- Database: ControlEquipos

-- DROP DATABASE IF EXISTS "ControlEquipos";

CREATE DATABASE "ControlEquipos"
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Spanish_Spain.1252'
    LC_CTYPE = 'Spanish_Spain.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;
	
	
CREATE TABLE Marca(
	idMarca SERIAL NOT NULL PRIMARY KEY,
	nombreMarca VARCHAR(30) NOT NULL
);

CREATE TABLE TipoEquipo(
	idTipoEquipo SERIAL NOT NULL PRIMARY KEY,
	tipoEquipo VARCHAR(30) NOT NULL
);

CREATE TABLE Condicion(
	idCondicion SERIAL NOT NULL PRIMARY KEY,
	condicion VARCHAR(30) NOT NULL
);

CREATE TABLE AdquisicionEquipo(
	idAdquisicion SERIAL NOT NULL PRIMARY KEY,
	adquisicion VARCHAR(30) NOT NULL
);


CREATE TABLE Nivel(
	idNivel SERIAL NOT NULL PRIMARY KEY,
	nivel VARCHAR(30) NOT NULL
);

CREATE TABLE TipoUsuario(
	idTipoUsuario SERIAL NOT NULL PRIMARY KEY,
	tipoUsuario VARCHAR(30) NOT NULL
);

CREATE TABLE Prestamo(
	idPrestamo SERIAL NOT NULL PRIMARY KEY,
	fechaPrestamo DATE NOT NULL
);

CREATE TABLE Usuario(
	idUsuario SERIAL NOT NULL PRIMARY KEY,
	nombres VARCHAR(20) NOT NULL,
	apellidos VARCHAR(20) NOT NULL,
	DUI VARCHAR(10) NOT NULL,
	correo VARCHAR(50) NOT NULL,
	username VARCHAR(10) NOT NULL,
	passwrd VARCHAR(100) NOT NULL,
	idTipoUsuario SERIAL NOT NULL,
	CONSTRAINT fk_tipousuario FOREIGN KEY (idTipoUsuario) REFERENCES TipoUsuario(idTipoUsuario),
	idNivel SERIAL NOT NULL,
	CONSTRAINT fk_nivelusuario FOREIGN KEY (idNivel) REFERENCES Nivel(idNivel)
);

CREATE TABLE Equipo(
	idEquipo SERIAL NOT NULL PRIMARY KEY,
	modelo VARCHAR(30) NOT NULL,
	serie VARCHAR(10),
	activo VARCHAR(6),
	idTipoEquipo SERIAL NOT NULL,
	CONSTRAINT fk_tipoequipo FOREIGN KEY (idTipoEquipo) REFERENCES TipoEquipo(idTipoEquipo),
	idAquisicion SERIAL NOT NULL,
	CONSTRAINT fk_adquisicion FOREIGN KEY (idAquisicion) REFERENCES AdquisicionEquipo(idAdquisicion),
	idCondicion SERIAL NOT NULL,
	CONSTRAINT fk_condicion FOREIGN KEY (idCondicion) REFERENCES Condicion(idCondicion),
	idEncargado SERIAL,
	CONSTRAINT fk_encargado FOREIGN KEY (idEncargado) REFERENCES Usuario(idUsuario),
	idNivel SERIAL,
	CONSTRAINT fk_nivelequipo FOREIGN KEY (idNivel) REFERENCES Nivel(idNivel)
 );
 
 CREATE TABLE EstadoPrestamo(
	 idEstadoPrestamo SERIAL NOT NULL PRIMARY KEY,
	 estadoPrestamo VARCHAR(10) NOT NULL
 );

CREATE TABLE DetallePrestamo(
	idPrestamo SERIAL NOT NULL,
	CONSTRAINT fk_prestamo FOREIGN KEY (idPrestamo) REFERENCES Prestamo(idPrestamo),
	idPrestador SERIAL NOT NULL,
	CONSTRAINT fk_prestador FOREIGN KEY (idPrestador) REFERENCES Usuario(idUsuario),
	idReceptor SERIAL NOT NULL,
	CONSTRAINT fk_receptor FOREIGN KEY (idReceptor) REFERENCES Usuario(idUsuario),	
	idEquipo SERIAL NOT NULL,
	CONSTRAINT fk_equipoprestado FOREIGN KEY (idEquipo) REFERENCES Equipo(idEquipo),
	idEstadoPrestamo SERIAL NOT NULL,
	CONSTRAINT fk_estadoprestamo FOREIGN KEY (idEstadoPrestamo) REFERENCES EstadoPrestamo(idEstadoPrestamo)
);

ALTER TABLE Equipo
ADD COLUMN idMarca INT NOT NULL,
ADD CONSTRAINT fk_marca
FOREIGN KEY (idMarca)
REFERENCES Marca (idMarca);

INSERT INTO Marca(nombreMarca) VALUES ('Dell'),('HP'),('Lenovo'),('XTech'),('Epson'),('Apple'),('Xiaomi'),('Samsung'),('AOC'),('Compac');

INSERT INTO Condicion(condicion) VALUES ('Nuevo'),('Inservible'),('Desechado');

INSERT INTO AdquisicionEquipo(adquisicion) VALUES ('Comprado'),('Donado');

INSERT INTO Nivel(nivel) VALUES ('Administración'),('Académica'),('Mantenimiento'),('Ingeniería'),('Clínica'),('Sistemas'),
						 ('Básica'),('Parvularia'),('Tercer Ciclo'),('Bachillerato');

INSERT INTO TipoUsuario(tipoUsuario) VALUES ('Administrador'),('Normal');

INSERT INTO TipoEquipo(tipoEquipo) VALUES ('laptop'),('Monitor'),('Impresor');

INSERT INTO Usuario(nombres,apellidos,DUI,correo,username,passwrd,idTipoUsuario,idNivel) 
VALUES('Administrador','Administrador','00000000-1','administrador@gmail.com','admon','S0p0rteIT2024',1,6),
	  ('Samuel Eduardo','Magaña Martínez','06508618-4','samuelmartinez5516@gmail.com','samuelmtz5','210503',1,6);

INSERT INTO EstadoPrestamo(estadoPrestamo) VALUES ('Pendiente'),('Completado');

ALTER TABLE usuario DROP COLUMN dui
