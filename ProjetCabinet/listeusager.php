<!DOCTYPE html>
<head>
    <title>Liste des usagers</title>
    <link rel="stylesheet" type="text/css" href="./css/consultation.css">
    <script src="./js/script.js" defer>
    </script>
    <script>
        function resetForm() {
            document.getElementById("filForm").reset();
            window.location.href = "listeusager.php";
        }
    </script>
</head>
<body>
<?php
include('authentification.php');
include('header.php');
?>

<div class='container'>
    <h1>Liste des Usagers</h1>

    <label for="toggleFilter" id="filtrerLabel">Afficher le filtre</label>
    <input type="checkbox" id="toggleFilter">

    <!--Formulaire filtrage-->
    <form id="filForm" method="GET" action="listeusager.php" style="display: none;">
    <h3> Filtrer le tableau </h3>
        <img src="./image/croix.png" alt="Filter Icon" class="filter-icon" onclick="toggleFilter()">

        <!--Select civilité
        Si Rien n'est selectionné select 'Sélectionnez un option'
        Si 'Homme' Ou 'Femme' n'est pas selectionné alors hidden & disabled
        -->
        <label for="civilite">Filtrer par Civilité :</label>
        <select id="civilite" name="civilite">
            <option disabled <?= (!isset($_GET['civilite']) || ($_GET['civilite'] !== 'Homme' && $_GET['civilite'] !== 'Femme')) ? 'selected' : ''; ?> hidden>Sélectionnez une option</option>
            <option value="" <?= (!isset($_GET['civilite']) || ($_GET['civilite'] !== 'Homme' && $_GET['civilite'] !== 'Femme')) ? 'hidden disabled' : ''; ?>>N'importe</option>
            <option value="Homme" <?= (isset($_GET['civilite']) && $_GET['civilite'] == 'Homme') ? 'selected' : ''; ?>>Homme</option>
            <option value="Femme" <?= (isset($_GET['civilite']) && $_GET['civilite'] == 'Femme') ? 'selected' : ''; ?>>Femme</option>
        </select>

        <label for="nom">Filtrer par nom :</label>
        <input type="text" id="nom" name="nom" value="<?= isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : ''; ?>">

        <label for="prenom">Filtrer par Prenom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= isset($_GET['prenom']) ? htmlspecialchars($_GET['prenom']) : ''; ?>">

        <label for="adr">Filtrer Adresse complète :</label>
        <input type="text" id="adr" name="adr" value="<?= isset($_GET['adr']) ? htmlspecialchars($_GET['adr']) : ''; ?>"></br>

        <label for="date">Filtrer par Date de naissance :</label>
        <input type="date" id="date" name="date" value="<?= isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>">

        <label for="num">Filtrer par Numéro de sécurité :</label>
        <input type="text" id="num" name="num" value="<?= isset($_GET['num']) ? htmlspecialchars($_GET['num']) : ''; ?>">

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
        </br>
        <input type="submit" value="Filtrer">
        <input type="reset" value="Reset" onclick="resetForm()">
    </form>
    <!--Le tableau-->
    <table border="1" class="background-table">
        <tr>
            <th><a href='ajoutusager.php' class='button'>Ajouter usager</a></th>
            <th>Id Usager</th>
            <th>Civilité</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Adresse complète</th>
            <th>Lieu de naissance</th>
            <th>Date de naisance</th>
            <th>Num sécurité</th>
            <th>Médecin</th>
        </tr>

        <?php
        try {
            //SQL pour récupérer les usagers et le med liée
            $sql = "SELECT u.*, m.Civilité as civmed, m.Nom as nommed, m.Prénom as premed 
            FROM usager u, médecin m where u.Id_Médecin = m.Id_Médecin";
            
            // Tous les filtrages
            // rajoute une condition dans la requete pour le filtrage
            if (isset($_GET['nom']) && !empty($_GET['nom'])) {
                $nom_filtre = $_GET['nom'];
                $sql .= " AND u.Nom LIKE '%$nom_filtre%'";
            }

            if (isset($_GET['civilite']) && !empty($_GET['civilite'])) {
                $civilite_filtre = $_GET['civilite'];
                $sql .= " AND u.Civilité LIKE '$civilite_filtre'";
            }

            if (isset($_GET['prenom']) && !empty($_GET['prenom'])) {
                $prenom_filtre = $_GET['prenom'];
                $sql .= " AND u.Prenom LIKE '%$prenom_filtre%'";
            }

            if (isset($_GET['adr']) && !empty($_GET['adr'])) {
                $adr_filtre = $_GET['adr'];
                $sql .= " AND u.Adresse_complète LIKE '%$adr_filtre%'";
            }

            if (isset($_GET['lieu']) && !empty($_GET['lieu'])) {
                $lieu_filtre = $_GET['lieu'];
                $sql .= " AND u.Lieu_de_naissance LIKE '%$lieu_filtre%'";
            }

            if (isset($_GET['date']) && !empty($_GET['date'])) {
                $date_filtre = date('Y-m-d', strtotime($_GET['date']));
                $sql .= " AND u.Date_de_naissance = '$date_filtre'";
            }

            if (isset($_GET['num']) && !empty($_GET['num'])) {
                $num_filtre = $_GET['num'];
                $sql .= " AND u.Num_Sécu LIKE '%$num_filtre%'";
            }

            if (isset($_GET['med']) && $_GET['med'] !== "" && $_GET['med'] !== "tous") {
                $med_filtre = $_GET['med'];
                $sql .= " AND (u.Id_Médecin = '$med_filtre' OR u.Id_Médecin IS NULL)";
            }

            $sql .= " ORDER BY u.Id_Usager";
            // Exécution de la requête
            $stmt = $linkpdo->query($sql);

            // Affichage des données des usagers dans le tableau
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo 
                    "<td>
                        <a class='edit-link' href='./modifusag.php?id=".$row['Id_Usager']."'>Éditer</a>
                        <a class='delete-link' href='./suppusager.php?id=".$row['Id_Usager']."'>Supprimer</a>
                    </td>";
                echo "<td>".$row['Id_Usager']."</td>";
                echo "<td>".$row['Civilité']."</td>";
                echo "<td>".$row['Nom']."</td>";
                echo "<td>".$row['Prenom']."</td>";
                echo "<td>".$row['Adresse_complète']."</td>";
                echo "<td>".$row['Lieu_de_naissance']."</td>";
                echo "<td>".$row['Date_de_naissance']."</td>";
                echo "<td>".$row['Num_Sécu']."</td>";
                echo '<td>' . $row['civmed'] . ' ' . $row['nommed'] . ' ' . $row['premed'] . '</td>';
                echo "</tr>";
            }
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        // Fermer la connexion
        $linkpdo = null;
        ?>
    </table>
</div>
</body>

<?php
// Vérifie si le cookie "utilisateur" existe
if (isset($_COOKIE['utilisateur'])) {
    $utilisateur = $_COOKIE['utilisateur'];
    echo "Bienvenue de nouveau, $utilisateur!";
} else {
    // Crée un cookie "utilisateur" avec la valeur "John Doe" pour une durée d'une heure
    $utilisateur = "John Doe";
    setcookie("utilisateur", $utilisateur, time() + 3600, "/");
    echo "Bienvenue, $utilisateur! Un cookie a été créé.";
}
?>



