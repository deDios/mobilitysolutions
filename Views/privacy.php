<?php
// Configuración básica de la página
$title = "Aviso de Privacidad";
$pdf_file = "/DOCS/AP.pdf"; // C
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Opcional: tu CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        iframe {
            width: 100%;
            height: 800px;
            border: none;
        }
    </style>
</head>
<body>
    
    <main>
        <section>
            <h2>Aviso de Privacidad</h2>
            <iframe src="<?php echo $pdf_file; ?>" sandbox="allow-same-origin allow-scripts"></iframe>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Tu Empresa. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
