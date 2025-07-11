<?php
// setup.php - Versão melhorada para deploy no Render

// Configurações do banco de dados
$dbDir = __DIR__ . '/database';
$dbFile = $dbDir . '/data.db';

// Garante que o diretório existe
if (!file_exists($dbDir)) {
    mkdir($dbDir, 0755, true);
}

// Cria ou conecta ao banco SQLite
try {
    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Cria a tabela de usuários
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            google_id TEXT UNIQUE,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            picture TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            last_login DATETIME,
            is_active INTEGER DEFAULT 1
        );
    ");
    
    // Cria tabela de logs de acesso (opcional)
    $db->exec("
        CREATE TABLE IF NOT EXISTS access_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            action TEXT,
            ip_address TEXT,
            user_agent TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(user_id) REFERENCES users(id)
        );
    ");
    
    echo "Banco de dados configurado com sucesso!";
    
} catch (PDOException $e) {
    die("Erro ao configurar o banco de dados: " . $e->getMessage());
}