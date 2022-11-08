<h2 class="subtitle is-3" style="color:#193051;">Espace Etudiant - Déposer Rendu</h2>
<div class="panneau">

    <div>
        <form class="bloc_commandes" method="post" action="#">
            <label for="typeVueTable"> Sélectionner votre équipe</label>
            <select name="nomEquipe" id="nomEquipe">
                <?php
					foreach($nomEquipe as $name) { ?>
                		<option value="<?= $name['idEquipe']?>"<?php if(isset($_POST['nomEquipe']) && $_POST['nomEquipe'] == $name['idEquipe']){ echo("selected"); }?>><?= $name['idEquipe'] ?></option>
                <?php }?>
            </select>
            <input type="submit" name="selectionEquipe" value="Selectionner votre équipe">
			<div align="center">
				<table class="table is-striped table_statistique">
					<?php
						if($message_projet_equipe != ""){ ?>
							<p class="notification"><?= $message_projet_equipe ?></p>
					<?php }else{ ?>
					<thead>
						<th>idProjet</th>
						<th>etat</th>
						<th>année</th>
						<th>semestre</th>
						<th>libellé</th>
						<th>idEquipe</th>
					</thead>
						<tbody>
						<?php
						foreach($projetNomEquipe as $row) {  // pour parcourir les n-uplets
							echo '<tr>';
							foreach($row as $valeur) { // pour parcourir chaque valeur de n-uplets
								echo '<td>'. $valeur . '</td>';
							}
						}
							echo '</tr>';
					}?>

					</tbody>
				</table>
			</div>
			<br>
			<br>

		<label for="typeVueTable">Selectionner un projet</label>
			<select name="idProjet" id="idProjet">
				<?php
					if($message_projet != ""){ ?>
						<p class="notification"><?= $message_projet ?></p>
				<?php }else{

					foreach($projetNomEquipe as $row) { ?>
						<option value="<?= $row['idProjet']?>"<?php if(isset($_POST['idProjet']) && $_POST['idProjet'] == $row['idProjet']){ echo("selected"); }?>><?= $row['idProjet'] ?></option>
				<?php }}?>
			</select>
			<input type="submit" name="selectionIdProjet" value="Selectionner un projet"/>
			<p>Titre :  <?= $titreSelectedProjet?> </p>
			<p>Descriptif : <?= $descriptifSelectedProjet?></p>
			<div align="center">
				<table class="table is-striped">
					<?php
						if($message_jalon != ""){ ?>
							<p class="notification"><?= $message_jalon ?></p>
						<?php }else{ ?>
					<thead>
						<th>libelle</th>
						<th>date_limite</th>
						<th>idEquipe</th>
						<th>idJalon</th>
						<th>rang</th>
					</thead>
					<tbody>
						<?php
							foreach($jalon as $row){
								echo '<tr>';
								foreach($row as $valeur) { // pour parcourir chaque valeur de n-uplets
									echo '<td>'. $valeur . '</td>';
								}
							}
								echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
			<br>
			<br>

			<label for="typeVueTable">Selectionner un jalon</label>
			<select name="idJalon" id="idJalon">
				<?php
					if($message_jalon != ""){ ?>
						<p class="notification"><?= $message_jalon ?></p>
				<?php }else{

					foreach($jalon as $row) { ?>
						<option value="<?= $row['idJalon']?>"<?php if(isset($_POST['idJalon']) && $_POST['idJalon'] == $row['idJalon']){ echo("selected"); }?>><?= $row['idJalon'] ?></option>
				<?php }}?>
			</select>
			<input type="submit" name="selectionIdJalon" value="Selectionner un jalon"/>
			<?php
				if($rangSelectedJalon == 1){ ?>
					<form class="bloc_commandes" enctype="multipart/form-data" method="post" action="../modele/upload.php">
						<br>
						<br>
						<label for="selectionIdJalon">Uploader un fichier</label>
						<input type="file" name="fileAvancement" id="fileAvancement"/>
						<input type="submit" name="sendFile" value="Envoyer le fichier" />
					</form>
			<?php
				}
				if($rangSelectedJalon == 2){ ?>
					<form class="bloc_commandes" method="post" action="#">
						<br>
						<br>
						<label for="selectionIdJalon">Taper le titre de votre rapport</label>
						<input type="textarea" name="inputTitreRapport" id="inputTitreRapport"/>
						<input type="submit" name="sendTitreRapport" value="Envoyer le titre"/>
						<br>
						<br>
						<label for="selectionIdJalon">Taper le texte descriptif de votre rapport</label>
						<input type="textarea" name="inputDescriptifRapport" id="inputDescriptifRapport"/>
						<input type="submit" name="sendDescriptifRapport" value="Envoyer le descriptif"/>
				</form>
			<?php
				}
				if($rangSelectedJalon == 3){ ?>
					<p> Consigne : <?= $txt ?></p>
			<?php
				}
				if($rangSelectedJalon == 4){ ?>
					<form class="bloc_commandes" method="post" action="#">
						<br>
						<br>
						<label for="selectionIdJalon">Taper votre code</label>
						<input type="textarea" name="inputCode" id="inputCode"/>
						<input type="submit" name="sendCode" value="Envoyer le code"/>
					</form>
			<?php
				}?>

        </form>

    </div>
</div>