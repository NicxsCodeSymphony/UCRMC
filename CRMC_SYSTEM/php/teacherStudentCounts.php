<?php

$conn = new Connection();
$pdo = $conn->openConnection();

$sql = "SELECT COUNT(*) AS totalTeachers FROM teacher";
$stmt = $pdo->query($sql);

if($stmt){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalTeachers = $row['totalTeachers'];
}

$sqlStuds = "SELECT COUNT(*) AS totalStudents FROM student";
$stmtStuds = $pdo->query($sqlStuds);
if($stmtStuds){
    $row = $stmtStuds->fetch(PDO::FETCH_ASSOC);
    $totalStudents = $row['totalStudents'];
}