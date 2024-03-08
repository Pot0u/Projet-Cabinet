<?php
    include('authentification.php');
    include('header.php')
    // Vérifier si le formulaire a été soumis
    if (isset($_POST['submit'])) {
        $usager_id = $_POST['id'];

        // Supprime l'usager de la base de données
        $sql_delete = "DELETE FROM usager WHERE Id_Usager = :usager_id";
        $stmt_delete = $linkpdo->prepare($sql_delete);
        $stmt_delete->bindParam(':usager_id', $usager_id, PDO::PARAM_INT);
        if ($stmt_delete->execute()) {
            // Rediriger vers la liste des médecins
            header('Location: listeusager.php');
            exit;
        } else {
            echo "<p>Erreur lors de la suppression de l'usager.</p>";
        }
    } else {
        echo "<p>Action non autorisée.</p>";
        echo "<a href='listeusager.php'>Retour à la liste des usagers</a>";
    }
?>
<?php
    // Fermer la connexion PDO
    $linkpdo = null;
?>
