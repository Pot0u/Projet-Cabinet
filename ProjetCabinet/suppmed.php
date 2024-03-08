<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/stylesup.css">
    <title>Supprimer Médecin</title>
</head>
<body>
<?php
include('authentification.php');
include('header.php');
?>

    <?php
        // Vérifier si l'ID de l'usager est présent dans l'URL
        if (isset($_GET['id']) && !empty($_GET['id']) || $_GET['id'] == 0) {
            // Récupérer l'ID de l'usager
            $med_id = $_GET['id'];
            // Sélectionner les informations de l'usager pour affichage
            $sql_select = "SELECT * FROM médecin WHERE Id_Médecin = :med_id";
            $stmt_select = $linkpdo->prepare($sql_select);
            $stmt_select->bindParam(':med_id', $med_id, PDO::PARAM_INT);
            $stmt_select->execute();
            $med_db = $stmt_select->fetch(PDO::FETCH_ASSOC);
?>
            <!--Afficher les informations de l'usager-->
            <h1>Suppression de l'usager</h1>
            <p>Voulez-vous vraiment supprimer l'usager suivant :</p>
            <ul>
                <li><a>ID : <?=$med_db['Id_Médecin']?></a></li>
                <li><a>Civilité : <?$med_db['Civilité']?></a></li>
                <li><a>Nom : <?=$med_db['Nom']?></a></li>
                <li><a>Prénom : <?=$med_db['Prénom']?></a></li>
            </ul>
            <!--Formulaire pour supprimer le medecin-->
            <form method='POST' action='supprimer_medecin.php'>
                <input type='hidden' name='id' value='<?=$med_db['Id_Médecin']?>'>
                <input type='submit' name='submit' value='Supprimer'>
                <a href='listeusager.php'>Annuler</a>
            </form>
<?php
        } else {
            echo "<p>Paramètre d'ID manquant.</p>";
            echo "<a href='listemedecin.php'>Retour à la liste des usagers</a>";
        }
    ?>
    <?php
        // Fermer la connexion PDO
        $linkpdo = null;
    ?>
</body>
</html>