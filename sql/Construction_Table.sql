CREATE TABLE Etudiant(
    numEtu VARCHAR(255) ,
    nomprenom VARCHAR(100),
    PRIMARY KEY(numEtu)
);





CREATE TABLE Equipe_etudiant(
    idEquipe VARCHAR(255) ,
    numEquipe INTEGER,
    PRIMARY KEY(idEquipe)
);




CREATE TABLE Equipe_Compose(
    numEtu INTEGER  REFERENCES Etudiant(numEtu),
    idEquipe VARCHAR(255)  REFERENCES Equipe_etudiant(idEquipe),
    role VARCHAR(50),
    PRIMARY KEY(numEtu, idEquipe)
);

CREATE TABLE Réalisation(
    idRéalisation INTEGER  AUTO_INCREMENT,
    nom VARCHAR(50),
    url_logo VARCHAR(2048),
    note_finale INTEGER,
    commentaire VARCHAR(2048),
    PRIMARY KEY(idRéalisation)
);





CREATE TABLE Enseignant(
    idEnseignant INTEGER  AUTO_INCREMENT,
    nom VARCHAR(50),
    prénom VARCHAR(50),
    statut ENUM ('PU', 'MCF', 'ATER', 'PAST', 'VAC'),
    PRIMARY KEY(idEnseignant)
);





CREATE TABLE Projet(
    idProjet INTEGER,
    libellé VARCHAR(100),
    résumé VARCHAR(500),
    lien_sujet VARCHAR(2048),
    etat enum('Actif', 'En attente', 'Archivé'),
    année INTEGER,
    semestre VARCHAR(500),
    PRIMARY KEY(idProjet)
);

CREATE TABLE Realisation_Appartient(
    idRéalisation INTEGER  REFERENCES Réalisation(idRéalisation),
    idProjet INTEGER  REFERENCES Projet(idProjet),
    PRIMARY KEY (idRéalisation, idProjet)
);




CREATE TABLE Soutenance(
    idSoutenance INTEGER,
    titre VARCHAR(30),
    consigne VARCHAR(500),
    PRIMARY KEY(idSoutenance)
);





CREATE TABLE Soutenance_Affecter(
    idSoutenance INTEGER  REFERENCES Soutenance(idSoutenance),
    idEquipe VARCHAR(255)  REFERENCES Equipe_etudiant(idEquipe),
    jour DATE,
    heure TIME,
    salle VARCHAR(30),
    batiment VARCHAR(30),
    PRIMARY KEY (idSoutenance)
);


CREATE TABLE Jalon(
    rang INTEGER,
    date_limite DATE,
    date_actualisé DATE,
    note_sur INTEGER,
    libelle VARCHAR(50),
    PRIMARY KEY(rang,libelle,date_limite)
);





CREATE TABLE UE(
    idUE VARCHAR(255) ,
    libellé_UE VARCHAR(50),
    sigle VARCHAR(50),
    niveau VARCHAR(50),
    annee INTEGER,
    semestre VARCHAR(50),
    nb_total_projet INTEGER,
    PRIMARY KEY(idUE,annee,semestre)
);


CREATE TABLE Rendu_jalon(
    idRendu INTEGER  AUTO_INCREMENT,
    date DATE,
    note INTEGER,
    etat enum('Rendu', 'Attendu', 'Non Rendu'),
    rang INTEGER REFERENCES Jalon(rang),
    idEquipe VARCHAR(255) REFERENCES Equipe_etudiant(idEquipe),
    PRIMARY KEY(idRendu)
);



CREATE TABLE Question_Compose(
    theme VARCHAR(30),
    PRIMARY KEY(theme)
);





CREATE TABLE Question(
    idQuestion INTEGER  AUTO_INCREMENT,
    libellé_Q VARCHAR(255),
    theme VARCHAR(30) REFERENCES Question_Compose(theme),
    PRIMARY KEY(idQuestion,theme)

);





CREATE TABLE Questionnaire(
    idQuestionnaire INTEGER,
    theme VARCHAR(30),
    PRIMARY KEY(idQuestionnaire,theme)
);





CREATE TABLE Avancement(
    idAvancement INTEGER,
    PRIMARY KEY(idAvancement)
);





CREATE TABLE Element(
    idElement INTEGER,
    file MEDIUMBLOB,
    PRIMARY KEY(idElement)
);





CREATE TABLE Code(
    idCode INTEGER,
    code TEXT,
    PRIMARY KEY(idCode)
);




CREATE TABLE Rapport(
    idRapport INTEGER,
    titre VARCHAR(255),
    texte_descriptif TEXT,
    PRIMARY KEY(idRapport)
);





CREATE TABLE Concours(
    idConcours INTEGER  AUTO_INCREMENT,
    libellé VARCHAR(255),
    description VARCHAR(255),
    prix VARCHAR(255),
    PRIMARY KEY(idConcours)
);





CREATE TABLE Equipe_Depose(
    numEtu INTEGER  REFERENCES Etudiant(numEtu),
    idRendu INTEGER  REFERENCES Rendu_jalon(idRendu),
    PRIMARY KEY(numEtu, idRendu)
);




CREATE TABLE Realisation_Compose(
    idRéalisation INTEGER  REFERENCES Réalisation(idRéalisation),
    idRendu INTEGER  REFERENCES Rendu_jalon(idRendu),
    PRIMARY KEY(idRéalisation, idRendu)
);




