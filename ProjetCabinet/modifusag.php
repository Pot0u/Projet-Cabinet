<!DOCTYPE html>
<head>
    <title>Modification usager</title>
    <link rel="stylesheet" type="text/css" href="stylemousa.css">
</head>
<body>
<?php
    include('authentification.php');
    include('header.php');
?>
    <h1>Modification de l'usager</h1>
    <?php
        if (isset($_GET['id'])) {
            $usager_id = $_GET['id'];
            // Récupérez les informations de l'usager et du médecin dans la base de données 
            $sql = "SELECT u.*, m.Civilité as civmed, m.Nom as nommed, m.Prénom as premed
                    FROM usager u, médecin m
                    WHERE u.Id_Médecin = m.Id_Médecin
                    AND Id_Usager = :usager_id";
            $stmt = $linkpdo->prepare($sql);
            $stmt->bindParam(':usager_id', $usager_id, PDO::PARAM_INT);
            $stmt->execute();
            $usager_db = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifiez si l'usager existe dans la base de données
            if ($usager_db) {
                // Modifie le nom de l'usager si présent dans la base de donnée
                if (!empty($_GET['civ']) && !empty($_GET['nom']) && !empty($_GET['prenom']) 
                    && !empty($_GET['adr']) && !empty($_GET['lieu']) && !empty($_GET['nai']) 
                    && !empty($_GET['num']) && (!empty($_GET['med']) || ($_GET['med'] !== '') )) {
                    // Récupérez les valeurs soumises par le formulaire
                    $civ = $_GET['civ'];
                    $nom = $_GET['nom'];
                    $prenom = $_GET['prenom'];
                    $adr = $_GET['adr'];
                    $lieu = $_GET['lieu'];
                    $nai = $_GET['nai'];
                    $num = $_GET['num'];
                    $med = $_GET['med'];

                    // Requete qui vérifie si le numéro de sécu de l'usager est diffiérent de celui qu'on change
                    // Si il est pareil alors $boolnum égal false
                    // Sinon vérifie si le nouveau numéro de sécu est déjà présent dans la base de donnée $boolnum égal true
                    $boolnum = True;
                    $sql_verif_num = "SELECT Id_Usager,Num_Sécu FROM usager WHERE Id_Usager = :usager_id";
                    $stmt_verif = $linkpdo->prepare($sql_verif_num);
                    $stmt_verif->bindParam(':usager_id', $usager_id, PDO::PARAM_INT);
                    $stmt_verif->execute();
                    $num_verif = $stmt_verif->fetch(PDO::FETCH_ASSOC);
                    if($num_verif['Num_Sécu'] == $num) {
                        $boolnum = True;
                    } else {
                        $sql_verif_num2 = "SELECT Num_Sécu FROM usager WHERE Id_Usager != :usager_id";
                        $stmt_verif2 = $linkpdo->prepare($sql_verif_num2);
                        $stmt_verif2->bindParam(':usager_id', $usager_id, PDO::PARAM_INT);
                        $stmt_verif2->execute();
                        while($row_num = $stmt_verif2->fetch()) {
                            if($row_num['Num_Sécu'] == $num){
                                $boolnum = False;
                            }
                        }
                    }

                    // Si $boolnum égal true alors fait la maj de la bdd
                    // Sinon ne fait pas la maj dans la bdd
                    if($boolnum) {
                        
                        // Effectuez la mise à jour dans la base de données
                        $update_sql = "UPDATE usager SET 
                                        Civilité = :civ,
                                        Nom = :nom,
                                        Prenom = :prenom,
                                        Adresse_complète = :adr,
                                        Lieu_de_naissance = :lieu,
                                        Date_de_naissance = :nai,
                                        Num_Sécu = :num,
                                        Id_Médecin = :med
                        WHERE Id_Usager = :usager_id";
                        $update_stmt = $linkpdo->prepare($update_sql);
                        $update_stmt->bindParam(':civ', $civ, PDO::PARAM_STR);
                        $update_stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                        $update_stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                        $update_stmt->bindParam(':adr', $adr, PDO::PARAM_STR);
                        $update_stmt->bindParam(':lieu', $lieu, PDO::PARAM_STR);
                        $update_stmt->bindParam(':nai', $nai, PDO::PARAM_STR);
                        $update_stmt->bindParam(':num', $num, PDO::PARAM_STR);
                        $update_stmt->bindParam(':med', $med, PDO::PARAM_STR);
                        $update_stmt->bindParam(':usager_id', $usager_id, PDO::PARAM_INT);
                        $update_stmt->execute();
                        // Redirige vers listeusager.php avec la bdd modifié
                        header('Location: listeusager.php');
                        exit;      
                    } else {
                        echo "Le numéro de sécurité est déjà présent dans la base de donnée.";
                    }
                }

                // Formulaire
                ?>
                <form method='GET' action=''>
                    Identifiant de l'usager :
                    </br><input type='text' name='id' value='<?php echo$usager_db["Id_Usager"];?>'readonly><br>
                    
                    <!-- select pour la civilité -->
                    Civilité :</br>
                    <select name='civ'>
                        <?php
                        echo "<option value='" . $usager_db['Civilité'] ."'> " . $usager_db['Civilité'] . " </option>";
                        // liste des civilités présent dans la db
                        $sql_civ = "SELECT Civilité FROM usager WHERE Civilité != :civi GROUP BY Civilité";
                        $stmt_civ = $linkpdo->prepare($sql_civ);
                        $stmt_civ->bindParam(':civi', $usager_db['Civilité'], PDO::PARAM_STR);
                        $stmt_civ->execute();
                        while ($row_civ = $stmt_civ->fetch()) {
                            echo "<option value='" . $row_civ['Civilité'] . "'>" . $row_civ['Civilité'] . "</option>";
                        } ?>
                    </select><br>
                    Nom :</br><input type='text' maxlength="50" name='nom' value='<?php echo $usager_db['Nom']; ?>'><br>
                    Prenom :</br><input type='text' maxlength="60" name='prenom' value='<?php echo $usager_db['Prenom']; ?>'><br>
                    Adresse complète :</br><input type='text' maxlength="200" name='adr' value='<?php echo $usager_db['Adresse_complète']; ?>'><br>
                    Lieu de naissance :</br><input type='text' name='lieu' value='<?php echo $usager_db['Lieu_de_naissance']; ?>'><br>
                    Date de naissance :</br><input type='date' name='nai' value='<?php echo $usager_db['Date_de_naissance']; ?>' max='9999-12-31' required><br>
                    Numéro sécurité :</br><input type='text' name='num' value='<?php echo $usager_db['Num_Sécu']; ?>' minlength='15' maxlength='15' required><br>
                    
                    <!-- Liste des médecins -->
                    Médecin :</br><select name='med'>
                        <?php
                        $sql_medecins = "SELECT Id_Médecin, Civilité, Nom, Prénom FROM médecin";
                        $stmt_medecins = $linkpdo->query($sql_medecins);
                        // Récup liste med
                        while ($row_medecin = $stmt_medecins->fetch()) {
                            $selected = ($row_medecin['Id_Médecin'] == $usager_db['Id_Médecin']) ? 'selected' : '';
                            echo "<option value='" . $row_medecin['Id_Médecin'] . "' $selected>" . $row_medecin['Civilité'] . ' ' . $row_medecin['Nom'] . ' ' . $row_medecin['Prénom'] . "</option>";
                        }
                        ?>
                    </select><br>
                    <input type='submit' value='Enregistrer'>
                    <input type='button' value='Annuler' onclick='history.back()'>
                </form>
                <?php
            } else {
                echo "L'usager n'existe pas dans la base de données.";
            }
        } else {
            echo "ID de l'usager non spécifié.";
        }
    ?>
    <?php
        // Fermer la connexion PDO
        $linkpdo = null;
    ?>
</body>
</html>
