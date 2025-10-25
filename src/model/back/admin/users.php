<?php

function fetchAllUsers()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users WHERE role != 'admin'   ORDER BY id DESC");
    $users = $stmt->fetchAll();
    echo json_encode($users);
}
