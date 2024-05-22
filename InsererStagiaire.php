<?php

require_once 'app/Model/Database.php';

require_once './checkAuth.php';


function filiere() {
    Database::connect();
    Database::query(
        "SELECT idFilliere, intitule FROM filiere",
        []
    );

    return Database::fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['ajouter'])) {
    $targetFile =  './images/' . $_FILES['profil']['name'];
    move_uploaded_file($_FILES['profil']['tmp_name'], $targetFile);

    Database::connect();
    Database::query(
        "
        INSERT INTO stagiaire (nom,prenom,dateNaissance,photoProfil,idFiliere)
        VALUES (:nom,:prenom,:date,:photoProfil,:idFiliere)
        ",
        [
            ':nom' => $_POST['nom'],
            ':prenom' => $_POST['prenom'],
            ':date' => $_POST['date'],
            ':photoProfil' => $_FILES['profil']['name'],
            ':idFiliere' => $_POST['filiere']
        ]
    );
    header('Location: ./espaceprivee.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <section>
        <button id="retour" class="fa-solid fa-arrow-left"> Retour</button>
        <h1>ajouter un stagiaire</h1>
        <p>veuilez remlir tous les champs</p>
        <form method="post" enctype="multipart/form-data">
            <label for="nom">NOM</label><br>
            <input type="text" name="nom" id="nom"><BR></BR>
            <label for="prenom">PRENOM</label><br>
            <input type="text" name="prenom" id="prenom"><BR></BR>
            <label for="date">DATE NAISSANCE</label><br>
            <input type="date" name="date" id="date"><BR></BR>
            <label for="profil">PHOTO PROFIL</label><br>
            <input type="file" name="profil"><BR></BR>
            <label for="filiere">FILIERE</label><br>
            <select name="filiere" id="filiere">
                <?php foreach (filiere() as $value) : ?>
                    <option value="<?= $value['idFilliere'] ?>"><?= $value['intitule'] ?></option>
                <?php endforeach ?>
            </select><BR></BR>
            <input type="submit" name="ajouter" value="ajouter">


        </form>
    </section>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            display: flex;
            font-family: system-ui;
            justify-content: center;
            align-content: center;
            height: 100vh;
        }

        section {
            background-color: gainsboro;
            height: 65vh;
            width: 60%;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20vh;
            box-shadow: rgb(135, 135, 135) 10px 10px 300px;
        }

        #retour {
            color: rgb(0, 205, 0);
            background-color: gainsboro;
            border: none;
        }

        form input {
            border: 1px solid gray;
            outline: 0;
            width: 100%;
            height: 25px;
            background-color: rgb(226, 226, 226);
        }

        form select {
            width: 100%;
            height: 25px;
            background-color: rgb(226, 226, 226);
        }

        #file {
            border: 1px solid black;
            padding: 1px;
        }

        input[type="submit"] {
            height: 30px;
            width: 100%;
            border-radius: 5px;
            background-color: rgb(0, 205, 0);
            color: white;
            font-size: 1.1em;
            border: none;
        }
    </style>
</body>

</html>