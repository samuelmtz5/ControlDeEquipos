<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/adminPage.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Bienvenido');
?>

<!-- Se muestra un saludo de acuerdo con la hora del cliente -->
<div class="row">
    <h4 class="center-align blue-text" id="greeting"></h4>
</div>

<!-- Se muestran las gráficas de acuerdo con algunos datos disponibles en la base de datos -->


<!-- Importación del archivo para generar gráficas en tiempo real. Para más información https://www.chartjs.org/ -->
<script type="text/javascript" src="../../resources/js/chart.js"></script>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('main.js');
?>
