<?php
require_once('../../app/helpers/adminPage.php');
Dashboard_Page::headerTemplate('Bienvenido');
?>
<div class="row">
    <h4 class="center-align blue-text" id="greeting"></h4>
</div>

<style>
    #imageninicio{
        @media (min-width: 100%) {
            width: 55%;
            height: 55%;
        }
    }
</style>

<center>
    <img id="imageninicio" class="imageninicio" src="../../resources/img/fondoinicio.png" height="100%" width="100%">
</center>



<?php
Dashboard_Page::footerTemplate('main.js');
?>
