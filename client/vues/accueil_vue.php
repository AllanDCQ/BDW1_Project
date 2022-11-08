<main>

    <div>

		<h2 class="subtitle is-3" style="color:#193051;">Espace Enseignant - Tableau de Bord</h2>

        <form class="bloc_commandes" method="post" action="#">
            <label for="typeVueTable">Selectionner votre nom</label>
            <select name="nomEncadrant" id="nomEncadrant">
                <?php
					foreach($lastNameEncadrant as $name) { ?>
                		<option value="<?= $name['nom']?>"<?php if(isset($_POST['nomEncadrant']) && $_POST['nomEncadrant'] == $name['nom']){ echo("selected"); }?>><?= $name['nom'] ?></option>
                <?php }?>
            </select>
            <input type="submit" name="selectionNomEncadrant" value="Selectionner votre nom"/>

			<br>
			<br>

			<label for="typeVueTable">Selectionner votre prénom</label>
			<select name="prenomEncadrant" id="prenomEncadrant">
                <?php
					if($message_nom_encadrant != ""){ ?>
						<p class="notification"><?= $message_nom_encadrant ?></p>
					<?php
					}else{
					foreach($firstNameEncadrant as $name) { ?>
                		<option value="<?= $name['prenom']?>"><?= $name['prenom']  ?></option>
                <?php }
					}?>
            </select>
			<input type="submit" name="selectionPrenomEncadrant" value="Selectionner votre prenom"/>

			</br>
			</br>
			
			<div align="center">
				<table class="table is-striped table_statistique">
					<?php
						if($message_projet != ""){ ?>
							<p class="notification"><?= $message_projet ?></p>
					<?php }else{ ?>
					<thead>
						<th>idProjet</th>
						<th>libelle</th>
						<th>etat</th>
						<th>année</th>
						<th>semestre</th>
					</thead>
					<tbody>
						<?php
						foreach($projet as $row) {  // pour parcourir les n-uplets
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

			</br>

			<label for="typeVueTable">Selectionner un projet</label>
			<select name="idProjet" id="idProjet">
				<?php
					if($message_projet != ""){ ?>
						<p class="notification"><?= $message_projet ?></p>
				<?php }else{

					foreach($projet as $row) { ?>
						<option value="<?= $row['idProjet']?>"<?php if(isset($_POST['idProjet']) && $_POST['idProjet'] == $row['idProjet']){ echo("selected"); }?>><?= $row['idProjet'] ?></option>
				<?php }}?>
			</select>
			<input type="submit" name="selectionIdProjet" value="Selectionner un projet"/>
			
			</br>
			</br>
			
			<div class="columns" align="center">
				<div class="column">
					<table class="table is-striped">
						<?php
							if($message_id_projet_courant != ""){ ?>
								<p class="notification"><?= $message_id_projet_courant ?></p>
						<?php }else{ ?>
						<thead>
							<th>idProjet</th>
							<th>Nom</th>
							<th>nb_rendu_total</th>
						</thead>
						<tbody>
							<?php
								foreach($nbTotalRendu as $row){
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
				<div class="column">
					<table class="table is-striped">
						<?php
							if($message_id_projet_courant != ""){ ?>
								<p class="notification"><?= $message_id_projet_courant ?></p>
						<?php }else{ ?>
						<thead>
							<th>idProjet</th>
							<th>Nom</th>
							<th>nb_rendu</th>
						</thead>
						<tbody>
							<?php
								foreach($nbRendu as $row){
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
				<div class="column">
					<table class="table is-striped">
						<?php
							if($message_id_projet_courant != ""){ ?>
								<p class="notification"><?= $message_id_projet_courant ?></p>
						<?php }else{ ?>
						<thead>
							<th>idEquipe</th>
							<th>Nom</th>
							<th>etat</th>
						</thead>
						<tbody>
							<?php
								foreach($equipeEtat as $row){
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
			</div>
		</form>
    </div>
</main>