<?php
    if(isset($_POST['bouttonRequete'])){
        global $connexion;

        $requete = $_POST['textRequete'];
        $res = mysqli_query($connexion, $requete);
        $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
?>