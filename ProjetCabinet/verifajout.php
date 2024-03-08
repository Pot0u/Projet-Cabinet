<!DOCTYPE html>
<head>
    <title>verification</title>
</head>
<body>
<?php
    include('authentification.php');

    if (isset($_POST['choix']) || $_POST['choix'] == 0) {
        if (!empty($_POST['choixciv']) && !empty($_POST['nom_saisi']) && !empty($_POST['prenom_saisi']) 
            && !empty($_POST['adresse_saisi']) && !empty($_POST['lieunaiss_saisi']) 
            && !empty($_POST['numsecu_saisi']) && !empty($_POST['date_naissance']) || $_POST['choix'] == 0){

            //Récupération des paramètres du formulaire
            $choix = $_POST['choixciv'];
            $nom = $_POST['nom_saisi'];
            $prenom = $_POST['prenom_saisi'];
            $adresse = $_POST['adresse_saisi'];
            $lieu_nai = $_POST['lieunaiss_saisi'];
            $date_nai = $_POST['date_naissance'];
            $num_sécu = $_POST['numsecu_saisi'];
            $med = $_POST['choix'];
            $id = 0;

            //Select le id disponible suivant
            $res = $linkpdo->query('SELECT u.* FROM usager u');
            while ($data = $res->fetch()) {
                $idtemp = $id;
                $id = $data['Id_Usager'];
                if($id - $idtemp > 1){
                    $id = $idtemp;
                }
            }
            $id += 1;
            
            $contactBOOL = true;
            //retourne true si le contact saisie est déjà présent dans la BDD
            $res = $linkpdo->query('SELECT * FROM usager');
            while ($data = $res->fetch()) {
                if($choix == $data['Civilité'] && $nom == $data['Nom'] && $prenom == $data['Prenom'] && $adresse == $data['Adresse_complète']
                && $lieu_nai == $data['Lieu_de_naissance'] && $date_nai == $data['Date_de_naissance'] && $num_sécu == $data['Num_Sécu']){
                    $contactBOOL = false;
                }
            }

            //Intégration dans la BDD si il n'est pas présent dans la BDD
            if($contactBOOL) {
                $req = $linkpdo->query("INSERT INTO usager (Id_Usager, Civilité, Nom, Prenom, Adresse_complète, Lieu_de_naissance, Date_de_naissance, Num_Sécu, Id_Médecin)
                VALUES ('$id', '$choix', '$nom', '$prenom', '$adresse', '$lieu_nai', '$date_nai', $num_sécu, $med)");
                $res->execute();
                echo 'Le contact a bien été ajouté à la base de donnée.';
            }
            else {
                echo 'Le contact est déjà présent dans la base de donnée.';
            }
        } else {
            echo "Veuillez remplir toute les informations. Merci au revoir !";
        }
        //Fermer la connexion
        $linkpdo = null;
    } else {
        echo "Le médecin n'a pas était sélectionné.";
    }   
?></body></html>
