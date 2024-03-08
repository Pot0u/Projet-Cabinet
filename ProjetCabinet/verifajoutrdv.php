<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vérification d'ajout de rendez-vous</title>
</head>
<body>

<?php
    include('authentification.php');
    include('header.php');
    if ((isset($_POST['choix_medecin']) && isset($_POST['choix_usager'])) || ($_POST['choix_medecin'] == 0 || $_POST['choix_usager'] == 0)) {
        // Récupération des paramètres du formulaire
        $date_rdv = $_POST['date_rdv'];
        $heure_rdv = $_POST['heure_rdv'];
        $duree_rdv = $_POST['duree_rdv'];
        $medecin_id = $_POST['choix_medecin'];
        $usager_id = $_POST['choix_usager'];

        $id = 0;

        //Select le id disponible suivant
        $res = $linkpdo->query('SELECT * FROM rdv');
        while ($data = $res->fetch()) {
            $idtemp = $id;
            $id = $data['Id_RDV'];
            if($id - $idtemp > 1){
                $id = $idtemp;
            }
        }
        $id += 1;

        // Vérification des données du formulaire (vous pouvez ajouter d'autres vérifications si nécessaire)
        if (!empty($date_rdv) && !empty($heure_rdv) && !empty($duree_rdv) && !empty($medecin_id) && !empty($usager_id) || $medecin_id == 0 || $usager_id == 0) {
            
            // Vérification de la disponibilité du médecin à cette heure (vous pouvez ajouter votre propre logique ici)
            $sql_disponibilite = "SELECT * FROM rdv WHERE Id_Médecin = :medecin_id AND Dates = :date_rdv AND Heure = :heure_rdv";
            $stmt_disponibilite = $linkpdo->prepare($sql_disponibilite);
            $stmt_disponibilite->bindParam(':medecin_id', $medecin_id, PDO::PARAM_INT);
            $stmt_disponibilite->bindParam(':date_rdv', $date_rdv, PDO::PARAM_STR);
            $stmt_disponibilite->bindParam(':heure_rdv', $heure_rdv, PDO::PARAM_STR);
            $stmt_disponibilite->execute();

            if ($stmt_disponibilite->rowCount() == 0) {
                // Le médecin est disponible, ajouter le rendez-vous
                $sql_insert_rdv = "INSERT INTO rdv (Id_RDV, Dates, Heure, Durée, Id_Médecin, Id_Usager) 
                                   VALUES (:id_rdv, :date_rdv, :heure_rdv, :duree_rdv, :medecin_id, :usager_id)";
                $stmt_insert_rdv = $linkpdo->prepare($sql_insert_rdv);
                $stmt_insert_rdv->bindParam(':id_rdv', $id, PDO::PARAM_STR);
                $stmt_insert_rdv->bindParam(':date_rdv', $date_rdv, PDO::PARAM_STR);
                $stmt_insert_rdv->bindParam(':heure_rdv', $heure_rdv, PDO::PARAM_STR);
                $stmt_insert_rdv->bindParam(':duree_rdv', $duree_rdv, PDO::PARAM_INT);
                $stmt_insert_rdv->bindParam(':medecin_id', $medecin_id, PDO::PARAM_INT);
                $stmt_insert_rdv->bindParam(':usager_id', $usager_id, PDO::PARAM_INT);
                if($stmt_insert_rdv->execute()) {
                        // Rediriger vers la liste des médecins
                        header('Location: consultation.php');
                        exit;
                }

                echo 'Le rendez-vous a bien été ajouté à la base de données.';
            } else {
                echo 'Le médecin n\'est pas disponible à cette heure.';
            }
        } else {
            echo "Veuillez remplir toutes les informations du rendez-vous. Merci.";
        }
    } else {
        echo "Veuillez sélectionner un médecin et un usager.";
    }

    // Fermer la connexion
    $linkpdo = null;
?>
</body>
</html>
