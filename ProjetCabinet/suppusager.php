<?php
    include('authentification.php');
    include('header.php');
    // Vérifier si l'ID de l'usager est présent dans l'URL
    if (isset($_GET['id']) && !empty($_GET['id']) || ($_GET['id']) == 0) {
        // Récupérer l'ID de l'usager
        $usager_id = $_GET['id'];

        // Sélectionner les informations de l'usager pour affichage
        $sql_select = "SELECT * FROM usager WHERE Id_Usager = :usager_id";
        $stmt_select = $linkpdo->prepare($sql_select);
        $stmt_select->bindParam(':usager_id', $usager_id, PDO::PARAM_INT);
        $stmt_select->execute();
        $usager_db = $stmt_select->fetch(PDO::FETCH_ASSOC);
?>
        <h1>Suppression de l'usager</h1>
        <p>Voulez-vous vraiment supprimer l'usager suivant :</p>
        <ul>
            <li>ID : <?= $usager_db['Id_Usager']?></li>
            <li>Civilité : <?= $usager_db['Civilité']?></li>
            <li>Nom : <?=$usager_db['Nom']?></li>
            <li>Prénom : <?=$usager_db['Prenom']?></li>
            <li>Adresse_complète : <?=$usager_db['Adresse_complète']?></li>
            <li>Lieu de naissance : <?=$usager_db['Lieu_de_naissance']?></li>
            <li>Date de naissance : <?=$usager_db['Date_de_naissance']?></li>
            <li>Numéro de sécurité social : <?=$usager_db['Num_Sécu']?></li>
        </ul>

        <form method='POST' action='supprimer_usager.php'>
            <input type='hidden' name='id' value='<?=$usager_db['Id_Usager']?>'>
            <input type='submit' name='submit' value='Supprimer'>
            <a href='listeusager.php'>Annuler</a>
        </form>
        
        <?php
    } else {
        echo "<p>Paramètre d'ID manquant.</p>";
        echo "<a href='listeusager.php'>Retour à la liste des usagers</a>";
    }

?>

<?php
    // Fermer la connexion PDO
    $linkpdo = null;
?>