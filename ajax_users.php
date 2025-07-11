<?php
require_once __DIR__ . '/../setup.php';

$db = new PDO('sqlite:' . __DIR__ . '/../data.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT * FROM users WHERE created_at >= datetime('now', '-30 minutes') ORDER BY created_at DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "<tr>";
    echo "<td><img src='{$user['picture']}' alt='Foto' width='50'></td>";
    echo "<td>" . htmlspecialchars($user['name']) . "</td>";
    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
    echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
    echo "</tr>";
}
