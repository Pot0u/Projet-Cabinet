<!DOCTYPE html>
<head>
    <title>Verification</title>
</head>
<body>

<?php
    include('authentification.php');
    include('header.php');

    if (!empty($_POST['choixciv']) && !empty($_POST['nom_saisi']) && !empty($_POST['prenom_saisi'])) {
        //Récup des paramètres du formulaire

        $choix = $_POST['choixciv'];
        $nom = $_POST['nom_saisi'];
        $prenom = $_POST['prenom_saisi'];

        $id = 0;

        //Select le id disponible suivant
        $res = $linkpdo->query('SELECT * FROM Médecin');
        while ($data = $res->fetch()) {
            $idtemp = $id;
            $id = $data['Id_Médecin'];
            if($id - $idtemp > 1){
                $id = $idtemp;
            }
        }
        $id += 1;

        // Vérif si médecin n'existe pas déjà
        $stmt = $linkpdo->prepare("SELECT COUNT(*) FROM Médecin WHERE Civilité = :choix AND Nom = :nom AND Prénom = :prenom");
        $stmt->bindParam(':choix', $choix, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // Le médecin n'existe pas, on peut l'ajouter
            $insertStmt = $linkpdo->prepare("INSERT INTO Médecin (Id_Médecin, Civilité, Nom, Prénom) VALUES (:id, :choix, :nom, :prenom)");
            $insertStmt->bindParam(':id', $id, PDO::PARAM_STR);
            $insertStmt->bindParam(':choix', $choix, PDO::PARAM_STR);
            $insertStmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $insertStmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            
            if ($insertStmt->execute()) {
                echo 'Le médecin a bien été ajouté à la base de données.';
            } else {
                echo 'Une erreur s\'est produite lors de l\'ajout du médecin.';
            }
        } else {
            // Le médecin existe déjà
            echo 'Le médecin est déjà présent dans la base de données.';
        }
    } else {
        echo 'Veuillez remplir toutes les informations. Merci.';
    }
    // Fermer la connexion
    $linkpdo = null;
?>
</body>
</html>
