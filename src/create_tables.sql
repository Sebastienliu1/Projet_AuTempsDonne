CREATE TABLE users(
   id_utilisateur INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   surname VARCHAR(50) NOT NULL,
   name VARCHAR(50) NOT NULL,
   email VARCHAR(50),
   password VARCHAR(50) NOT NULL,
   type VARCHAR(50) NOT NULL
   );

CREATE TABLE Benevoles(
   id_benevole INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   statut VARCHAR(50) NOT NULL,
   formation_complete VARCHAR(50),
   Id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_benevole),
   FOREIGN KEY(Id_utilisateur) REFERENCES users(Id_utilisateur)
);

CREATE TABLE Activite(
   id_activite INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   date_heure_fin DATETIME,
   nom VARCHAR(50),
   description VARCHAR(100),
   date_heure_debut DATETIME,
   PRIMARY KEY(id_activite)
);

CREATE TABLE Lieu(
   id_lieu INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   nom VARCHAR(50),
   lat FLOAT,
   lon FLOAT
); -- nouvelle table pour stocker les lieux

CREATE TABLE Commercants(
   id_commercant INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   nom VARCHAR(50),
   addresse VARCHAR(50),
   id_lieu INT NOT NULL,
   FOREIGN KEY(id_lieu) REFERENCES Lieu(id_lieu),
   contact VARCHAR(50),
   PRIMARY KEY(id_commercant)
); -- ajout des lieux

CREATE TABLE Circuit(
   id_circuit INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   lieu_1 INT NOT NULL,
   lieu_2 INT NOT NULL,
   lieu_3 INT NOT NULL,
   lieu_4 INT NOT NULL,
   lieu_5 INT NOT NULL,
   FOREIGN KEY(lieu_1) REFERENCES Lieu(id_lieu),
   FOREIGN KEY(lieu_2) REFERENCES Lieu(id_lieu),
   FOREIGN KEY(lieu_3) REFERENCES Lieu(id_lieu),
   FOREIGN KEY(lieu_4) REFERENCES Lieu(id_lieu),
   FOREIGN KEY(lieu_5) REFERENCES Lieu(id_lieu)
)

CREATE TABLE Circuit_de_ramassage(
   id_circuit_ramassage INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   date_circuit DATE,
   id_benevole INT NOT NULL,
   id_circuit INT NOT NULL,
   PRIMARY KEY(id_circuit),
   FOREIGN KEY(id_benevole) REFERENCES Benevoles(id_benevole),
   FOREIGN KEY(id_circuit) REFERENCES Circuit(id_circuit)
); -- plan_route supprimé et remplacé par id_circuit

CREATE TABLE Maraudes(
   id_maraude INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   date_maraude DATE,
   PRIMARY KEY(id_circuit),
   id_benevole INT NOT NULL,
   PRIMARY KEY(id_maraude),
   FOREIGN KEY(id_benevole) REFERENCES Benevoles(id_benevole)
   FOREIGN KEY(id_circuit) REFERENCES Circuit(id_circuit)
); -- idem

CREATE TABLE Stocks(
   id_stock INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   quantité INT,
   denree VARCHAR(50) NOT NULL,
   date_expiration DATE,
   adresse VARCHAR(50),
   PRIMARY KEY(id_stock)
);

CREATE TABLE Competence(
   id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   nom VARCHAR(50),
   niveau VARCHAR(50),
   description VARCHAR(50),
   id_benevole INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_benevole) REFERENCES Benevoles(id_benevole)
);

CREATE TABLE Denrees(
   id_denree INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   quantité INT,
   nom VARCHAR(50) NOT NULL,
   date_expiration DATE,
   id_commercant INT NOT NULL,
   PRIMARY KEY(id_denree),
   FOREIGN KEY(id_commercant) REFERENCES Commercants(id_commercant)
);

CREATE TABLE assigne(
   id_commercant INT,
   id_circuit INT,
   PRIMARY KEY(id_commercant, id_circuit),
   FOREIGN KEY(id_commercant) REFERENCES Commercants(id_commercant),
   FOREIGN KEY(id_circuit) REFERENCES Circuit_de_ramassage(id_circuit_ramassage)
);

CREATE TABLE apporte(
   id_circuit INT,
   id_stock INT,
   PRIMARY KEY(id_circuit, id_stock),
   FOREIGN KEY(id_circuit) REFERENCES Circuit_de_ramassage(id_circuit_ramassage),
   FOREIGN KEY(id_stock) REFERENCES Stocks(id_stock)
);

CREATE TABLE distribue(
   Id_utilisateur INT,
   id_maraude INT,
   PRIMARY KEY(Id_utilisateur, id_maraude),
   FOREIGN KEY(Id_utilisateur) REFERENCES Utilisateurs(Id_utilisateur),
   FOREIGN KEY(id_maraude) REFERENCES Maraudes(id_maraude)
);

CREATE TABLE exporte(
   id_maraude INT,
   id_stock INT,
   PRIMARY KEY(id_maraude, id_stock),
   FOREIGN KEY(id_maraude) REFERENCES Maraudes(id_maraude),
   FOREIGN KEY(id_stock) REFERENCES Stocks(id_stock)
);

CREATE TABLE accede(
   Id_utilisateur INT,
   id_activite INT,
   PRIMARY KEY(Id_utilisateur, id_activite),
   FOREIGN KEY(Id_utilisateur) REFERENCES Utilisateurs(Id_utilisateur),
   FOREIGN KEY(id_activite) REFERENCES Activite(id_activite)
);

CREATE TABLE organise(
   id_benevole INT,
   id_activite INT,
   PRIMARY KEY(id_benevole, id_activite),
   FOREIGN KEY(id_benevole) REFERENCES Benevoles(id_benevole),
   FOREIGN KEY(id_activite) REFERENCES Activite(id_activite)
);

CREATE TABLE contien(
   id_denree INT,
   id_stock INT,
   PRIMARY KEY(id_denree, id_stock),
   FOREIGN KEY(id_denree) REFERENCES Denrees(id_denree),
   FOREIGN KEY(id_stock) REFERENCES Stocks(id_stock)
);

GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO 'root'@'localhost';