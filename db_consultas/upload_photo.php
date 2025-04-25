<?php
// upload_photo.php

header('Content-Type: application/json');

$targetDir = "../Imagenes/Usuarios/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['profilePic']) && isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];
        $imageFile = $_FILES['profilePic'];

        // Validar que sea una imagen
        $check = getimagesize($imageFile["tmp_name"]);
        if ($check === false) {
            echo json_encode(["success" => false, "message" => "El archivo no es una imagen válida."]);
            exit;
        }

        // Crear ruta de destino con el nombre del user_id
        $targetFile = $targetDir . basename($userId) . ".jpg";

        // Mover archivo al destino
        if (move_uploaded_file($imageFile["tmp_name"], $targetFile)) {
            //echo json_encode(["success" => true, "message" => "Imagen subida correctamente."]);
        } else {
            //echo json_encode(["success" => false, "message" => "Error al mover la imagen."]);
        }
    } else {
        //echo json_encode(["success" => false, "message" => "Faltan datos necesarios."]);
    }
} else {
    //echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

header("Location: https://mobilitysolutionscorp.com/Views/Home.php", TRUE, 303);
exit();
?>
