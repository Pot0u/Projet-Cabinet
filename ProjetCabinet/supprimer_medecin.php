<?php
    include('authentification.php');
    include('header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $med_id = $_POST['id'];

    // Vérifier si des usagers sont associés à ce médecin
    $check_usagers_sql = "SELECT COUNT(*) as count FROM usager WHERE Id_Médecin = :med_id";
    $stmt_check_usagers = $linkpdo->prepare($check_usagers_sql);
    $stmt_check_usagers->bindParam(':med_id', $med_id, PDO::PARAM_INT);
    $stmt_check_usagers->execute();
    $result = $stmt_check_usagers->fetch(PDO::FETCH_ASSOC);

    //Si existe un usager associés à ce médecin alors impossible de supprimer
    if ($result['count'] > 0) {
        // Des usagers sont associés à ce médecin, afficher un message d'erreur
        echo "<p>Impossible de supprimer le médecin car des usagers sont associés à ce médecin.</p>";
        echo "<a href='listemedecin.php'>Retour à la liste des médecins</a>";
    } else {
        // Supprimer le médecin de la base de données
        $sql_delete = "DELETE FROM médecin WHERE Id_Médecin = :med_id";
        $stmt_delete = $linkpdo->prepare($sql_delete);
        $stmt_delete->bindParam(':med_id', $med_id, PDO::PARAM_INT);
        
        // Exécuter la requête de suppression
        if ($stmt_delete->execute()) {
            // Rediriger vers la liste des médecins
            header('Location: listemedecin.php');
            exit;
        } else {
            echo "<p>Erreur lors de la suppression du médecin.</p>";
        }
    }
} else {
    echo "<p>Action non autorisée.</p>";
    echo "<a href='listemedecin.php'>Retour à la liste des médecins</a>";
}

// Fermer la connexion PDO
$linkpdo = null;
?>
