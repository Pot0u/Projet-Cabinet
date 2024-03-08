<?php
include('authentification.php');
include('header.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Usager</title>
    <link rel="stylesheet" type="text/css" href="stylead.css">
</head>
<body>
    <h1>Créer le compte usager</h1>
    <?php
        // Récupération de la liste des médecins
        $sql = "SELECT Id_Médecin, Civilité, Nom, Prénom FROM médecin";
        $stmt = $linkpdo->query($sql); 
    ?>
    <!-- Formulaire pour ajouter un usager -->
    <form action="verifajout.php" method="post">
        <label for="choixciv">Choisir une civilité :</label>
        <select id="choixciv" name="choixciv" required>
            <option value="" disabled selected hidden>Sélectionnez une option</option>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
        </select><br/>
        <label for="nom_saisi">Votre nom :</label>
        <input type="text" id="nom_saisi" name="nom_saisi" maxlength="50" required><br />

        <label for="prenom_saisi">Votre prénom :</label>
        <input type="text" id="prenom_saisi" name="prenom_saisi" maxlength="60" required><br />

        <label for="adresse_saisi">Votre adresse :</label>
        <input type="text" id="adresse_saisi" name="adresse_saisi" maxlength="200" required><br />

        <label for="lieunaiss_saisi">Votre lieu de naissance :</label>
        <input type="text" id="lieunaiss_saisi" name="lieunaiss_saisi" maxlength="200" required><br />

        <label for="date_naissance">Sélectionnez votre date de naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" max='9999-12-31' required><br/>

        <label for="numsecu_saisi">Votre numéro de sécurité sociale :</label>
        <input type="text" id="numsecu_saisi" name="numsecu_saisi" minlength="15" maxlength="15" required><br />

        <label for="choix">Sélectionnez un médecin :</label>
        <select id="choix" name="choix" required>
            <option value="" disabled selected hidden>Sélectionnez un médecin</option>
            <?php 
                while ($row = $stmt->fetch()) {
                    echo '<option value="' . $row['Id_Médecin'] . '">' . $row['Civilité'] . ' ' . $row['Nom'] . ' ' . $row['Prénom'] . '</option>';
                }
            ?>
        </select><br/>
        <input type="submit" value="Valider">
        <input type="reset" value="Vider">
    </form>
    <?php $linkpdo = null; ?>
</body>
</html>
