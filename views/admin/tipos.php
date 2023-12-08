<?php
require_once('../../app/helpers/adminPage.php');
Dashboard_Page::headerTemplate('Tipos de Equipos');
?>

<div class="row">
    <form method="post" id="search-form">
        <div class="input-field col s6 m4">
            <i class="material-icons prefix">search</i>
            <input id="search" type="text" name="search" required/>
            <label for="search">Buscador</label>
        </div>
        <div class="input-field col s6 m4">
            <button type="submit" class="btn waves-effect green tooltipped" data-tooltip="Buscar"><i class="material-icons">check_circle</i></button>
        </div>
    </form>
    <div class="input-field center-align col s12 m4">
        <a href="#" onclick="openCreateDialog()" class="btn waves-effect indigo tooltipped" data-tooltip="Crear"><i class="material-icons">add_circle</i></a>
    </div>
</div>

<table class="responsive-table">
    <thead>
        <tr>
            <th>NOMBRE</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody id="tbody-rows">
    </tbody>
</table>

<div id="save-modal" class="modal">
    <div class="modal-content">
        <h4 id="modal-title" class="center-align"></h4>
        <form method="post" id="save-form" enctype="multipart/form-data">
            <input class="hide" type="number" id="idtipoequipo" name="idtipoequipo"/>
            <div class="row">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">note_add</i>
                    <input id="tipoequipo" type="text" name="tipoequipo" class="validate" required/>
                    <label for="tipoequipo">Nombre</label>
                </div>
            </div>
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>

<?php
Dashboard_Page::footerTemplate('tipos.js');
?>
