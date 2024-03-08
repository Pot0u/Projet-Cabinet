<?php
include('authentification.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylead.css">
    <title>Ajouter un rendez-vous</title>
</head>
<body>
    <h1>Ajouter un rendez-vous</h1>
    <?php
    // Incrémenter l'année de 1
    $date_plus1 = new DateTime();
    $date_plus1->modify('+1 year');
    $date_incrémenté = $date_plus1->format('Y-m-d');
    
    // Récupérer la liste des médecins et usagers pour les sélecteurs
    $sql_medecins = "SELECT Id_Médecin, Civilité, Nom, Prénom FROM médecin";
    $stmt_medecins = $linkpdo->query($sql_medecins);

    $sql_usagers = "SELECT Id_Usager, Civilité, Nom, Prenom FROM usager";
    $stmt_usagers = $linkpdo->query($sql_usagers);

    ?>

    <form action="verifajoutrdv.php" method="post">
        Date du rendez-vous : <input type="date" id="date_rdv" name="date_rdv" min='<?php echo date("Y-m-d")?>' max='<?=$date_incrémenté?>' required><br />
        Heure du rendez-vous : <input type="time" min="08:00" max="18:00" id="heure_rdv" name="heure_rdv" required><br />
        Durée du rendez-vous (en minutes) : <input type="number" min='5' max="50" id="duree_rdv" name="duree_rdv" required><br />

        Sélectionnez un médecin :
        <select id="choix_medecin" name="choix_medecin" required>
            <option value="" disabled selected hidden>Sélectionnez un médecin</option>
            <?php
                while ($row_medecin = $stmt_medecins->fetch()) {
                    echo '<option value="' . $row_medecin['Id_Médecin'] . '">' . $row_medecin['Civilité'] . ' ' . $row_medecin['Nom'] . ' ' . $row_medecin['Prénom'] . '</option>';
                }
            ?>
        </select><br />

        Sélectionnez un usager :
        <select id="choix_usager" name="choix_usager" required>
            <option value="" disabled selected hidden>Sélectionnez un usager</option>
            <?php
                while ($row_usager = $stmt_usagers->fetch()) {
                    echo '<option value="' . $row_usager['Id_Usager'] . '">' . $row_usager['Civilité'] . ' ' . $row_usager['Nom'] . ' ' . $row_usager['Prénom'] . '</option>';
                }
            ?>
        </select><br />

        <input type="submit" value="Valider">
        <input type="reset" value="Vider">
    </form>

    <?php
        // Fermer la connexion PDO
        $linkpdo = null;
    ?>
</body>
</html>
