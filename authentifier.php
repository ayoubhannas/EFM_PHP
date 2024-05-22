<?php

require_once 'app/Model/Database.php';

if (isset($_POST['auth'])) {

    $isValid = false;
    foreach ($_POST as $key => $value) {
        $isValid = match ($key) {
            'login' => empty($value) ? false : true,
            'password' => empty($value) ? false : true,
            default => true
        };
        if (!$isValid) break;
    }

    if (!$isValid) {
        $error = 'les données d’authentification sont obligatoires';
    } else {
        Database::connect();
        Database::query(
            "SELECT * FROM compteadministrateur WHERE loginAdmin = :login AND motPasse = :password",
            [
                ':login' => $_POST['login'],
                ':password' => $_POST['password']
            ]
        );
        $result = Database::fetch(PDO::FETCH_ASSOC);
        print_r($result);
        if ($result) {
            session_start();
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['nom'] = $result['nom'];
            $_SESSION['prenom'] = $result['prenom'];
            header('Location: ./espaceprivee.php');
            exit;
        } else {
            $error = 'les données d’authentification sont incorrects.';
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
</head>

<body>
    <header>
        <h1>Authentification</h1>
    </header>
    <section>
        <form action="" method="post">
            <span><?= $error ?? '' ?></span>
            <div>
                <label for="login">Login</label>
                <input type="text" name="login" id="login">
            </div>

            <div>
                <label for="password">Mote de pass</label>
                <input type="text" name="password" id="password">
            </div>

            <input type="submit" value="S'authentifier" name="auth">
        </form>
    </section>

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 3fr;
            align-items: center;
            justify-items: center;
            font-family: system-ui;

        }

        header {
            width: 100%;
            height: 100%;
            background: gray;
        }

        header h1 {
            color: lightgray;
            font-size: 4rem;
            text-align: center;
        }

        form {
            display: grid;
            gap: 1rem;
            width: 50rem;
            height: 10rem;
            font-size: 1.2rem;

            span {
                color: red;
            }

            div {
                display: grid;
                gap: .5rem;
            }


            input {
                border: 1px solid gray;
                padding: .5rem 1rem;
            }

            input[type="submit"] {
                background: orangered;
                padding: .7rem 1rem;
                border: 0;
                outline: 0;
                color: #fff;
            }
        }
    </style>
</body>

</html>