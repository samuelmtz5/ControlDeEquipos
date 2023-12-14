<?php
require_once('../../app/helpers/adminPage.php');
Dashboard_Page::headerTemplate('Bienvenido');
?>
<div class="row">
    <h4 class="center-align blue-text" id="greeting"></h4>
</div>

<div class="row">
    <div class="col s12 m6">
        <canvas id="chart1"></canvas>
    </div>
    <div class="col s12 m6">
        <canvas id="chart2"></canvas>
    </div>
</div>
<script type="text/javascript" src="../../resources/js/chart.js"></script>

<?php
Dashboard_Page::footerTemplate('main.js');
?>
