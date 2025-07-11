<?php
$dbFile = __DIR__ . '/data.db';

if (!file_exists($dbFile)) {
    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            google_id TEXT UNIQUE,
            name TEXT,
            email TEXT UNIQUE,
            picture TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");
}
