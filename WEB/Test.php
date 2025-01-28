<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Orden</title>
</head>
<body>
    <form action="https://mobilitysolutionscorp.com/WEB/cobrar_orden.php" method="POST">
        <input type="hidden" name="id_cliente" value=1>
        <input type="hidden" name="nombre_cliente" value="Cristina Alejandra Arellano Luna">
        <input type="hidden" name="total_cuenta" value="100.0">

        <!-- Producto 1 -->
        <input type="hidden" name="productos[0][folio]" value="CE7ED8D0-9D2B-4450-AAAE-97BD67294B14">
        <input type="hidden" name="productos[0][id_producto]" value=1>
        <input type="hidden" name="productos[0][producto]" value="Cappuccino / Latte ch">
        <input type="hidden" name="productos[0][cantidad]" value=1>
        <input type="hidden" name="productos[0][precio_unitario]" value=45.00>
        <input type="hidden" name="productos[0][total]" value=45.00>
        <input type="hidden" name="productos[0][fecha]" value="2025-01-28 01:02:41">

        <!-- Producto 2 -->
        <input type="hidden" name="productos[1][folio]" value="CE7ED8D0-9D2B-4450-AAAE-97BD67294B14">
        <input type="hidden" name="productos[1][id_producto]" value=2>
        <input type="hidden" name="productos[1][producto]" value="Postre - Chesse cake">
        <input type="hidden" name="productos[1][cantidad]" value=1>
        <input type="hidden" name="productos[1][precio_unitario]" value=55.00>
        <input type="hidden" name="productos[1][total]" value=55.00>
        <input type="hidden" name="productos[1][fecha]" value="2025-01-28 01:02:41">

        <button type="submit">Enviar Orden</button>
    </form>
</body>
</html>
