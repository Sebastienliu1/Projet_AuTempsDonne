CREATE TABLE users(
   Id_utilisateur INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   surname VARCHAR(50) NOT NULL,
   name VARCHAR(50) NOT NULL,
   email VARCHAR(50),
   password VARCHAR(50) NOT NULL,
   type VARCHAR(50) NOT NULL,
   sel VARCHAR(50) NOT NULL
);

CREATE TABLE Benevoles(
   id_benevole INT,
   statut VARCHAR(50) NOT NULL,
   formation_complete VARCHAR(50),
   Id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_benevole),
   FOREIGN KEY(Id_utilisateur) REFERENCES users(Id_utilisateur)
);

CREATE TABLE Activite(
   id_activite INT,
   date_heure_fin DATETIME,
   nom VARCHAR(50),
   description VARCHAR(100),
   date_heure_debut DATETIME,
   PRIMARY KEY(id_activite)
);

CREATE TABLE Commercants(
   id_commercant INT,
   nom VARCHAR(50),
   addresse VARCHAR(50),
   contact VARCHAR(50),
   PRIMARY KEY(id_commercant)
);

CREATE TABLE Circuit_de_ramassage(
   id_circuit INT,
   date_circuit DATE,
   plan_route VARCHAR(50),
   id_benevole INT NOT NULL,
   PRIMARY KEY(id_circuit),
   FOREIGN KEY(id_benevole) REFERENCES Benevoles(id_benevole)
);

CREATE TABLE Maraudes(
   id_maraude INT,
   date_maraude DATE,
   plan_route VARCHAR(50),
   id_benevole INT NOT NULL,
   PRIMARY KEY(id_maraude),
   FOREIGN KEY(id_benevole) REFERENCES Benevoles(id_benevole)
);

CREATE TABLE Stocks(
   id_stock INT,
   quantité INT,
   denree VARCHAR(50) NOT NULL,
   date_expiration DATE,
   adresse VARCHAR(50),
   PRIMARY KEY(id_stock)
);

CREATE TABLE Competence(
   id INT,
   nom VARCHAR(50),
   niveau VARCHAR(50),
   description VARCHAR(50),
   id_benevole INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_benevole) REFERENCES Benevoles(id_benevole)
);

CREATE TABLE Denrees(
   id_denree INT,
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
   FOREIGN KEY(id_circuit) REFERENCES Circuit_de_ramassage(id_circuit)
);

CREATE TABLE apporte(
   id_circuit INT,
   id_stock INT,
   PRIMARY KEY(id_circuit, id_stock),
   FOREIGN KEY(id_circuit) REFERENCES Circuit_de_ramassage(id_circuit),
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