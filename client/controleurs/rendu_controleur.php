<?php

$message = "";
$message_projet_equipe = "";
$message_select_titre = "";
$message_select_descriptif = "";
$message_jalon = "";

$projetFromEquipe = [];
$rangSelectedJalon = null;
$inputCode = null;
$inputTitreRapport = null;
$inputDescriptifRapport = null;
$projetNomEquipe = null;

$nomEquipe = nom_equipe();

if(isset($_POST['nomEquipe']) == false){
    $message_projet_equipe = "Selectionner une équipe";
}

if(isset($_POST['idProjet']) == false){
    $message_select_titre = "Selectionner un titre";
}

if(isset($_POST['idProjet']) == false){
    $message_select_descriptif = "Selectionner un descriptif";
}




if((isset($_POST['nomEquipe']))){
    $selectedEquipe = $_POST['nomEquipe'];
    $projetNomEquipe = projet_from_id_equipe($selectedEquipe);
    if($projetNomEquipe == null || count($projetNomEquipe) == 0) {
        $message_projet_equipe .= "La requête retourne aucun tuples!";
    }else if($projetNomEquipe == null){
        $message_projet_equipe = "Aucune information disponible pour cette requête ! ";
    }

    if((isset($_POST['idProjet']))){

        $selectedProjet = $_POST['idProjet'];
        $titre = titre_projet_selectionne($selectedProjet);
        foreach($titre as $t){
            foreach($t as $v){
                $titreSelectedProjet = $v;
            }
        }
        $descriptifSelectedProjet = null;
        $descriptif = descriptif_projet_selectionne($selectedProjet);
        foreach($descriptif as $d){
            foreach($d as $w){
                $descriptifSelectedProjet = $w;
            }
        }
        $jalon = jalon_from_projet($selectedProjet, $selectedEquipe);
            if(empty($jalon)){
                $message_jalon = "Selectionner un projet !";
            }else if($jalon == null && count($projet) == 0){
                    $message_jalon = "La requête est vide !";
            }else{
                $message_jalon = "";
            }

            if((isset($_POST['idJalon']))){
                $selectedJalon = $_POST['idJalon'];
                $jalonFromSelectedJalon = select_jalon_from_jalon($selectedProjet, $selectedEquipe, $selectedJalon);
                foreach($jalonFromSelectedJalon as $row){
                    $rangSelectedJalon = $row['rang'];
                }

                $consigne = null;

                switch($rangSelectedJalon){
                    case 1:
                        if((isset($_POST['sendFile']))){
                            //update_file_avancement($selectedJalon, $fileAvancement);
                        }
                    case 2:
                        if((isset($_POST['sendTitreRapport']))){
                            $inputTitreRapport = $_POST['inputTitreRapport'];
                            update_titre_rapport($selectedJalon, $inputTitreRapport);
                        }
                        if((isset($_POST['sendDescriptifRapport']))){
                            $inputDescriptifRapport = $_POST['inputDescriptifRapport'];
                            update_descriptif_rapport($selectedJalon, $inputDescriptifRapport);
                        }
                    case 3:
                        $consigne = consigneSoutenance($selectedJalon);
                        foreach($consigne as $row){
                            foreach($row as $t){
                                $txt = $t;
                                echo($txt);
                            }
                        }
                    case 4:
                        if((isset($_POST['sendCode  ']))){
                            $inputCode = $_POST['inputCode'];
                            update_code($selectedJalon, $inputCode);
                        }
                }

            }

    }
}
?>