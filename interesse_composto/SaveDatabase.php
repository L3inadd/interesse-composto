<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Devi effettuare il login per salvare i dati.");
}

$host = 'localhost';
$dbname = 'interesse_composto';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Stampa dei dati POST per il debug
var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $investimento = $_POST['investimento'];
    $risparmio = $_POST['risparmio'];
    $crescita = $_POST['crescita'];
    $anni = $_POST['anni'];
    $risultato = $_POST['risultato'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO previsioni (user_id, investimento, risparmio, crescita, anni, risultato) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Verifica che i parametri siano corretti
    if ($stmt === false) {
        die('Errore nella preparazione della query: ' . $conn->error);
    }

    // Associazione dei parametri
    $stmt->bind_param("idddis", $user_id, $investimento, $risparmio, $crescita, $anni, $risultato);

    if ($stmt->execute()) {
        echo "Dati salvati con successo!";
    } else {
        echo "Errore nel salvataggio: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
