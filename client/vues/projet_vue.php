<h2 class="subtitle is-3" style="color:#193051;">Espace Enseignant - Création Projet</h2>
<div class="panneau">
    <div>
        <h3 class="subtitle is-4" style="color:#193051;">Ajouter Responsable</h3>
        <form class="bloc_commandes" method="post" action="#">
            <label for="nomEnseignantNonInscrit">Selectionner votre nom pour l'ajouter</label>
            <select name="nomEnseignantNonInscrit" id="nomEnseignantNonInscrit">
                <?php
                    foreach($enseignantNonInscrit as $name) { ?>
                        <option value="<?= $name['nom']?>"<?php if(isset($_POST['nomEnseignantNonInscrit']) && $_POST['nomEnseignantNonInscrit'] == $name['nom']){ echo("selected"); }?>><?= $name['nom'] ?></option>
                <?php }?>
            </select>
            <input type="submit" name="selectionNomEnseignantNonInscrit" value="Selectionner votre prenom"/>
            </br>
            </br>
            <label for="prenomEnseignantNonInscrit">Selectionner votre prénom pour l'ajouter</label>
            <select name="prenomEnseignantNonInscrit" id="prenomEnseignantNonInscrit">
                <?php
                    foreach($enseignantNonInscrit as $name) { ?>
                        <option value="<?= $name['prénom']?>"<?php if(isset($_POST['prenomEnseignantNonInscrit']) && $_POST['prenomEnseignantNonInscrit'] == $name['prénom']){ echo("selected"); }?>><?= $name['prénom'] ?></option>
                <?php }?>
            </select>
            <input type="submit" name="selectionPrenomEnseignantNonInscrit" value="Selectionner votre prenom"/>
            </br>
            </br>
            <label for="nomEnseignantNonInscrit">Selectionner une UE</label>
            <select name="UE" id="UE">
                <?php
                    foreach($sigle_UE as $UE) { ?>
                        <option value="<?= $UE['idUE']?>"<?php if(isset($_POST['UE']) && $_POST['UE'] == $UE['idUE']){ echo("selected"); }?>><?= $UE['idUE'] ?></option>
                <?php }?>
            </select>
            <input type="submit" name="selectUE" value="Choisir cette UE"/>
            </br>
            </br>
            <label for="nomEnseignantNonInscrit">Selectionner cette année</label>
            <select name="annee" id="annee">
                <?php
                if (is_array($anneeFromUE) || is_object($anneeFromUE)){
                    foreach($anneeFromUE as $a) { ?>
                        <option value="<?= $a['annee']?>"<?php if(isset($_POST['annee']) && $_POST['annee'] == $a['annee']){ echo("selected"); }?>><?= $a['annee'] ?></option>
                <?php }}?>
            </select>
            <input type="submit" name="selectAnnee" value="Choisir cette année"/>
            </br>
            </br>
            <label for="nomEnseignantNonInscrit">Selectionner un sigle</label>
            <select name="sigle" id="sigle">
                <?php
                    foreach($sigle_UE as $sigle) { ?>
                        <option value="<?= $sigle['sigle']?>"<?php if(isset($_POST['sigle']) && $_POST['sigle'] == $sigle['sigle']){ echo("selected"); }?>><?= $sigle['sigle'] ?></option>
                <?php }?>
            </select>
            <input type="submit" name="selectSigle" value="Choisir ce sigle"/>
            </br>
            </br>
            <label for="nomEnseignantNonInscrit">Selectionner un semestre</label>
            <select name="semestre" id="semestre">
                <?php
                    foreach($semestre as $s) { ?>
                        <option value="<?= $s['semestre']?>"<?php if(isset($_POST['semestre']) && $_POST['semestre'] == $s['semestre']){ echo("selected"); }?>><?= $s['semestre'] ?></option>
                <?php }?>
            </select>
            <input type="submit" name="selectSemestre" value="Choisir ce semestre"/>
            </br>
            </br>
            <input type="submit" name="ajoutEnseignant" value="Ajouter mes informations dans la liste"/>
            </br>
        </form>
    </div>



    <div>
        <h3 class="subtitle is-4" style="color:#193051;">Sélection Enseignant</h3>
        <form class="bloc_commandes" method="post" action="#">
            <label for="nomEnseignant">Selectionner votre nom</label>
            <select name="nomEnseignant" id="nomEnseignant">
                <?php
					foreach($nomEnseignant as $name) { ?>
                		<option value="<?= $name['nom']?>"<?php if(isset($_POST['nomEnseignant']) && $_POST['nomEnseignant'] == $name['nom']){ echo("selected"); }?>><?= $name['nom'] ?></option>
                <?php }?>
            </select>
            <input type="submit" name="selectionNomEnseignant" value="Selectionner votre nom"/>

            <br>
            <br>

			<label for="prenomEnseignant">Selectionner votre prénom</label>
			<select name="prenomEnseignant" id="prenomEnseignant">
                <?php
					if($message_nom_enseignant != ""){ ?>
						<p class="notification"><?= $message_nom_enseignant ?></p>
					<?php
					}else{
					foreach($prenomEnseignant as $name) { ?>
                		<option value="<?= $name['prénom']?>"<?php if(isset($_POST['prenomEnseignant']) && $_POST['prenomEnseignant'] == $name['prénom']){ echo("selected"); }?>><?= $name['prénom'] ?></option>
                <?php }
					}?>
            </select>
			<input type="submit" name="selectionPrenomEnseignant" value="Selectionner votre prenom"/>
        </form>

        </br>
        <h3 class="subtitle is-4" style="color:#193051;">Création Projet</h3>

        <form method="post" action="#" class="bloc_commandes">
            <label for="libellé">Entrer votre libellé</label>
            <textarea name="libellé" class="textarea has-fixed-size" placeholder="Entrez votre libellé" rows="1"></textarea>
            <br>
            <br>
            <label for="résumé">Entrer votre résumé</label>
            <textarea name="résumé" class="textarea" placeholder="Entrez votre résumé" rows="5"></textarea>
            <br>
            <br>
            <label for="lien_sujet">Entrer le lien du sujet</label>
            <textarea name="lien_sujet" class="textarea has-fixed-size" placeholder="Entrez le lien du sujet" rows="1"></textarea>
            <br>
            <br>
            <label for="nb_équipes">Sélectionner le nombre d'équipes</label>
            <br>
            <input type="number" name="nb_équipes" value="Sélectionner le nombre d'équipes" min="1" max="30"/>
            <br>
            <br>
            <label for="nb_par_équipes">Entrer le nombre d'étudiant par équipes</label>
            <br>
            <input type="number" name="nb_par_équipes" value="Sélectionner le nombre d'équipes" min="1" max="8"/>
            <br>
            <br>
            <input type="submit" name="submit" value="Envoyer les informations"/>
        </form>
    </div>
</div>

<!--------------------------------------------------------------------------------------------------------------------------------------
                     Création Projet incomplet en PHP mais requêtes SQL faites : voir Requetes.sql ligne 217
--------------------------------------------------------------------------------------------------------------------------------------->