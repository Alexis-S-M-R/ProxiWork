<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";

if (isset($_POST['title']) && isset($_POST['adress']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['type'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

    $title = $_POST['title'];
    $adress = $_POST['adress'];
    $description = $_POST['description'];
    $price = validate($_POST['price']);
	$type = validate($_POST['type']);
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $uploadFile = " ";

    if (isset($_FILES['image'])) {

        // Vérifier s'il y a une erreur lors du téléchargement
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo "Erreur lors du téléchargement du fichier : " . $_FILES['image']['error'];
            exit();
        }
    
        $target_dir = "../assets/img/";
        $file_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
    
        // Vérifier si le fichier existe déjà
        if (file_exists($target_file)) {
            echo "Désolé, un fichier avec le même nom existe déjà.";
            exit();
        }
    
        // Vérifier si l'image est bien un fichier image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
    
            // Limiter la taille du fichier (par exemple, 5 Mo)
            if ($_FILES["image"]["size"] > 5000000) {
                echo "Désolé, le fichier est trop volumineux.";
                exit();
            } else {
                // Enregistrer l'image
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "Le fichier " . htmlspecialchars($file_name) . " a été téléchargé avec succès.";
                    $uploadFile = $target_file;  // Définir le chemin du fichier pour la base de données
                } else {
                    echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
                    exit();
                }
            }
        } else {
            echo "Le fichier téléchargé n'est pas une image.";
            exit();
        }
    } else {
        echo "Aucun fichier n'a été téléchargé.";
        exit();
    }
    


  // Préparer la requête SQL
    $stmt = $conn->prepare("INSERT INTO post (user_id, adress, description, image_path, Type, titre, longitude, latitude, price) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Vérifier si la préparation a réussi
    if ($stmt) {
    $path =  substr($uploadFile, 1);
    $des =  htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    // Insérer $description dans la base de données
    
    // Lier les paramètres à la requête
    $stmt->bind_param('ssssssddi', $_SESSION['id'], $adress, $des, $path, $type, $title, $longitude, $latitude, $price);

    if ($stmt->execute()) {
        echo "Annonce posté avec succès";
        header("../home.php");
        exit();

    } else {
        echo "Erreur lors de l'insertion : " . $stmt->error;
        exit();

    }
    $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
        exit();

    }


}else{
    echo "errzeur";
    exit();

}
