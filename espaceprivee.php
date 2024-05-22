<?php
require_once 'app/Model/Database.php';
require_once './checkAuth.php';




date_default_timezone_set('Africa/casablanca');
$time = date('H');


function getStagiaire() {
    Database::connect();
    Database::query(
        "
        SELECT stagiaire.* ,filiere.intitule FROM stagiaire
        INNER JOIN filiere ON stagiaire.idFiliere = filiere.idFilliere
        ",
        []
    );

    return Database::fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['logout'])) {
    session_destroy();
    setcookie(session_name(), '', time() - 2000, '/');
    header('Location: ./authentifier.php');
}

if (isset($_GET['delete'])) {
    Database::connect();
    Database::query(
        "DELETE FROM stagiaire WHERE idStagiaire = :id ",
        [":id" => $_GET['delete']]
    );

    header('Location: ./espaceprivee.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>espaceprivee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <h1>Espace privé</h1>
        <a href="espaceprivee.php?logout">se deconnecter</a>
    </header>
    <section>
        <h1><?= ($time <= 13 ? 'Bonjour, ' : 'Bonsoir, ') . $_SESSION['nom'] . ' ' . $_SESSION['prenom']; ?></h1>
        <a href="./InsererStagiaire.php">+ ajouter</a><br><br>
        <table border="1">
            <thead>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de naissance</th>
                <th>Photo Profil</th>
                <th>FIliere</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </thead>
            <tbody>
                <?php foreach (getStagiaire() as $stagiare) : ?>
                    <tr>
                        <td><?= $stagiare['nom'] ?></td>
                        <td><?= $stagiare['prenom'] ?></td>
                        <td><?= $stagiare['dateNaissance'] ?></td>
                        <td><?= $stagiare['photoProfil'] ?></td>
                        <td><?= $stagiare['intitule'] ?></td>
                        <td><a href="./ModifierStagiaire.php?id=<?= $stagiare['idStagiaire'] ?>"><i class="bi bi-pen"></i></a></td>
                        <td><a onclick="return confirm()" href="./espaceprivee.php?delete=<?= $stagiare['idStagiaire'] ?>"><i class="bi bi-trash3"></i></a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
    <style>
        body {
            font-family: system-ui;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 3fr;
            justify-items: center;
        }

        header {
            width: 100%;
            height: 70%;
            background: gray;
            color: lightgray;
            text-align: center;
            font-size: 2em;
            letter-spacing: 2px;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }

        header a {
            font-size: 1rem;
            background-color: orangered;
            border-radius: 10px;
            color: white;
            border: none;
            padding: .2rem 1rem;
            text-decoration: none;
        }

        section h1 {
            color: gray;
            font-size: 3em;
            font-weight: 500;
        }

        section>a {
            color: whitesmoke;
            background-color: lightgreen;
            border: none;
            padding: .4rem 1rem;
            border-radius: 10px;
            font-size: 1.2em;
            text-decoration: none;
        }

        table {
            width: 900px;
            background-color: lightgray;
            border-radius: 5px;
        }
    </style>
</body>

</html>