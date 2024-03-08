<?php
include('authentification.php');
include('header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $rdv_id = $_POST['id'];

    // Supprimer le rendez-vous de la base de données
    $sql_delete = "DELETE FROM rdv WHERE Id_RDV = :rdv_id";
    $stmt_delete = $linkpdo->prepare($sql_delete);
    $stmt_delete->bindParam(':rdv_id', $rdv_id, PDO::PARAM_INT);
    
    // Exécuter la requête de suppression
    if ($stmt_delete->execute()) {
        // Rediriger vers la liste des rendez-vous
        header('Location: listerdv.php');
        exit;
    } else {
        echo "<p>Erreur lors de la suppression du rendez-vous.</p>";
    }
} else {
    echo "<p>Action non autorisée.</p>";
    echo "<a href='listerdv.php'>Retour à la liste des rendez-vous</a>";
}

// Fermer la connexion PDO
$linkpdo = null;
?>
