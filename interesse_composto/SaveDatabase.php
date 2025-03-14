<?php
session_start();
header("Content-Type: text/plain");

echo "SaveDatabase.php è stato chiamato.\n";

// Debug: Mostra i dati ricevuti
var_dump($_POST);

if (!isset($_POST["investimento"], $_POST["risparmio"], $_POST["crescita"], $_POST["anni"], $_POST["risultato"])) {
    die("Errore: Dati mancanti.");
}

// Connessione al database
$host = "localhost";
$dbname = "interesse_composto";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Errore di connessione: " . $conn->connect_error);
}

// Prepara l'istruzione SQL per inserire i dati
$stmt = $conn->prepare("INSERT INTO previsioni (investimento, risparmio, crescita, anni, risultato, user_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ddddsi", $_POST["investimento"], $_POST["risparmio"], $_POST["crescita"], $_POST["anni"], $_POST["risultato"], $_SESSION["user_id"]);

if ($stmt->execute()) {
    echo "Dati salvati con successo!";
} else {
    echo "Errore nel salvataggio: " . $stmt->error;
}

// Chiude la connessione
$stmt->close();
$conn->close();
?>
