<?php
function connect()
{
    $host = 'localhost';
    $dbname = 'reservation_terrain';
    $username = 'root';
    $password = '';

    // DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$dbname";

    // Options de connexion
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Création de l'instance PDO
    try {
        $pdo = new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }

    return $pdo;
}
function connection()
{

}
?>