<?php

$message = "";
$message_prenom_enseignant = "";
$anneeFromUE = [];

$nomEnseignant = nom_enseignant();

if((isset($_POST['nomEnseignant']))){
    $nomEnseignant2 = $_POST['nomEnseignant'];
    $prenomEnseignant = prenom_enseignant($nomEnseignant2);
    if($prenomEnseignant == null){
        $message_prenom_encadrant = "Selectionner le prénom de l'encadrant !";
    }
    if((isset($_POST['prenomEnseignant']))){

    }

}
$anneeFromUE = null;
$selectedAnnee = null;
$enseignantNonInscrit = liste_enseignant_non_inscrit();
$sigle_UE = liste_UE_sigle();
if((isset($_POST['selectUE']))){
    $selectedUE = $_POST['UE'];
    echo($selectedUE);
    $anneeFromUE = liste_annee_from_UE($selectedUE);
    if((isset($_POST['annee'])) && isset($_POST['selectAnnee'])){
        $selectedAnnee = $_POST['annee'];
        echo($selectedAnnee);
        $semestre = liste_semestre_from_UE($selectedUE, $selectedAnnee);
        if((isset($_POST['selectSemestre']))){
            $selectedSemestre = $_POST['semestre'];
            echo($selectedSemestre);
        }
    }
}

if((isset($_POST['submit'])) && $_POST['libellé'] != null && $_POST['résumé'] != null  && $_POST['lien_sujet'] != null && $_POST['nb_équipes'] != null  && $_POST['nb_par_équipes']!= null){
    $libelle = $_POST['libellé'];
    $résumé = $_POST['résumé'];
    $lien_sujet = $_POST['lien_sujet'];
    $nb_équipes = $_POST['nb_équipes'];
    $nb_par_équipes = $_POST['nb_par_équipes'];

    $nouveau_projet = ajout_projet($libellé, $résumé, $lien_sujet, $selectedAnnee, $slectedSemestre);
}





?>