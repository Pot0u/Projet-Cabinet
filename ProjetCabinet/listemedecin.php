<?php
include('authentification.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylelimed.css">
    <script>
        function resetForm() {
            document.getElementById("filForm").reset();
            window.location.href = "listemedecin.php";
        }
    </script>
    <title>Liste des Médecins</title>
</head>
<body>
    <?php
        // Filtrage des médecins
        // Requête SQL pour récupérer la liste des médecins en fonction des filtres
        $sql = "SELECT * FROM médecin WHERE Id_Médecin IS NOT NULL";

        if (isset($_GET['nom']) && !empty($_GET['nom'])) {
            $nom_filtre = $_GET['nom'];
            $sql .= " AND Nom LIKE '%$nom_filtre%'";
        }

        if (isset($_GET['civility']) && !empty($_GET['civility'])) {
            $civilite_filtre = $_GET['civility'];
            $sql .= " AND Civilité LIKE '$civilite_filtre'";
        }

        if (isset($_GET['prenom']) && !empty($_GET['prenom'])) {
            $prenom_filtre = $_GET['prenom'];
            $sql .= " AND Prénom LIKE '%$prenom_filtre%'";
        }

        $stmt = $linkpdo->query($sql);
        $stmt->execute();

    ?> 
    <h1>Liste des Médecins</h1>

    <!-- Formulaire de filtre -->
    <form id="filForm" method="GET" action="listemedecin.php">
        <label for="civility">Filtrer par Civilité :</label>
        <select id="civility" name="civility">
            <option value="" selected>Toutes les civilités</option>
            <option value="M">Monsieur</option>
            <option value="MME">Madame</option>
        </select>

        <label for="nom">Filtrer par nom :</label>
        <input type="text" id="nom" name="nom" value="<?= isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : ''; ?>">

        <label for="prenom">Filtrer par Prenom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= isset($_GET['prenom']) ? htmlspecialchars($_GET['prenom']) : ''; ?>">

        <input type="submit" value="Filtrer">
        <input type="reset" value="Reset" onclick="resetForm()">
    </form>

    <!-- Liste des médecins -->
    <table border="1">
        <tr>
            <th></th>
            <th>ID</th>
            <th>Civilité</th>
            <th>Nom</th>
            <th>Prénom</th>
            <!-- Autres colonnes nécessaires -->
        </tr>
        <?php 
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo 
                    "<td>
                        <a class='edit-link' href='./modifmed.php?id=".$row['Id_Médecin']."'>Éditer</a>
                        <a class='delete-link' href='./suppmed.php?id=".$row['Id_Médecin']."'>Supprimer</a>
                    </td>";
                echo '<td>' . $row['Id_Médecin'] . '</td>';
                echo '<td>' . $row['Civilité'] . '</td>';
                echo '<td>' . $row['Nom'] . '</td>';
                echo '<td>' . $row['Prénom'] . '</td>';
                echo '</tr>';
            }
        ?>
    </table>
    <?php
        // Fermer la connexion PDO
        $linkpdo = null;
    ?>
</body>
</html>