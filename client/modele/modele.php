<?php

/*
Structure de données permettant de manipuler une base de données :
- Gestion de la connexion
----> Connexion et déconnexion à la base
- Accès au dictionnaire
----> Liste des tables et statistiques
- Informations (structure et contenu) d'une table
----> Schéma et instances d'une table
- Traitement de requêtes
----> Schéma et instances résultant d'une requête de sélection
*/


////////////////////////////////////////////////////////////////////////
///////    Gestion de la connxeion   ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
 	* Initialise la connexion à la base de données courante (spécifiée selon constante
	* globale SERVEUR, UTILISATEUR, MOTDEPASSE, BDD)
 */
function open_connection_DB() {
	global $connexion;

	$connexion = mysqli_connect(SERVEUR, UTILISATEUR, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
}

/**
 *  	Ferme la connexion courante
 * */
function close_connection_DB() {
	global $connexion;

	mysqli_close($connexion);
}

////////////////////////////////////////////////////////////////////////
///////   Accès au dictionnaire       ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
 *  Retourne la liste des tables définies dans la base de données courantes
 * */
function get_tables() {
	global $connexion;

	$requete = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '". BDD ."'";

	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}


/**
 *  Retourne les statistiques sur la base de données courante
 * */
function get_statistique($requete) {
	global $connexion;
	// $requete = "SELECT  V.sigle, P.libellé, V.nom, V.prénom FROM Projet P JOIN Projet_Resp V
	// ON P.idProjet = V.idProjet
	// WHERE P.etat = 'Actif' AND P.année = V.annee AND P.semestre = V.semestre;";
	$res = mysqli_query($connexion, $requete);
	//$schema = mysqli_fetch_fields($res);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return array('instances' => $instances);
}

function get_statistiques_switch($numRequete){
	global $connexion;

	$requete1 = "SELECT  V.sigle, P.libellé, V.nom, V.prénom FROM Projet P JOIN Projet_Resp V
	ON P.idProjet = V.idProjet
	WHERE P.etat = 'Actif' AND P.année = V.annee AND P.semestre = V.semestre;";

	$requete2 = "SELECT U.sigle, U.libellé_UE , COUNT(E.idUE),E.etat FROM UE U JOIN Etat_ProjetUE E ON U.idUE = E.idUE
    GROUP BY U.sigle,U.libellé_UE, E.etat;";

	$requete3 = "SELECT COUNT(idUE) FROM id_UESup2";

	$requete4 = "SELECT A.idUE, A.count_idProjet FROM Nb_ProjetUE A
	WHERE A.count_idProjet = (SELECT MAX(B.count_idProjet) FROM Nb_ProjetUE B);";

	$requete5 = "SELECT E.idEnseignant, E.nom, E.prénom, E.count_idUE FROM count_ProjUE_Enseignant E
    WHERE E.count_idUE = (SELECT MAX(E2.count_idUE) FROM count_ProjUE_Enseignant E2);";

	$requete6 = "SELECT DISTINCT U.sigle, U.idUE,N.nomprenom,N.libellé,N.année,N.semestre,N.note_finale
	FROM UE U JOIN Note_ProjetUE N ON U.idUE = N.idUE
	WHERE N.note_finale = (SELECT MAX(R.note_finale) FROM Note_ProjetUE R
							WHERE N.idUE = R.idUE)
	GROUP BY U.sigle,N.nomprenom;";



	switch ($numRequete) {
		default : case '1': return get_statistique( $requete1 ); break;
		case '2': return get_statistique( $requete2 ); break;
		case '3': return get_statistique( $requete3 ); break;
		case '4': return get_statistique( $requete4 ); break;
		case '5': return get_statistique( $requete5 ); break;
		case '6': return get_statistique( $requete6 ); break;

	}
}

function get_nom_encadrant(){
	global $connexion;

	$requete = "SELECT DISTINCT nom FROM Projet_Déclaration ORDER BY nom";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}


function get_prenom_encadrant($nomEncadrant){
	global $connexion;

	$requete = 'SELECT DISTINCT prenom FROM Projet_Déclaration WHERE nom = "'.$nomEncadrant.'" ORDER BY prenom';

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function get_id_encadrant($nomEncadrant, $prenomEncadrant){
	global $connexion;

	$requete = 'SELECT DISTINCT idEnseignant FROM Projet_Déclaration WHERE nom = "'.$nomEncadrant.'" AND prenom = "'.$prenomEncadrant.'" ';

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function get_projet_from_id_encadrant($idEncadrant){
	global $connexion;

	$requete = "SELECT P.idProjet,P.libellé,P.etat,P.année,P.semestre FROM Projet P JOIN Projet_Déclaration E ON P.idProjet = E.idProjet
	WHERE E.idEnseignant = '".$idEncadrant."' ORDER BY P.idProjet, P.etat, P.année, P.semestre, P.libellé";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function get_id_projet($projetCourant){
	global $connexion;

	$requete = "SELECT idProjet FROM Projet WHERE idProjet = '".$projetCourant."'";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function nb_total_rendu($idEncadrant, $idProjet){
	global $connexion;

	$requete = "SELECT idProjet,libelle, COUNT(R.idRendu) AS nb_rendu_total FROM Projet_Compose C
				JOIN Rendu_jalon R ON C.idEquipe = R.idEquipe and C.rang = R.rang
				JOIN Enseignant_Referant E ON E.idRendu = R.idRendu
				WHERE (E.idEnseignant = $idEncadrant) and (idProjet = $idProjet )
				GROUP BY idProjet, libelle";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}

function nb_rendu($idEncadrant, $idProjetCourant){
	global $connexion;

	$requete = "SELECT idProjet, libelle,COUNT(R2.idRendu) AS nb_rendu FROM Projet_Compose C
			JOIN Rendu_jalon R2 ON C.idEquipe = R2.idEquipe and C.rang = R2.rang
			JOIN Enseignant_Referant E ON E.idRendu = R2.idRendu
			WHERE (E.idEnseignant = $idEncadrant) and (idprojet = $idProjetCourant) and (R2.etat = 'Rendu')
			GROUP BY idProjet, libelle;";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}

function equipe_etat($idEncadrant, $idProjetCourant){
	global $connexion;

	$requete = "SELECT C.idEquipe, C.libelle, etat FROM Projet_Compose C
			JOIN Rendu_jalon R ON C.idEquipe = R.idEquipe and C.rang = R.rang
			JOIN Enseignant_Referant E ON E.idRendu = R.idRendu
			WHERE (E.idEnseignant = $idEncadrant) and (idprojet = $idProjetCourant)
			GROUP BY C.idEquipe, C.libelle, R.etat";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}


////////////////////////////////////////////////////////////////////////
////////////////////// Fonctions pour le rendu /////////////////////////
////////////////////////////////////////////////////////////////////////

function nom_equipe(){
	global $connexion;

	$requete = "SELECT DISTINCT idEquipe FROM Equipe_etudiant ORDER BY idEquipe";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}

function projet_from_id_equipe($nomEquipe){
	global $connexion;

	$requete = "SELECT P.idProjet,P.etat,P.année, P.semestre, P.libellé, C.idEquipe	FROM Projet P JOIN Projet_Compose C ON C.idProjet = P.idProjet
				WHERE idEquipe = '".$nomEquipe."' GROUP BY idProjet ORDER BY P.etat,P.année,P.libellé";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}

function jalon_from_projet($idProjet, $idEquipe){
	global $connexion;

	$requete = "SELECT C.libelle, C.date_limite, C.idEquipe, T.idJalon, C.rang FROM Projet_Compose C JOIN Type T ON C.idEquipe = T.idEquipe AND C.rang = T.rang
				WHERE C.idProjet = $idProjet && C.idEquipe = '".$idEquipe."' ";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function titre_projet_selectionne($idProjet){
	global $connexion;

	$requete = "SELECT libellé FROM Projet WHERE idProjet = '".$idProjet."' ";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function descriptif_projet_selectionne($idProjet){
	global $connexion;

	$requete = "SELECT résumé FROM Projet WHERE idProjet = '".$idProjet."' ";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function select_jalon_from_jalon($idProjet, $idEquipe, $selectedJalon){
	global $connexion;

	$requete = "SELECT C.libelle, C.date_limite, C.idEquipe, T.idJalon, C.rang FROM Projet_Compose C JOIN Type T ON C.idEquipe = T.idEquipe AND C.rang = T.rang
				WHERE C.idProjet = $idProjet && C.idEquipe = '".$idEquipe."' && T.idJalon = $selectedJalon ";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function update_file_avancement($idJalon, $file){
	global $connexion;

	$requete = "INSERT INTO Element(idElement) VALUES ((SELECT max FROM MAX_element) +1 );

				INSERT INTO Element_Compose(idAvancement,idElement)
	  			VALUES (
				$idJalon,
				(SELECT max FROM MAX_element)
	  			);

				UPDATE Element SET File = $file
	  			WHERE idElement = (SELECT max FROM MAX_element);";

	$res = mysqli_query($connexion, $requete);

	return $res;
}

function update_code($idJalon, $codeInput){
	global $connexion;

	$requete = "UPDATE Code SET code = '".$codeInput."' WHERE idCode = $idJalon ";

	$res = mysqli_query($connexion, $requete);

	return $res;
}

function update_titre_rapport($idJalon, $inputTitreRapport){
	global $connexion;

	$requete = "UPDATE Rapport SET titre = '".$inputTitreRapport."' WHERE idRapport = $idJalon ";

	$res = mysqli_query($connexion, $requete);

	return $res;
}

function update_descriptif_rapport($idJalon, $inputDescriptifRapport){
	global $connexion;

	$requete = "UPDATE Rapport SET texte_descriptif = '".$inputDescriptifRapport."' WHERE idRapport = $idJalon ";

	$res = mysqli_query($connexion, $requete);

	return $res;
}

function consigneSoutenance($idJalon){
	global $connexion;

	$requete = "SELECT consigne FROM Soutenance WHERE idSoutenance = $idJalon ";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}


////////////////////////////////////////////////////////////////////////
//////////////// Fonctions pour la création de projet //////////////////
////////////////////////////////////////////////////////////////////////

function nom_enseignant(){
	global $connexion;

	$requete = "SELECT DISTINCT E.nom FROM Enseignant E JOIN UE_Responsable R ON R.idEnseignant = E.idEnseignant;";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function prenom_enseignant($nomEnseignant){
	global $connexion;

	$requete = "SELECT DISTINCT E.prénom FROM Enseignant E JOIN UE_Responsable R ON R.idEnseignant = E.idEnseignant
	  			WHERE E.nom = '".$nomEnseignant."' ";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function liste_enseignant_non_inscrit(){
	global $connexion;

	$requete = "SELECT DISTINCT E.nom, E.prénom FROM Enseignant E WHERE E.idEnseignant NOT IN (SELECT DISTINCT R.idEnseignant FROM Enseignant R
				JOIN UE_Responsable R2 ON R2.idEnseignant = R.idEnseignant);";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}

function liste_UE_sigle(){
	global $connexion;

	$requete = "SELECT DISTINCT U.idUE, U.sigle FROM UE U";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}

function liste_annee_from_UE($idUE){
	global $connexion;

	$requete = "SELECT DISTINCT annee FROM UE WHERE idUE = '".$idUE."' ";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}

function liste_semestre_from_UE($idUE, $annee){
	global $connexion;

	$requete = " SELECT DISTINCT semestre FROM UE WHERE idUE = '".$idUE."' and annee = '".$annee."';";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}

function ajout_info_liste(){
	global $connexion;

	$requete = "SELECT DISTINCT U.idUE, U.sigle FROM UE U";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;
}

function ajout_projet($libellé, $résumé, $lien_sujet, $année, $semestre){
	global $connexion;

	$requete = "INSERT INTO Projet (idProjet,libellé,résumé,lien_sujet,etat,année,semestre)
	VALUES (
	   (SELECT max_idProjet FROM MAX_idProjet) +1 ,
	  '".$libellé."',
	  '".$résumé."',
	  '".$lien_sujet."',
	  Actif,
	  $année,
	  '".$semestre."'
	)";

	$res = mysqli_query($connexion, $requete);

	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	return $instances;

}


////////////////////////////////////////////////////////////////////////
///////    Informations (structure et contenu) d'une table    //////////
////////////////////////////////////////////////////////////////////////

/**
 *  Retourne le détail des infos sur une table
 * */
function get_infos( $typeVue, $nomTable ) {
	global $connexion;

	switch ( $typeVue) {
		case 'schema': return get_infos_schema( $nomTable ); break;
		case 'data': return get_infos_instances( $nomTable ); break;
		default: return null;
	}
}

/**
 * Retourne le détail sur le schéma de la table
*/
function get_infos_schema( $nomTable ) {
	global $connexion;

	// récupération des informations sur la table (schema + instance)
	$requete = "SELECT * FROM $nomTable";
	$res = mysqli_query($connexion, $requete);

	// construction du schéma qui sera composé du nom de l'attribut et de son type
	$schema = array( array( 'nom' => 'nom_attribut' ), array( 'nom' => 'type_attribut' ) , array('nom' => 'clé')) ;

	// récupération des valeurs associées au nom et au type des attributs
	$metadonnees = mysqli_fetch_fields($res);

	$infos_att = array();
	foreach( $metadonnees as $att ){
		//var_dump($att);

 		$is_in_pk = ($att->flags & MYSQLI_PRI_KEY_FLAG)?'PK':'';
 		$type = convertir_type($att->{'type'});

		array_push( $infos_att , array( 'nom' => $att->{'name'}, 'type' => $type , 'cle' => $is_in_pk) );
	}

	return array('schema'=> $schema , 'instances'=> $infos_att);

}

/**
 * Retourne les instances de la table
*/
function get_infos_instances( $nomTable ) {
	global $connexion;

	// récupération des informations sur la table (schema + instance)
	$requete = "SELECT * FROM $nomTable";
 	$res = mysqli_query($connexion, $requete);

 	// extraction des informations sur le schéma à partir du résultat précédent
	$infos_atts = mysqli_fetch_fields($res);

	// filtrage des information du schéma pour ne garder que le nom de l'attribut
	$schema = array();
	foreach( $infos_atts as $att ){
		array_push( $schema , array( 'nom' => $att->{'name'} ) ); // syntaxe objet permettant de récupérer la propriété 'name' du de l'objet descriptif de l'attribut courant
	}

	// récupération des données (instances) de la table
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	// renvoi d'un tableau contenant les informations sur le schéma (nom d'attribut) et les n-uplets
	return array('schema'=> $schema , 'instances'=> $instances);

}


function convertir_type( $code ){
	switch( $code ){
		case 1 : return 'BOOL/TINYINT';
		case 2 : return 'SMALLINT';
		case 3 : return 'INTEGER';
		case 4 : return 'FLOAT';
		case 5 : return 'DOUBLE';
		case 7 : return 'TIMESTAMP';
		case 8 : return 'BIGINT/SERIAL';
		case 9 : return 'MEDIUMINT';
		case 10 : return 'DATE';
		case 11 : return 'TIME';
		case 12 : return 'DATETIME';
		case 13 : return 'YEAR';
		case 16 : return 'BIT';
		case 246 : return 'DECIMAL/NUMERIC/FIXED';
		case 252 : return 'BLOB/TEXT';
		case 253 : return 'VARCHAR/VARBINARY';
		case 254 : return 'CHAR/SET/ENUM/BINARY';
		default : return '?';
	}

}

////////////////////////////////////////////////////////////////////////
///////    Traitement de requêtes                             //////////
////////////////////////////////////////////////////////////////////////

/**
 * Retourne le résultat (schéma et instances) de la requ$ete $requete
 * */
function executer_une_requete( $requete ) {

	//TODO

	return null;
}


?>
