CREATE DATABASE interesse_composto;

USE interesse_composto;

CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE previsioni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    investimento DECIMAL(10,2) NOT NULL,
    risparmio DECIMAL(10,2) NOT NULL,
    crescita DECIMAL(5,2) NOT NULL,
    anni INT NOT NULL,
    risultato DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES utenti(id) ON DELETE CASCADE
);