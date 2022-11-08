<?php
$message = "";

if(isset($_POST['afficherStatistique'])) {

	$numRequete = mysqli_real_escape_string($connexion, trim($_POST['stats']));
	$resultats = get_statistiques_switch($numRequete);
	if($resultats == null || count($resultats) == 0) {
		$message .= "Aucune statistique n'est disponible!";
	}else if($resultats == null){
		$message_details = "Aucune information disponible sur $type_vue de $nom_table !";
	}
}
?>