<?php

// metrics.php
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM metrics WHERE user_id = ?");
$stmt->execute([$user_id]);
$metrics = $stmt->fetch();
?>