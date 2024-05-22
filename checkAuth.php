<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ./authentifier.php');
    exit;
}
