
/*la liste des projets actifs (libelle, sigle EU associé et nom, prénom du responsable de l’UE) ;*/

SELECT  V.sigle, P.libellé, V.nom, V.prénom FROM Projet P JOIN Projet_Resp V
  ON P.idProjet = V.idProjet
  WHERE P.etat = 'Actif' AND P.année = V.annee AND P.semestre = V.semestre;






/*Pour chaque UE (sigle, libelle), le nombre de projets répartis par état ;*/


  SELECT U.sigle, U.libellé_UE , COUNT(E.idUE),E.etat FROM UE U JOIN Etat_ProjetUE E ON U.idUE = E.idUE
    GROUP BY U.sigle,U.libellé_UE, E.etat;


/*Le nombre d’UE qui accepte des équipes de plus de 2 étudiants ;*/

SELECT COUNT(idUE) FROM id_UESup2 ;



/*L’UE qui a proposé le plus de projets ;*/


SELECT A.idUE, A.count_idProjet FROM Nb_ProjetUE A
  WHERE A.count_idProjet = (SELECT MAX(B.count_idProjet) FROM Nb_ProjetUE B);



/*L’enseignant qui a encadré le plus de projets toutes UE confondues.*/

    SELECT E.idEnseignant, E.nom, E.prénom, E.count_idUE FROM count_ProjUE_Enseignant E
	    WHERE E.count_idUE = (SELECT MAX(E2.count_idUE) FROM count_ProjUE_Enseignant E2);


/*Pour chaque UE (sigle, libelle), donner le nom, prénom des étudiants qui ont obtenu la meilleur note tout
semestre confondu. On précisera le projet, l’année et le semestre pour lesquels ces étudiants ont obtenu
cette note.*/


SELECT DISTINCT U.sigle, U.idUE,N.nomprenom,N.libellé,N.année,N.semestre,N.note_finale
  FROM UE U JOIN Note_ProjetUE N ON U.idUE = N.idUE
  WHERE N.note_finale = (SELECT MAX(R.note_finale) FROM Note_ProjetUE R
                          WHERE N.idUE = R.idUE)
  GROUP BY U.sigle,N.nomprenom





/* TABLEAU DE BORDS */

SELECT DISTINCT nom FROM Projet_Déclaration
  ORDER BY nom;

SELECT DISTINCT prenom FROM Projet_Déclaration
  WHERE nom = ""
  ORDER BY prenom;


SELECT P.idProjet,P.libellé,P.etat,P.année,P.semestre FROM Projet P JOIN Projet_Déclaration E ON P.idProjet = E.idProjet
  WHERE E.idEnseignant = "60"
  ORDER BY P.etat, P.année, P.semestre, P.libellé;




SELECT idProjet,libelle, COUNT(R.idRendu) AS nb_rendu_total FROM Projet_Compose C
  JOIN Rendu_jalon R ON C.idEquipe = R.idEquipe and C.rang = R.rang
  JOIN Enseignant_Referant E ON E.idRendu = R.idRendu
  WHERE (E.idEnseignant = "60") and (idProjet = "102")
  GROUP BY idProjet, libelle;

SELECT idProjet, libelle,COUNT(R2.idRendu) AS nb_rendu FROM Projet_Compose C
  JOIN Rendu_jalon R2 ON C.idEquipe = R2.idEquipe and C.rang = R2.rang
  JOIN Enseignant_Referant E ON E.idRendu = R2.idRendu
  WHERE (E.idEnseignant = "60") and (idProjet = "102") and (R2.etat = "Rendu")
  GROUP BY idProjet, libelle;
    
SELECT C.idEquipe, C.libelle, etat FROM Projet_Compose C
  JOIN Rendu_jalon R ON C.idEquipe = R.idEquipe and C.rang = R.rang
  JOIN Enseignant_Referant E ON E.idRendu = R.idRendu
  WHERE (E.idEnseignant = "60") and (iPprojet = "102") 
  GROUP BY C.idEquipe, C.libelle, R.etat




/* Depot rendu */

SELECT DISTINCT idEquipe FROM Equipe_etudiant
  ORDER BY idEquipe;
  --> récupère idEquipe 

SELECT P.idProjet,P.etat,P.année, P.semestre, P.libellé, C.idEquipe
  FROM Projet P JOIN Projet_Compose C ON C.idProjet = P.idProjet
  WHERE idEquipe = "Equipe_1"
  GROUP BY idProjet
  ORDER BY P.etat,P.année,P.libellé
  --> récupère idProjet 


SELECT libellé FROM Projet
  WHERE idProjet = ""

SELECT résumé FROM Projet
  WHERE idProjet = ""




SELECT C.libelle, C.date_limite, C.idEquipe, T.idJalon 
  FROM Projet_Compose C JOIN Type T ON C.idEquipe = T.idEquipe AND C.rang = T.rang
  WHERE C.idProjet = "1" && C.idEquipe = "Equipe_1"
  --> Récupère T.idJalon
  --> C.rang




SELECT code FROM Code
  WHERE idCode = "idJal"
UPDATE Code SET code = "FORMAIRE"
  WHERE idCode = ""




