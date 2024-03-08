<!DOCTYPE html>
<html lang="en">
<head>
    <title>Modification RDV</title>
    <link rel="stylesheet" type="text/css" href="stylemousa.css">
</head>
<body>
<?php
include('authentification.php');
include('header.php');
?>
    <h1>Modification du RDV</h1>
    <?php
        if (isset($_GET['id'])) {
            $rdv_id = $_GET['id'];
            // Récupérez les informations du RDV dans la base de données 
            $sql = "SELECT * FROM rdv WHERE Id_RDV = :rdv_id";
            $stmt = $linkpdo->prepare($sql);
            $stmt->bindParam(':rdv_id', $rdv_id, PDO::PARAM_INT);
            $stmt->execute();
            $rdv_db = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifiez si le RDV existe dans la base de données
            if ($rdv_db) {
                // Modifie les informations du RDV si présent dans la base de données
                if (!empty($_GET['date']) && !empty($_GET['heure']) && !empty($_GET['duree'])
                    && !empty($_GET['med']) && !empty($_GET['usager'])) {
                    // Récupérez les valeurs soumises par le formulaire
                    $date = $_GET['date'];
                    $heure = $_GET['heure'];
                    $duree = $_GET['duree'];
                    $med = $_GET['med'];
                    $usager = $_GET['usager'];

                    // Effectuez la mise à jour dans la base de données
                    $update_sql = "UPDATE rdv SET 
                                    Dates = :date,
                                    Heure = :heure,
                                    Durée = :duree,
                                    Id_Médecin = :med,
                                    Id_Usager = :usager
                    WHERE Id_RDV = :rdv_id";
                    $update_stmt = $linkpdo->prepare($update_sql);
                    $update_stmt->bindParam(':date', $date, PDO::PARAM_STR);
                    $update_stmt->bindParam(':heure', $heure, PDO::PARAM_STR);
                    $update_stmt->bindParam(':duree', $duree, PDO::PARAM_INT);
                    $update_stmt->bindParam(':med', $med, PDO::PARAM_INT);
                    $update_stmt->bindParam(':usager', $usager, PDO::PARAM_INT);
                    $update_stmt->bindParam(':rdv_id', $rdv_id, PDO::PARAM_INT);
                    $update_stmt->execute();

                    // Redirige vers la liste des RDVs avec la base de données modifiée
                    header('Location: consultation.php');
                    exit;      
                }

                // Formulaire
                
                $date_plus1 = new DateTime();
                $date_plus1->modify('+1 year');
                $date_incrémenté = $date_plus1->format('Y-m-d');
    
                ?>
                
                <form method='GET' action=''>
                    Identifiant du RDV :
                    <br><input type='text' name='id' value='<?php echo $rdv_db["Id_RDV"];?>' readonly><br>
                    
                    Date du RDV :
                    <br><input type='date' name='date' min='<?php echo date("Y-m-d")?>' max='<?=$date_incrémenté?>' value='<?php echo $rdv_db["Dates"]; ?>' required><br>
                    
                    Heure du RDV :
                    <br><input type='time' name='heure' min="08:00" max="18:00" value='<?php echo $rdv_db["Heure"]; ?>' required><br>
                    
                    Durée du RDV (en minutes) :
                    <br><input type='number' name='duree' min="5" max="50" value='<?php echo $rdv_db["Durée"]; ?>' required><br>
                    
                    <!-- Liste des médecins -->
                    Médecin :
                    <br><select name='med'>
                        <?php
                        $sql_medecins = "SELECT Id_Médecin, Civilité, Nom, Prénom FROM médecin";
                        $stmt_medecins = $linkpdo->query($sql_medecins);
                        // Récup liste med
                        while ($row_medecin = $stmt_medecins->fetch()) {
                            $selected = ($row_medecin['Id_Médecin'] == $rdv_db['Id_Médecin']) ? 'selected' : '';
                            echo "<option value='" . $row_medecin['Id_Médecin'] . "' $selected>" . $row_medecin['Civilité'] . ' ' . $row_medecin['Nom'] . ' ' . $row_medecin['Prénom'] . "</option>";
                        }
                        ?>
                    </select><br>
                    
                    <!-- Liste des usagers -->
                    Usager :
                    <br><select name='usager'>
                        <?php
                        $sql_usagers = "SELECT Id_Usager, Civilité, Nom, Prenom FROM usager";
                        $stmt_usagers = $linkpdo->query($sql_usagers);
                        // Récup liste usager
                        while ($row_usager = $stmt_usagers->fetch()) {
                            $selected = ($row_usager['Id_Usager'] == $rdv_db['Id_Usager']) ? 'selected' : '';
                            echo "<option value='" . $row_usager['Id_Usager'] . "' $selected>" . $row_usager['Civilité'] . ' ' . $row_usager['Nom'] . ' ' . $row_usager['Prenom'] . "</option>";
                        }
                        ?>
                    </select><br>
                    
                    <input type='submit' value='Enregistrer'>
                    <input type='button' value='Annuler' onclick='history.back()'>
                </form>
                <?php
            } else {
                echo "Le RDV n'existe pas dans la base de données.";
            }
        } else {
            echo "ID du RDV non spécifié.";
        }
    ?>
    <?php
        // Fermer la connexion PDO
        $linkpdo = null;
    ?>
</body>
</html>
