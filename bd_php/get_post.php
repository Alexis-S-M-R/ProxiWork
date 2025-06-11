<?php 
include "db_connect.php";

$sql = "SELECT * FROM post";
$result = mysqli_query($conn, $sql);
// Initialisation d'un tableau pour stocker les résultats
$data = [];

// Itération sur chaque ligne du résultat
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Encodage des résultats en JSON
echo json_encode($data);
