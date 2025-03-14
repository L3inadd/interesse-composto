<?php
session_start();
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
    
    $stmt = $conn->prepare("SELECT id, password FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password_input, $hashed_password)) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $id;
            echo "Login effettuato con successo!";
        } else {
            echo "Password errata.";
        }
    } else {
        echo "Utente non trovato.";
    }
    $stmt->close();
    $conn->close();
    exit();
  }
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h2>Login</h2>
  <form method="POST" action="login.php">
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Accedi</button>
  </form>
  <p>Non hai un account? <a href="register.php">Registrati qui</a></p>
</body>
</html>
