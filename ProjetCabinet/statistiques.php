<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styletest.css">
    <title>Statistiques</title>
</head>
<body>

<?php
include('authentification.php');
include('header.php');
// Statistique 1: Répartition des usagers par sexe et âge (pivote)
$sqlStat1 = "SELECT
                TrancheAge,
                SUM(CASE WHEN Civilité = 'Homme' THEN 1 ELSE 0 END) AS NbHommes,
                SUM(CASE WHEN Civilité = 'Femme' THEN 1 ELSE 0 END) AS NbFemmes
             FROM (
                SELECT
                    CASE
                        WHEN TIMESTAMPDIFF(YEAR, Date_de_naissance, CURDATE()) < 25 THEN 'Moins de 25 ans'
                        WHEN TIMESTAMPDIFF(YEAR, Date_de_naissance, CURDATE()) BETWEEN 25 AND 50 THEN 'Entre 25 et 50 ans'
                        ELSE 'Plus de 50 ans'
                    END AS TrancheAge,
                    Civilité
                FROM usager
             ) AS Subquery
             GROUP BY TrancheAge
             ORDER BY FIELD(TrancheAge, 'Moins de 25 ans', 'Entre 25 et 50 ans', 'Plus de 50 ans')";

$stmtStat1 = $linkpdo->query($sqlStat1);
?>
<h1>Statistiques</h1>
<h2>Répartition des usagers par sexe et âge</h2>
<table border="1">
    <tr>
        <th>Tranche d'âge</th>
        <th>Nb Hommes</th>
        <th>Nb Femmes</th>
    </tr>
    <?php while ($rowStat1 = $stmtStat1->fetch()) : ?>
        <tr>
            <td><?= $rowStat1['TrancheAge']; ?></td>
            <td><?= $rowStat1['NbHommes']; ?></td>
            <td><?= $rowStat1['NbFemmes']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<?php
// Statistique 2: Durée totale des consultations par médecin (en nombre d'heures)
$sqlStat2 = "SELECT
                médecin.Nom AS NomMédecin,
                médecin.Prénom AS PrénomMédecin,
                SUM(Durée) AS DuréeTotale
             FROM rdv
             INNER JOIN médecin ON rdv.Id_Médecin = médecin.Id_Médecin
             GROUP BY rdv.Id_Médecin, médecin.Nom, médecin.Prénom";

$stmtStat2 = $linkpdo->query($sqlStat2);
?>

<h2>Durée totale des consultations par médecin</h2>
<table border="1">
    <tr>
        <th>Médecin</th>
        <th>Durée totale (heures)</th>
    </tr>
    <?php while ($rowStat2 = $stmtStat2->fetch()) : ?>
        <tr>
            <td><?= $rowStat2['NomMédecin'] . ' ' . $rowStat2['PrénomMédecin']; ?></td>
            <td><?= $rowStat2['DuréeTotale']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>


</body>
</html>
