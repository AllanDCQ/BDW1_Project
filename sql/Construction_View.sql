-- CREATION DES VIEWS

CREATE VIEW Resp_NomPrenom AS
  SELECT E.nom, E.prénom, R.idUE, R.annee,R.semestre FROM Enseignant E JOIN UE_Responsable R
    ON E.idEnseignant = R.idEnseignant;

CREATE VIEW UE_Resp AS
  SELECT U.sigle, R.nom, R.prénom, R.idUE, U.semestre, U.annee FROM UE U JOIN Resp_NomPrenom R
    ON R.idUE = U.idUE AND U.annee = R.annee AND U.semestre = R.semestre;

CREATE VIEW Projet_Resp AS
  SELECT V.sigle, V.nom, V.prénom, V.semestre, V.annee, P.idProjet FROM UE_Resp V 
    JOIN Projet_Appartient P ON V.idUE = P.idUE;INSERT IGNORE INTO Realisation_Compose(idRéalisation,idRendu)
  SELECT E.idRéalisation,R.idRendu FROM Rendu_jalon R JOIN donnees_fournies.instances D ON R.date = D.rendu1_date AND R.note = D.rendu1_note
  JOIN Equipe_Realisation E ON E.idEquipe = D.nom_equipe;


CREATE VIEW Etat_ProjetUE AS
    SELECT A.idProjet, A.idUE, P.etat FROM Projet_Appartient A JOIN Projet P
        ON P.idProjet = A.idProjet;

CREATE VIEW id_equipeSup2 AS
  SELECT idEquipe FROM Equipe_Compose 
    WHERE numEtu > 0 
    GROUP BY idEquipe
    HAVING COUNT(numEtu) > 2;

CREATE VIEW id_ReaSup2 AS
  SELECT idRéalisation FROM Equipe_Realisation E JOIN id_equipeSup2 V
    WHERE E.idEquipe = V.idEquipe;

CREATE VIEW id_ProjetSup2 AS
  SELECT DISTINCT idProjet FROM Realisation_Appartient A JOIN id_ReaSup2 V
    WHERE A.idRéalisation = V.idRéalisation;

CREATE VIEW id_UESup2 AS
  SELECT DISTINCT idUE FROM Projet_Appartient A JOIN id_ProjetSup2 V
    WHERE A.idProjet = V.idProjet;


CREATE VIEW Nb_ProjetUE AS
  SELECT idUE, COUNT(idProjet) AS count_idProjet FROM Projet_Appartient
    GROUP BY idUE;

CREATE VIEW count_ProjUE_Enseignant AS
  SELECT COUNT(C.idUE) AS count_idUE, C.idEnseignant, E.nom, E.prénom FROM UE_Encadrement C JOIN Enseignant E
    ON E.idEnseignant = C.idEnseignant
    GROUP BY idEnseignant;

CREATE VIEW Equipe_NomPrenom AS
  SELECT E.nomprenom,C.idEquipe FROM Etudiant E JOIN Equipe_Compose C 
    ON C.numEtu = E.numEtu;


CREATE VIEW Realisation_NomPrenom AS 
  SELECT R.idRéalisation, E.nomprenom
    FROM Equipe_Realisation R JOIN Equipe_NomPrenom E 
    ON E.idEquipe = R.idEquipe
    WHERE E.nomprenom IS NOT NULL;
  
CREATE VIEW Note_NomPrenom AS
  SELECT R.idRéalisation,N.nomprenom,R.note_finale,P.idProjet
    FROM Réalisation R JOIN Realisation_NomPrenom N 
    ON N.idRéalisation = R.idRéalisation
    JOIN Realisation_Appartient P ON P.idRéalisation = R.idRéalisation
    WHERE note_finale IS NOT NULL;


CREATE VIEW Note_ProjetUE AS
  SELECT P.idProjet,P.libellé,P.année,P.semestre,R.nomprenom,R.note_finale,U.idUE
    FROM Projet P JOIN Note_NomPrenom R ON P.idProjet = R.idProjet 
    JOIN Projet_Appartient U ON R.idProjet = U.idProjet;


CREATE VIEW MAX_element AS
  SELECT MAX(idElement) FROM Element;
INSERT INTO Element(idElement) VALUES (0);


CREATE VIEW MAX_idProjet AS
  SELECT MAX(idProjet) AS max_idProjet FROM Projet;



CREATE VIEW MAX_numEquipe AS
  SELECT MAX(numEquipe) AS max_numEquipe FROM Equipe_etudiant;

CREATE VIEW lastEquipe AS 
  SELECT E.numEtu,E.idEquipe FROM Equipe_Compose E 
    WHERE E.idEquipe = (CONCAT('Equipe_',(SELECT max_numEquipe FROM MAX_numEquipe)));

CREATE VIEW idEquipeString AS
  SELECT CONCAT("Equipe_",(SELECT max_numEquipe FROM MAX_numEquipe)) AS ConcatenatedString;


CREATE VIEW MAX_idRendu AS
  SELECT MAX(idRendu) AS max_idRendu FROM Rendu_jalon;
