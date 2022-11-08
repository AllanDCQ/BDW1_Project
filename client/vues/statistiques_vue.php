<h2 class="subtitle is-3" style="color:#193051;">Statistiques</h2>
<div class="panneau">
  <div> 
	<?php if( $message != "" ) { ?>
		<p class="notification"><?= $message ?></p>
	<?php }else{?>

	<form class="bloc_commandes" method="post" action="#">
		<label for="typeVueTable">Afficher la statistique </label>
		<select name="stats" id="numStat">
			<?php
				$tab = [1,2,3,4,5,6];
				foreach($tab as $t) { ?>
				<option value="<?= $t?>"><?= $t ?></option>
			<?php } ?>
		</select>
		<input type="submit" name="afficherStatistique" value="Afficher la statistique"/>
		</form>
	<div align="center">
		<table class="table is-striped table_statistique">
			<thead>
				<tr>
					<!-- <?php
						//var_dump($resultats);
						foreach($resultats as $att) {  // pour parcourir les attributs
							echo '<th>';
							echo $att['schema'];
							echo '</th>';
						}
					?> 
					<h2 id="titreStat">la liste des projets actifs (libelle, sigle EU associé et nom, prénom du responsable de l’UE)</h2>
					-->
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($resultats['instances'] as $row) {  // pour parcourir les n-uplets
						echo '<tr>';
						foreach($row as $valeur) { // pour parcourir chaque valeur de n-uplets
							echo '<td>'. $valeur . '</td>';
						}
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
	<?php }?>
  </div>
</div>