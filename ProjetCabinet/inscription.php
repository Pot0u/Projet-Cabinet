<?php
    // Connexion à la base de données
    include('bd.php');

    // Vérifier si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les informations du formulaire
        $username = htmlspecialchars($_POST["username"]);
        $motDePasse = $_POST["motDePasse"];

        // Vérifier si le nom d'utilisateur et le mot de passe sont non vides
        if (!empty($username) && !empty($motDePasse)) {
            // Hacher le mot de passe
            $motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);

            try {
                // Vérifier si l'utilisateur existe déjà
                $requete = $linkpdo->prepare("SELECT username FROM utilisateur WHERE username = :username");
                $requete->bindParam(':username', $username);
                $requete->execute();
                $resultat = $requete->fetch(PDO::FETCH_ASSOC);

                if (!$resultat) {
                    // Insérer le nouvel utilisateur dans la base de données
                    $requeteInsert = $linkpdo->prepare("INSERT INTO utilisateur (username, password) VALUES (:username, :password)");
                    $requeteInsert->bindParam(':username', $username);
                    $requeteInsert->bindParam(':password', $motDePasseHache);
                    $requeteInsert->execute();

                    echo "Inscription réussie !";
                } else {
                    echo "Ce nom d'utilisateur est déjà pris.";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            echo "Veuillez saisir un nom d'utilisateur et un mot de passe.";
        }
    }
    // Fermer la connexion PDO
    $linkpdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    
    <form method="post" action="">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>

        <label for="motDePasse">Mot de passe:</label>
        <input type="password" id="motDePasse" name="motDePasse" required>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà un compte ? <a href="connexion.php">Connectez-vous ici</a>.</p>
</body>
</html>
