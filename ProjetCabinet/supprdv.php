<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/stylesup.css">
    <title>Supprimer Rendez-vous</title>
</head>
<body>
    <?php
    include('authentification.php');
    include('header.php');

    // Vérifier si l'ID du rendez-vous est présent dans l'URL
    if (isset($_GET['id']) && !empty($_GET['id']) || $_GET['id'] == 0) {
        // Récupérer l'ID du rendez-vous
        $rdv_id = $_GET['id'];

        // Sélectionner les informations du rendez-vous pour affichage
        $sql_select = "SELECT r.*, u.Civilité as civusager, u.Nom as nomusager, u.Prenom as prenomusager
                        FROM rdv r
                        LEFT JOIN usager u ON r.Id_Usager = u.Id_Usager
                        WHERE r.Id_RDV = :rdv_id";
        $stmt_select = $linkpdo->prepare($sql_select);
        $stmt_select->bindParam(':rdv_id', $rdv_id, PDO::PARAM_INT);
        $stmt_select->execute();
        $rdv_db = $stmt_select->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le rendez-vous existe dans la base de données
        if ($rdv_db) {
    ?>
            <!-- Afficher les informations du rendez-vous -->
            <h1>Suppression du rendez-vous</h1>
            <p>Voulez-vous vraiment supprimer le rendez-vous suivant :</p>
            <ul>
                <li>ID : <?=$rdv_db['Id_RDV']?></li>
                <li>Date : <?=$rdv_db['Dates']?></li>
                <li>Heure : <?=$rdv_db['Heure']?></li>
                <li>Durée : <?=$rdv_db['Durée']?> minutes</li>
                <li>Usager : <?=$rdv_db['civusager'] . ' ' . $rdv_db['nomusager'] . ' ' . $rdv_db['prenomusager']?></li>
            </ul>
            <!-- Formulaire pour supprimer le rendez-vous -->
            <form method='POST' action='supprimer_rdv.php'>
                <input type='hidden' name='id' value='<?=$rdv_db['Id_RDV']?>'>
                <input type='submit' name='submit' value='Supprimer'>
                <a href='consultation.php'>Annuler</a>
            </form>
        <?php
        } else {
            echo "<p>Le rendez-vous n'existe pas dans la base de données.</p>";
            echo "<a href='consultation.php'>Retour à la liste des rendez-vous</a>";
        }
    } else {
        echo "<p>Paramètre d'ID manquant.</p>";
        echo "<a href='consultation.php'>Retour à la liste des rendez-vous</a>";
    }
    ?>

    <?php
    // Fermer la connexion PDO
    $linkpdo = null;
    ?>
</body>
</html>
