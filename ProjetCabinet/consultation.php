<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/consultation.css">
    <script src="./js/script.js" defer></script>
    <title>Liste des Rendez-vous</title>
</head>
<body>
<?php
include('authentification.php');
include('header.php');
?>

<div class='container'>
    <h1>Liste des Rendez-vous</h1>

    <label for="toggleFilter" id="filtrerLabel">Afficher le filtre</label>
    <input type="checkbox" id="toggleFilter">

    <!--Formulaire filtrage-->
    <form id="filForm" method="GET" action="consultation.php" style="display: none;">
    <h3> Filtrer le tableau </h3>
        <img src="./image/croix.png" alt="Filter Icon" class="filter-icon" onclick="toggleFilter()">

        <label for="date">Filtrer par date :</label>
        <input type="date" id="date" name="date" value="<?= isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>">

        <!--Sélectionne la liste des médecins dans un select-->
        <label for="med">Filtrer par Médecin :</label>
        <select id="med" name="med" >
            <option value="" disabled selected hidden>Sélectionnez un médecin</option>
            <option value="tous" <?= (!isset($_GET['med']) || ($_GET['med'] !== "")) ? 'hidden disabled' : ''; ?>>Tous les médecins</option>
            <?php
                $sql = "SELECT Id_Médecin, Civilité, Nom, Prénom FROM médecin";
                $stmt = $linkpdo->query($sql);
                while ($row = $stmt->fetch()) {
                    echo '<option value="' . $row['Id_Médecin'] . '" ';
                    echo isset($_GET['med']) && $_GET['med'] == $row['Id_Médecin'] ? 'selected' : '';
                    echo '>' . $row['Civilité'] . ' ' . $row['Nom'] . ' ' . $row['Prénom'] . '</option>';
                }
            ?>
        </select>
        <label for="usager">Filtrer par Usager :</label>
        <select id="usager" name="usager">
            <option value="" disabled selected hidden>Sélectionnez un usager</option>
            <option value="tous" <?= (!isset($_GET['usager']) || ($_GET['usager'] !== "")) ? 'hidden disabled' : ''; ?>>Tous les usagers</option>
            <?php
                $sql = "SELECT Id_Usager, Civilité, Nom, Prenom FROM usager";
                $stmt = $linkpdo->query($sql);
                while ($row = $stmt->fetch()) {
                    echo '<option value="' . $row['Id_Usager'] . '" ';
                    echo isset($_GET['usager']) && $_GET['usager'] == $row['Id_Usager'] ? 'selected' : '';
                    echo '>';
                    if($row['Civilité'] == 'Homme'){
                        echo "M";
                    }else{
                        echo"MME";
                    } 
                    echo ' ' . $row['Nom'] . ' ' . $row['Prenom'] . '</option>';
                }
            ?>
        </select></br>
        <input type="submit" value="Filtrer">
        <input type="reset" value="Reset" onclick="resetForm()">
    </form>

    <?php
    // Sélectionner les rendez-vous de la base de données
    $sql = "SELECT r.*, m.Civilité as civmed, m.Nom as nommed, m.Prénom as premed, u.Civilité as civusager, u.Nom as nomusager, u.Prenom as preusager
            FROM rdv r
            JOIN médecin m ON r.Id_Médecin = m.Id_Médecin
            JOIN usager u ON r.Id_Usager = u.Id_Usager
            ORDER BY r.Dates, r.Heure";
    $stmt = $linkpdo->query($sql);

    // Vérifier s'il y a des rendez-vous
    if ($stmt->rowCount() > 0) {
        ?>
        <table border="1" class="background-table">
            <tr>
                <th><a href="ajoutrdv.php" class="button">Ajouter un Rendez-vous</a></th>
                <th>Date</th>
                <th>Heure</th>
                <th>Durée</th>
                <th>Médecin</th>
                <th>Usager</th>
            </tr>

            

            <?php
            $sql = "SELECT r.*, m.Civilité as civmed, m.Nom as nommed, m.Prénom as premed, u.Civilité as civusager, u.Nom as nomusager, u.Prenom as preusager
            FROM rdv r
            JOIN médecin m ON r.Id_Médecin = m.Id_Médecin
            JOIN usager u ON r.Id_Usager = u.Id_Usager
            WHERE Dates IS NOT NULL";

            // Tous les filtrages
            // rajoute une condition dans la requete pour le filtrage
            if (isset($_GET['date']) && !empty($_GET['date'])) {
                $date_filtre = date('Y-m-d', strtotime($_GET['date']));
                $sql .= " AND r.Dates = '$date_filtre'";
            }

            if (isset($_GET['med']) && $_GET['med'] !== "" && $_GET['med'] !== "tous") {
                $med_filtre = $_GET['med'];
                $sql .= " AND (r.Id_Médecin = '$med_filtre' OR r.Id_Médecin IS NULL)";
            }

            if (isset($_GET['usager']) && $_GET['usager'] !== "" && $_GET['usager'] !== "tous") {
                $usager_filtre = $_GET['usager'];
                $sql .= " AND (r.Id_Usager = '$usager_filtre' OR r.Id_Usager IS NULL)";
            }
            $sql .= " ORDER BY r.Dates, r.Heure";
            $stmt = $linkpdo->query($sql);
            // Afficher les rendez-vous
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>
                        <a class='edit-link' href='./modifrdv.php?id=".$row['Id_Usager']."'>Éditer</a>
                        <a class='delete-link' href='./supprdv.php?id=".$row['Id_Usager']."'>Supprimer</a>
                    </td>
                    <td>{$row['Dates']}</td>
                    <td>{$row['Heure']}</td>
                    <td>{$row['Durée']} min</td>
                    <td>{$row['civmed']} {$row['nommed']} {$row['premed']}</td>
                    <td>";
                    if($row['civusager'] == 'Homme'){
                        echo "M";
                    }else{
                        echo"MME";
                    }
                    echo " {$row['nomusager']} {$row['preusager']}</td>
                </tr>";
            }
            ?>
        </table>
        <?php
    } else {
        echo "<p>Aucun rendez-vous trouvé.</p>";
    }

    // Fermer la connexion PDO
    $linkpdo = null;
    ?>
</div>
</body>
</html>
