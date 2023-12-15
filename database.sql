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
	
--creacion de tablas
CREATE TABLE marca(
	idmarca SERIAL NOT NULL PRIMARY KEY,
	nombremarca VARCHAR(30) NOT NULL
);

CREATE TABLE tipoequipo(
	idtipoequipo SERIAL NOT NULL PRIMARY KEY,
	tipoequipo VARCHAR(30) NOT NULL
);

CREATE TABLE condicion(
	idcondicion SERIAL NOT NULL PRIMARY KEY,
	condicion VARCHAR(30) NOT NULL
);

CREATE TABLE adquisicionequipo(
	idadquisicion SERIAL NOT NULL PRIMARY KEY,
	adquisicion VARCHAR(30) NOT NULL
);


CREATE TABLE nivel(
	idnivel SERIAL NOT NULL PRIMARY KEY,
	nivel VARCHAR(30) NOT NULL
);

CREATE TABLE tipousuario(
	idtipousuario SERIAL NOT NULL PRIMARY KEY,
	tipousuario VARCHAR(30) NOT NULL
);

CREATE TABLE prestamo(
	idprestamo SERIAL NOT NULL PRIMARY KEY,
	fechaprestamo DATE NOT NULL
);

CREATE TABLE usuario(
	idusuario SERIAL NOT NULL PRIMARY KEY,
	nombres VARCHAR(20) NOT NULL,
	apellidos VARCHAR(20) NOT NULL,
	correo VARCHAR(50) NOT NULL,
	username VARCHAR(10) NOT NULL,
	passwrd VARCHAR(100) NOT NULL,
	idtipousuario SERIAL NOT NULL,
	CONSTRAINT fk_tipousuario FOREIGN KEY (idtipousuario) REFERENCES tipousuario(idtipousuario),
	idnivel SERIAL NOT NULL,
	CONSTRAINT fk_nivelusuario FOREIGN KEY (idnivel) REFERENCES nivel(idnivel)
);

CREATE TABLE equipo(
	idequipo SERIAL NOT NULL PRIMARY KEY,
	modelo VARCHAR(30) NOT NULL,
	serie VARCHAR(10),
	activo VARCHAR(6),
	idtipoequipo SERIAL NOT NULL,
	CONSTRAINT fk_tipoequipo FOREIGN KEY (idtipoequipo) REFERENCES tipoequipo(idtipoequipo),
	idadquisicion SERIAL NOT NULL,
	CONSTRAINT fk_adquisicion FOREIGN KEY (idaquisicion) REFERENCES adquisicionEquipo(idadquisicion),
	idcondicion SERIAL NOT NULL,
	CONSTRAINT fk_condicion FOREIGN KEY (idcondicion) REFERENCES condicion(idcondicion),
	idusuario SERIAL,
	CONSTRAINT fk_encargado FOREIGN KEY (idusuario) REFERENCES usuario(idusuario),
	idnivel SERIAL,
	CONSTRAINT fk_nivelequipo FOREIGN KEY (idnivel) REFERENCES nivel(idnivel),
	idmarca INT NOT NULL,
	CONSTRAINT fk_marca FOREIGN KEY (idmarca) REFERENCES marca(idmarca)
 );
 
 CREATE TABLE estadoprestamo(
	 idestadoprestamo SERIAL NOT NULL PRIMARY KEY,
	 estadoprestamo VARCHAR(10) NOT NULL
 );

CREATE TABLE detalleprestamo(
	idprestamo SERIAL NOT NULL,
	CONSTRAINT fk_prestamo FOREIGN KEY (idprestamo) REFERENCES prestamo(idprestamo),
	idprestador SERIAL NOT NULL,
	CONSTRAINT fk_prestador FOREIGN KEY (idprestador) REFERENCES usuario(idusuario),
	idreceptor SERIAL NOT NULL,
	CONSTRAINT fk_receptor FOREIGN KEY (idreceptor) REFERENCES usuario(idusuario),	
	idequipo SERIAL NOT NULL,
	CONSTRAINT fk_equipoprestado FOREIGN KEY (idequipo) REFERENCES Equipo(idequipo),
	idestadoprestamo SERIAL NOT NULL,
	CONSTRAINT fk_estadoprestamo FOREIGN KEY (idestadoprestamo) REFERENCES estadoprestamo(idestadoprestamo)
);

--llenado de tablas
INSERT INTO marca(nombremarca) VALUES ('Dell'),('HP'),('Lenovo'),('XTech'),('Epson'),('Apple'),('Xiaomi'),('Samsung'),('AOC'),('Compac');

INSERT INTO condicion(condicion) VALUES ('Nuevo'),('Inservible'),('Desechado');

INSERT INTO adquisicionequipo(adquisicion) VALUES ('Comprado'),('Donado');

INSERT INTO nivel(nivel) VALUES ('Administración'),('Académica'),('Mantenimiento'),('Ingeniería'),('Clínica'),('Sistemas'),
						 ('Básica'),('Parvularia'),('Tercer Ciclo'),('Bachillerato');

INSERT INTO tipousuario(tipousuario) VALUES ('Administrador'),('Normal');

INSERT INTO tipoequipo(tipoequipo) VALUES ('laptop'),('Monitor'),('Impresor');

INSERT INTO usuario(nombres,apellidos,correo,username,passwrd,idtipousuario,idnivel) 
VALUES('Administrador','Administrador','administrador@gmail.com','admon','S0p0rteIT2024',1,6),
	  ('Samuel Eduardo','Magaña Martínez','samuelmartinez5516@gmail.com','samuelmtz5','210503',1,6);

INSERT INTO estadoprestamo(estadoprestamo) VALUES ('Pendiente'),('Completado');

INSERT INTO equipo(modelo,serie,activo,idtipoequipo,idaquisicion,idcondicion,idencargado,idnivel,idmarca)
VALUES('Probook','5CD043GV72','009269',1,1,1,5,6,2)

--Consultas para llenado de tablas
SELECT idUsuario, nombres, apellidos,  correo, username, nivel
FROM usuario
INNER JOIN nivel USING(idnivel)
				
SELECT idequipo, modelo, serie, activo, tipoequipo, adquisicion, condicion, nombres, nombremarca, nivel
FROM equipo 
INNER JOIN tipoequipo USING(idtipoequipo)
INNER JOIN adquisicionequipo USING(idadquisicion)
INNER JOIN condicion USING(idcondicion)
INNER JOIN usuario USING(idusuario)
INNER JOIN marca USING(idmarca)
INNER JOIN nivel USING(idnivel)

SELECT e.idequipo, e.modelo, e.serie, e.activo, te.tipoequipo, ae.adquisicion, c.condicion, u.nombres, m.nombremarca, n.nivel
FROM equipo e
INNER JOIN tipoequipo te ON e.idtipoequipo = te.idtipoequipo
INNER JOIN adquisicionequipo ae ON e.idadquisicion = ae.idadquisicion
INNER JOIN condicion c ON e.idcondicion = c.idcondicion
INNER JOIN usuario u ON e.idusuario = u.idusuario
INNER JOIN marca m ON e.idmarca = m.idmarca
INNER JOIN nivel n ON e.idnivel = n.idnivel;

--unique a los campos que lo requieren
ALTER TABLE equipo
ADD UNIQUE (activo)

ALTER TABLE equipo
ADD UNIQUE (serie)

ALTER TABLE usuario
ADD UNIQUE (username)
