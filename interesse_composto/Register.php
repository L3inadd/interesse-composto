<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost';
    $dbname = 'interesse_composto';
    $username = 'root';
    $password = '';
    
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }
    
    $email = $_POST['email'];
    $password_input = $_POST['password'];
    
    // Nuova regex che accetta anche simboli
    $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+={}|:;,.<>?~`-]{8,}$/";
    
    // Debug: stampa la password inserita per vedere cosa arriva
    //echo "Password inserita: " . $password_input . "<br>";
    
    if (!preg_match($password_pattern, $password_input)) {
        echo "La password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola e un numero.";
        exit();
    }
    
    // Creazione dell'hash della password
    $password_hash = password_hash($password_input, PASSWORD_DEFAULT);
    
    // Inserimento dei dati nel database
    $stmt = $conn->prepare("INSERT INTO utenti (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password_hash);
    
    if ($stmt->execute()) {
        echo "Registrazione completata con successo!";
    } else {
        echo "Errore nella registrazione: " . $stmt->error;
    }
    
    // Chiusura delle risorse
    $stmt->close();
    $conn->close();
    exit();
}
?>


<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Registrazione</title>
</head>
<body>
  <h2>Registrazione</h2>
  <form method="POST" action="register.php">
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Registrati</button>
  </form>
  <p>Hai già un account? <a href="login.php">Accedi qui</a></p>
</body>
</html>
