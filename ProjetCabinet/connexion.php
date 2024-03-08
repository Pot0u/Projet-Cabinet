<?php
session_start();
// Connexion à la bd
include('bd.php');
// Vérifier si l'utilisateur n'est pas connecté
if (isset($_SESSION['username'])) {
    // Rediriger vers la dernière page visitée (ou une page par défaut si aucune n'est stockée)
    $lastPage = isset($_SESSION['last_page']) ? $_SESSION['last_page'] : 'listeusager.php';
    header("Location: $lastPage");
    exit;
}
// Initialiser les variables
$messageErreur = '';
$encadrerUsername = '';
$encadrerMotDePasse = '';
// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations du formulaire
    $username = htmlspecialchars($_POST["username"]);
    $motDePasse = $_POST["motDePasse"];

    // Assurez-vous que le nom d'utilisateur et le mot de passe sont non vides
    if (!empty($username) && !empty($motDePasse)) {
        // Vérifier si l'utilisateur existe
        $requete = $linkpdo->prepare("SELECT username, password FROM utilisateur WHERE username = :username");
        $requete->bindParam(':username', $username);
        $requete->execute();
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);

        if ($resultat) {
            // Vérifier le mot de passe (dehash le mdp)
            if (password_verify($motDePasse, $resultat['password'])) {
                $_SESSION['username'] = $username;
                // Rediriger vers la dernière page visitée (ou une page par défaut si aucune n'est stockée)
                $lastPage = isset($_SESSION['last_page']) ? $_SESSION['last_page'] : 'listeusager.php';
                header("Location: $lastPage");
                exit;
            } else {
                // Mot de passe non valide
                $messageErreur = 'Mot de passe incorrect.';
                $encadrerMotDePasse = 'style="border: 1px solid red;"';
            }
        } else {
            // Utilisateur non trouvé
            $messageErreur = 'Nom d\'utilisateur non trouvé.';
            $encadrerUsername = 'style="border: 1px solid red;"';
        }
    } else {
        // Nom d'utilisateur ou mot de passe manquant
        $messageErreur = 'Veuillez saisir un nom d\'utilisateur et un mot de passe.';
        $encadrerUsername = 'style="border: 1px solid red;"';
        $encadrerMotDePasse = 'style="border: 1px solid red;"';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="testcon.css">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
<div class='container'>
    <form method="post" action="">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required <?php echo $encadrerUsername; ?>>

        <label for="motDePasse">Mot de passe:</label>
        <input type="password" id="motDePasse" name="motDePasse" required <?php echo $encadrerMotDePasse; ?>>

        <button type="submit">Se connecter</button>
    </form>

    <p style="color: red;"><?php echo $messageErreur; ?></p>

    <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>
</div>
</body>
</html>

<?php
    // Fermer la connexion PDO
    $linkpdo = null;
?>