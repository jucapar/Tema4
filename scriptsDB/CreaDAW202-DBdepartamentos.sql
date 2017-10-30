DROP DATABASE IF EXISTS DAW202DBdepartamentos ;
CREATE DATABASE DAW202DBdepartamentos;
USE DAW202DBdepartamentos;
CREATE TABLE Departamento(
	CodDepartamento VARCHAR(3) PRIMARY KEY,
	DescDepartamento VARCHAR(255),
	FechaBaja DATE
)ENGINE=InnoDB;

GRANT SELECT,UPDATE,INSERT,DELETE ON DAW202DBdepartamentos.* TO "usuarioDBdepartamentos"@"%" IDENTIFIED BY "paso";