SELECT titre FROM Rapport
  WHERE idRapport = ""
SELECT texte_descriptif FROM Rapport
  WHERE idRapport = ""
UPDATE Rapport SET titre = ""
  WHERE idRapport = ""
UPDATE Rapport SET texte_descriptif = ""
  WHERE idRapport = ""





SELECT titre FROM Soutenance
  WHERE idSoutenance = ""
SELECT consigne FROM Soutenance
  WHERE idSoutenance = ""

SELECT jour,heure,salle,batiment FROM Soutenance_Affecter
  WHERE idSoutenance = ""




INSERT INTO Element(idElement) VALUES ((SELECT max FROM MAX_element) +1 );

INSERT INTO Element_Compose(idAvancement,idElement)
  VALUES (
    "$idJalon",
    (SELECT max FROM MAX_element)
  );

UPDATE Element SET File = "$file"
  WHERE idElement = (SELECT max FROM MAX_element);




/* Création Projet */


SELECT DISTINCT E.nom FROM Enseignant E
  JOIN UE_Responsable R ON R.idEnseignant = E.idEnseignant;

SELECT DISTINCT E.prenom FROM Enseignant E
  JOIN UE_Responsable R ON R.idEnseignant = E.idEnseignant
  WHERE E.nom = $nom;




    SELECT DISTINCT E.nom, E.prénom FROM Enseignant E
      WHERE E.idEnseignant NOT IN (SELECT DISTINCT R.idEnseignant FROM Enseignant R 
                      JOIN UE_Responsable R2 ON R2.idEnseignant = R.idEnseignant);

    SELECT DISTINCT U.idUE, U.sigle FROM UE U;

    SELECT DISTINCT annee FROM UE 
      WHERE idUE = "$idUE";

    SELECT DISTINCT semestre FROM UE 
      WHERE idUE = "$idUE" and annee = "$annee";

    INSERT INTO UE_Responsable (idEnseignant,idUE,annee,semestre) 
      VALUES ("$idEnseignant","$idUE","$annee","$semestre");
    --> Insert pour nouvel Enseignant 




-- Formulaire : libellé, résumé, lien sujet, nb_equipe, nb_par_equipes _ selection des jalons

INSERT INTO Projet (idProjet,libellé,résumé,lien_sujet,etat,année,semestre)
  VALUES (
     (SELECT max_idProjet FROM MAX_idProjet) +1 ,
    "$libellé",
    "$résumé",
    "$lien_sujet",
    "Actif",
    "$annee",
    "$semestre"
  )


--------------------------- Choisir les encadrants du projet -------------------------------
SELECT DISTINCT E.nom,E.prénom FROM Enseignant E;
--> récupérer idEnseignant

    INSERT INTO Projet_Déclaration(idEnseignant,nom,prénom,idProjet)
      VALUE (
        "$idEnseignant",
        (SELECT DISTINCT nom FROM Enseignant WHERE idEnseignant = "$idEnseignant"),
        (SELECT DISTINCT prénom FROM Enseignant WHERE idEnseignant = "$idEnseignant")
      )
    INSERT INTO UE_Encadrement(idEnseignant,idUE)
      VALUE (
        "$idEnseignant",
        "$idUE"
      )


SELECT E.nom,E.prénom,P.idEnseignant,P.idProjet FROM Projet_Déclaration P JOIN Enseignant E
  ON P.idEnseignant = E.idEnseignant
  WHERE P.idProjet = (SELECT max_idProjet FROM MAX_idProjet)
-------------------------------------------------------------------------------------------





---------------------------------- Ajout des étudiants aléatoirement et assigne un encadrant ------------------------------

-- For nbEquipe

INSERT INTO Equipe_etudiant(numEquipe,idEquipe) 
  VALUES (
    (SELECT max_numEquipe FROM MAX_numEquipe) +1,
    (SELECT max_numEquipe FROM MAX_numEquipe) +1
    );
UPDATE Equipe_etudiant SET idEquipe = (SELECT ConcatenatedString FROM idEquipeString)
  WHERE numEquipe = (SELECT max_numEquipe FROM MAX_numEquipe);

-- FOR i < $nb_max
  INSERT INTO Equipe_Compose(idEquipe,numEtu) 
    VALUES ((SELECT DISTINCT L.idEquipe FROM lastEquipe L),
           (SELECT numEtu FROM UE_Inscrit
                          WHERE idUE = "INF12345" AND numEtu NOT IN (SELECT L2.numEtu FROM lastEquipe L2)
                          ORDER BY RAND() LIMIT 1)
    )
----END
INSERT INTO Enseignant_Referant(idEnseignant,idRendu,idEquipe)
  VALUES( 
    (SELECT E.idEnseignant FROM Projet_Déclaration P JOIN Enseignant E
      ON P.idEnseignant = E.idEnseignant
      WHERE P.idProjet = (SELECT max_idProjet FROM MAX_idProjet)
      ORDER BY RAND() LIMIT 1),
    (SELECT max_idRendu FROM MAX_idRendu)+1,
    $idEquipe
  );
--- END

---------------------------------------------------------------------------------------------------------------------------------












