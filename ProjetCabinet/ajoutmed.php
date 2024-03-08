<?php
include('authentification.php');
include('header.php');
?>

<!DOCTYPE html>
<head>
    <title>Médecin</title>
    <link rel="stylesheet" type="text/css" href="stylead.css">
</head>
<body>
    <h1>Ajouter un médecin</h1>
    <?php
        // Récupérer la liste des médecins
        $sql = "SELECT Id_Médecin, Civilité, Nom, Prénom FROM médecin";
        $stmt = $linkpdo->query($sql);
    ?>
    <form action="verifajoutmed.php" method="post">
        Choisir une civilité : 
        <select id="choixciv" name="choixciv" required>
            <option value="" disabled selected hidden>Sélectionnez une option</option>
            <option value="M">Homme</option>
            <option value="MME">Femme</option>
        </select><br/>

        Votre nom : <input type="text" maxlength="50" name="nom_saisi" required><br />
        Votre prénom : <input type="text" maxlength="60" name="prenom_saisi" required><br />

        <input type="submit" value="Valider">
        <input type="reset" value="Vider">
        
        <?php
            // Fermer la connexion PDO
            $linkpdo = null;
        ?>
    </form>
</body>
</html>
