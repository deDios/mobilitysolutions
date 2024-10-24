<?php
// Configuración básica de la página
$title = "Aviso de Privacidad";
$pdf_file = "/DOCS/AP.pdf"; // Cambia la ruta según corresponda
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        iframe {
            width: 100%;
            height: 600px;
            border: none;
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo $title; ?></h1>
    </header>
    
    <main>
        <section>
            <h2>Aviso de Privacidad</h2>
            <iframe src="<?php echo $pdf_file; ?>"></iframe>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mobility Solutions Corporation. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
