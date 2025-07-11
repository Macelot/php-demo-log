<?php
require_once __DIR__ . '/../setup.php';

$db = new PDO('sqlite:' . __DIR__ . '/../data.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$google_id = $_GET['id'] ?? uniqid();
$name = $_GET['name'] ?? 'Fulano Exemplo';
$email = $_GET['email'] ?? 'exemplo@gmail.com';
$picture = $_GET['picture'] ?? 'https://www.gravatar.com/avatar/' . md5($email);

$stmt = $db->prepare("
    INSERT OR IGNORE INTO users (google_id, name, email, picture)
    VALUES (:google_id, :name, :email, :picture)
");
$stmt->execute([
    ':google_id' => $google_id,
    ':name' => $name,
    ':email' => $email,
    ':picture' => $picture,
]);

header('Location: index.php');
exit;
