<?php
include('authentification.php');
include('header.php');
?>

<!DOCTYPE html>
<head>
    <title>Modification médecin</title>
    <link rel="stylesheet" type="text/css" href="stylemousa.css">
</head>
<body>
    <?php
        // Vérifier si l'ID du médecin est passé en paramètre
        if (isset($_GET['id'])) {
            $medecin_id = $_GET['id'];

            // Récupérer les informations du médecin à partir de la base de données
            $stmt = $linkpdo->prepare("SELECT * FROM médecin WHERE Id_Médecin = :medecin_id");
            $stmt->bindParam(':medecin_id', $medecin_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
                <h1>Modifier médecin</h1>
                <form action="verifmodifmed.php" method="post">
                    <input type="hidden" name="id" value="<?= $row['Id_Médecin'] ?>">

                    Choisir une civilité :
                    <select id="choixciv" name="choixciv" required>
                        <option value="M" <?= ($row['Civilité'] == 'M') ? 'selected' : '' ?>>Homme</option>
                        <option value="MME" <?= ($row['Civilité'] == 'MME') ? 'selected' : '' ?>>Femme</option>
                    </select><br/>

                    Votre nom : <input type="text" maxlength="50" name="nom_saisi" value="<?= $row['Nom'] ?>" required><br />
                    Votre prénom : <input type="text" maxlength="60" name="prenom_saisi" value="<?= $row['Prénom'] ?>" required><br />

                    <input type="submit" value="Valider">
                    <input type="reset" value="Annuler">
                </form>
    <?php
            } else {
                echo 'Médecin non trouvé.';
            }
        } else {
            echo 'ID du médecin non spécifié.';
        }

        // Fermer la connexion
        $linkpdo = null;
    ?>
</body>
</html>
