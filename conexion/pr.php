<?php
include "tabla.php"


?>
<body>
    <div class="container">
        <h2 class="title">Módulo Reportes</h2>
        <div class="field">
            <div class="control">
                <label for="start-date">Fecha de inicio:</label>
                <input class="input" type="date" id="start-date">
            </div>
        </div>
        <div class="field">
            <div class="control">
                <label for="end-date">Fecha de fin:</label>
                <input class="input" type="date" id="end-date">
            </div>
        </div>
        <button class="button" onclick="searchByDate()">Buscar</button>
    </div>
    <div id="tabla-container"></div>
</body>
</html>