CREATE TABLE Enseignant_Referant(
    idEnseignant INTEGER  REFERENCES Enseignant(idEnseignant),
    nom VARCHAR(255) REFERENCES Enseignant(nom),
    prenom VARCHAR(255) REFERENCES Enseignant(prénom),
    idRendu INTEGER  REFERENCES Projet(idProjet),
    idEquipe VARCHAR(255)  REFERENCES Equipe_etudiant(idEquipe),
    PRIMARY KEY(idEnseignant, idRendu, idEquipe)
);




CREATE TABLE Equipe_Realisation(
    idRéalisation INTEGER  REFERENCES Réalisation(idRéalisation),
    idEquipe VARCHAR(255)  REFERENCES Equipe_etudiant(idEquipe),
    PRIMARY KEY(idRéalisation, idEquipe)
);




CREATE TABLE Enseignant_Suivi(
    idRéalisation INTEGER  REFERENCES Réalisation(idRéalisation),
    idEnseignant INTEGER  REFERENCES Enseignant(idEnseignant),
    PRIMARY KEY(idRéalisation, idEnseignant)
);




CREATE TABLE Projet_Déclaration(
    idEnseignant INTEGER  REFERENCES Enseignant(idEnseignant),
    nom VARCHAR(255) REFERENCES Enseignant(nom),
    prenom VARCHAR(255) REFERENCES Enseignant(prénom),
    idProjet INTEGER  REFERENCES Projet(idProjet),
    PRIMARY KEY(idEnseignant, idProjet)
);




CREATE TABLE Projet_Compose(
    idProjet INTEGER  REFERENCES Projet(idProjet),
    rang INTEGER  REFERENCES Jalon(rang),
    libelle VARCHAR(255)  REFERENCES Jalon(libelle),
    date_limite DATE  REFERENCES Jalon(date_limite),
    idEquipe VARCHAR(255) REFERENCES Equipe_etudiant(idEquipe),
    PRIMARY KEY(rang, idProjet,libelle,date_limite,idEquipe)
);




CREATE TABLE Jalon_Realisation(
    idRendu INTEGER  REFERENCES Rendu_jalon(idRendu),
    rang INTEGER  REFERENCES Jalon(rang),
    PRIMARY KEY(rang, idRendu)
);




CREATE TABLE UE_Encadrement(
    idEnseignant INTEGER  REFERENCES Enseignant(idEnseignant),
    idUE VARCHAR(255)  REFERENCES UE(idUE),
    PRIMARY KEY(idEnseignant, idUE)
);




CREATE TABLE UE_Responsable(
    idEnseignant INTEGER  REFERENCES Enseignant(idEnseignant),
    idUE VARCHAR(255)  REFERENCES UE(idUE),
    annee INTEGER REFERENCES UE(annee),
    semestre VARCHAR(255) REFERENCES UE(semestre),
    PRIMARY KEY(idEnseignant, idUE, annee, semestre)
);




CREATE TABLE Projet_Appartient(
    idProjet INTEGER  REFERENCES Projet(idProjet),
    idUE VARCHAR(255)  REFERENCES UE(idUE),
    PRIMARY KEY(idProjet, idUE)
);




CREATE TABLE UE_Inscrit(
    numEtu INTEGER  REFERENCES Etudiant(numEtu),
    idUE VARCHAR(255)  REFERENCES UE(idUE),
    idTP INTEGER ,
    idTD INTEGER ,
    PRIMARY KEY(numEtu, idUE)
);




CREATE TABLE Question_Appartient(
    idQuestion INTEGER  REFERENCES Question(idQuestion),
    idUE VARCHAR(255)  REFERENCES UE(idUE),
    PRIMARY KEY(idQuestion, idUE)
);




CREATE TABLE Element_Compose(
    idAvancement INTEGER  REFERENCES Avancement(idAvancement),
    idElement INTEGER  REFERENCES Element(idElement),
    PRIMARY KEY(idAvancement, idElement)
);




CREATE TABLE Element_Mutuel(
    idProjet INTEGER  REFERENCES Projet(idProjet),
    idElement INTEGER  REFERENCES Element(idElement),
    PRIMARY KEY(idProjet, idElement)
);




CREATE TABLE Question_Mutuel(
    idProjet INTEGER  REFERENCES Projet(idProjet),
    idQuestion INTEGER  REFERENCES Question(idQuestion),
    PRIMARY KEY(idProjet, idQuestion)
);




CREATE TABLE Type(
    idEquipe VARCHAR(255) REFERENCES Equipe_etudiant(idEquipe),
    rang INTEGER  REFERENCES Jalon(rang),
    idJalon INTEGER AUTO_INCREMENT,
    PRIMARY KEY(idJalon)
);




CREATE TABLE Concours_Vote(
    idConcours INTEGER  REFERENCES Concours(idConcours),
    idEnseignant INTEGER  REFERENCES Enseignant(idEnseignant),
    PRIMARY KEY(idConcours, idEnseignant)
);




CREATE TABLE Concours_Participe(
    idConcours INTEGER  REFERENCES Concours(idConcours),
    idRéalisation INTEGER  REFERENCES Réalisation(idRéalisation),
    PRIMARY KEY(idConcours, idRéalisation)
);




CREATE TABLE Créer_à_partir_de(
    idProjet INTEGER  REFERENCES Projet(idProjet),
    idProjet1 INTEGER  REFERENCES Projet(idProjet),
    idProjet2 INTEGER  REFERENCES Projet(idProjet),
    idProjet3 INTEGER  REFERENCES Projet(idProjet),
    PRIMARY KEY(idProjet, idProjet1, idProjet2, idProjet3)
);




