<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parque</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos CSS adicionales */
        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: none;
            width: 50px;
            height: 50px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 40px;
            height: 40px;
            background-color: transparent;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(49, 49, 49, 0.5);
            border-radius: 50%;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
        }
    </style>
</head>

<body class="custom-bg">
    <!-- Header -->
    <header class="header py-3 shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <h1 class="h3 mb-0">Parque</h1>
                </div>
                <div class="col-lg-3 text-end">
                    @if (Route::has('login'))
                    <nav class="nav justify-content-end">
                        @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary me-2">
                            Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                            Log in
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Register
                        </a>
                        @endif
                        @endauth
                    </nav>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container mt-5">
            <h1 class="text-center mb-5">Parque Temático</h1>
            <div class="row mb-3">
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" onclick="getComentariosByRating()">Comentarios por Calificación</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" onclick="getComentariosCountByAtraccion()">Cantidad de Comentarios por Atracción</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" onclick="getAtraccionesByEspecie()">Atracciones por Especie</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" onclick="getAvgRatingByEspecie()">Calificación Promedio por Especie</button>
                </div>
            </div>
            <div id="results">
                <!-- Resultados se mostrarán aquí -->
            </div>
        </div>
    </main>

    <footer class="footer py-5 shadow-sm mt-5">
        <div class="container">
            <div class="text-center mt-4">
                <p>&copy; ....</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- jQuery (required for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Axios para peticiones AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function getComentariosByRating() {
            let minRating = prompt("Ingrese la calificación mínima:");
            let maxRating = prompt("Ingrese la calificación máxima:");
            axios.get(`/comentarios/rating/${minRating}/${maxRating}`)
                .then(response => {
                    displayResults(response.data, 'Comentarios por Calificación', ['nombre_usuario', 'detalles']);
                })
                .catch(error => console.error(error));
        }

        function getComentariosCountByAtraccion() {
            let atraccionId = prompt("Ingrese el ID de la Atracción:");
            axios.get(`/comentarios/count/${atraccionId}`)
                .then(response => {
                    displayResults([response.data], 'Cantidad de Comentarios por Atracción', ['cantidad']);
                })
                .catch(error => console.error(error));
        }

        function getAtraccionesByEspecie() {
            let especieId = prompt("Ingrese el ID de la Especie:");
            axios.get(`/atracciones/especie/${especieId}`)
                .then(response => {
                    // Verifica la estructura de response.data
                    console.log('Atracciones por Especie:', response.data);
                    displayResults(response.data, 'Atracciones por Especie', ['titulo', 'descripcion']);
                })
                .catch(error => console.error(error));
        }

        function getAvgRatingByEspecie() {
            let especieId = prompt("Ingrese el ID de la Especie:");
            axios.get(`/atracciones/avgRating/${especieId}`)
                .then(response => {
                    // Verifica la estructura de response.data
                    console.log('Calificación Promedio por Especie:', response.data);
                    // Solo un objeto de respuesta, así que usamos un array con ese objeto
                    displayResults([response.data], 'Calificación Promedio por Especie', ['avgRating']);
                })
                .catch(error => console.error(error));
        }

        function displayResults(data, title, fields) {
            let html = `<h2>${title}</h2>`;
            if (Array.isArray(data)) {
                if (data.length > 0) {
                    html += `<table class="table table-bordered"><thead><tr>`;
                    fields.forEach(field => {
                        html += `<th>${field}</th>`;
                    });
                    html += `</tr></thead><tbody>`;
                    data.forEach(item => {
                        html += `<tr>`;
                        fields.forEach(field => {
                            html += `<td>${item[field] !== undefined ? item[field] : ''}</td>`; // Muestra una cadena vacía si el campo no está definido
                        });
                        html += `</tr>`;
                    });
                    html += `</tbody></table>`;
                } else {
                    html += `<p>No hay datos disponibles.</p>`;
                }
            } else {
                html += `<p>${JSON.stringify(data)}</p>`; 
            }
            document.getElementById('results').innerHTML = html;
        }
    </script>
</body>

</html>