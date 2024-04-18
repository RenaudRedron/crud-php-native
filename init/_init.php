<?php 

// CONNEXION A LA BASE DE DONNEES
$pdo = new PDO(
    'mysql:host=localhost; dbname=crud', // Serveur + nom de la BDD
    'root',  // Identifiant
    'password', // Mot de passe
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // Rapport d'erreurs
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // Forcer l'encodage UTF8
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // définir la key dans les tableaux de récupération (SELECT)
    ]
);

// SESSION ALLUMEE
session_start();

// Variable vide
$notification = '';
$error = '';

?>