<?php
$servername = "localhost:3307"; // ou votre adresse de serveur
$username = "root"; // votre nom d'utilisateur
$password = ""; // votre mot de passe
$dbname = "test"; // le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
