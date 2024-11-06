<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Carros</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Usamos jQuery para facilitar el AJAX -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        /* Reset de estilos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        h1 {
            color: #4CAF50;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        label {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        select:focus, input[type="number"]:focus {
            outline: none;
            border-color: #4CAF50;
        }

        option {
            font-size: 1rem;
            padding: 10px;
        }

        /* Botones */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            font-size: 1.1rem;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Estilos para los selectores múltiples */
        select[multiple] {
            height: 150px;
            padding: 10px;
        }

        /* Estilos para los campos de precio */
        input[type="number"] {
            width: 49%;
            display: inline-block;
            margin-right: 2%;
        }

        input[type="number"]:last-child {
            margin-right: 0;
        }

        /* Flex container for horizontal price inputs */
        .price-container {
            display: flex;
            justify-content: space-between;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                width: 90%;
            }
        }
    </style>
    <script>
        // Función para actualizar los selectores con las opciones recibidas por AJAX
        function actualizarSelect(id, opciones) {
            const select = document.getElementById(id);
            select.innerHTML = ''; // Limpiar opciones anteriores
            opciones.forEach(opcion => {
                let option = document.createElement('option');
                option.value = opcion;
                option.textContent = opcion;
                select.appendChild(option);
            });
        }

        // Función para filtrar y actualizar los selectores según la selección del usuario
        function filtrar() {
            const marca = document.getElementById('marcas').value;
            const modelo = document.getElementById('modelos').value;
            const color = document.getElementById('colores').value;
            const anio = document.getElementById('anio').value;
            const transmision = document.getElementById('transmision').value;
            const interior = document.getElementById('interior').value;

            // Realizar la solicitud AJAX para actualizar los filtros dependientes
            $.ajax({
                url: 'actualizar_filtros.php', // El archivo que procesará las solicitudes AJAX
                type: 'GET',
                data: {
                    marca: marca,
                    modelo: modelo,
                    color: color,
                    anio: anio,
                    transmision: transmision,
                    interior: interior
                },
                success: function(response) {
                    // Parsear la respuesta JSON que contiene los datos filtrados
                    const data = JSON.parse(response);
                    if (data.modelos) {
                        actualizarSelect('modelos', data.modelos);
                    }
                    if (data.colores) {
                        actualizarSelect('colores', data.colores);
                    }
                    if (data.anios) {
                        actualizarSelect('anio', data.anios);
                    }
                    if (data.transmisiones) {
                        actualizarSelect('transmision', data.transmisiones);
                    }
                    if (data.interiores) {
                        actualizarSelect('interior', data.interiores);
                    }
                }
            });
        }
    </script>
</head>
<body>
    <h1>Buscador de Carros</h1>

    <form method="GET" action="buscar_carro.php">
        <label for="marcas">Selecciona las marcas:</label>
        <select name="marcas[]" id="marcas" multiple onchange="filtrar()">
            <option value="Toyota">Toyota</option>
            <option value="Honda">Honda</option>
            <option value="Ford">Ford</option>
            <option value="Chevrolet">Chevrolet</option>
            <option value="BMW">BMW</option>
        </select>
        <br><br>

        <label for="modelos">Selecciona los modelos:</label>
        <select name="modelos[]" id="modelos" multiple onchange="filtrar()">
            <!-- Los modelos se actualizarán aquí -->
        </select>
        <br><br>

        <label for="colores">Selecciona los colores:</label>
        <select name="colores[]" id="colores" multiple onchange="filtrar()">
            <!-- Los colores se actualizarán aquí -->
        </select>
        <br><br>

        <label for="anio">Selecciona el año:</label>
        <select name="anio" id="anio" onchange="filtrar()">
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
        </select>
        <br><br>

        <label for="transmision">Selecciona la transmisión:</label>
        <select name="transmision" id="transmision" onchange="filtrar()">
            <option value="Automática">Automática</option>
            <option value="Manual">Manual</option>
        </select>
        <br><br>

        <label for="interior">Selecciona el tipo de interior:</label>
        <select name="interior" id="interior" onchange="filtrar()">
            <option value="Piel">Piel</option>
            <option value="Tela">Tela</option>
        </select>
        <br><br>

        <label for="precio_min">Precio mínimo:</label>
        <input type="number" name="precio_min" id="precio_min" step="0.01">
        <br><br>

        <label for="precio_max">Precio máximo:</label>
        <input type="number" name="precio_max" id="precio_max" step="0.01">
        <br><br>

        <label for="localidad">Localidad:</label>
        <select name="localidad" id="localidad">
            <option value="Madrid">Madrid</option>
            <option value="Barcelona">Barcelona</option>
            <option value="Valencia">Valencia</option>
            <option value="Sevilla">Sevilla</option>
            <option value="Zaragoza">Zaragoza</option>
        </select>
        <br><br>

        <input type="submit" value="Buscar">
    </form>
</body>
</html>
