<?php
require_once('../../app/helpers/adminPage.php');
Dashboard_Page::headerTemplate('Equipos');
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
        <a href="../../app/reports/admin/equipos.php" target="_blank" class="btn waves-effect amber tooltipped" data-tooltip="Reporte de Equipos por Tipo"><i class="material-icons">assignment</i></a>
    </div>
</div>

<table class="highlight centered responsive-table">
    <thead>
        <tr>
            <th>MARCA</th>
            <th>MODELO</th>
            <th>SERIE</th>
            <th>ACTIVO</th>
            <th>TIPO</th>
            <th>ADQUISICION</th>
            <th>CONDICION</th>
            <th>ENCARGADO</th>
            <th>NIVEL</th>
            <th class="actions-column">ACCIONES</th>
        </tr>
    </thead>
    <tbody id="tbody-rows">
    </tbody>
</table>

<div id="save-modal" class="modal">
    <div class="modal-content">
        <h4 id="modal-title" class="center-align"></h4>
        <form method="post" id="save-form">
            <input class="hide" type="number" id="idEquipo" name="idEquipo"/>
            <div class="row">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">copyright</i>
                    <select id="Marca" name="Marca">
                    </select>
                    <label>Marca</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">important_devices</i>
                    <input id="Modelo" type="text" name="Modelo" class="validate" maxlength="30" required/>
                    <label for="Modelo">Modelo</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">short_text</i>
                    <input id="Serie" type="text" name="Serie" class="validate" maxlength="10" required/>
                    <label for="Serie">Serie</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">short_text</i>
                    <input id="Activo" type="text" name="Activo" class="validate" maxlength="6" required/>
                    <label for="Activo">Activo</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">phonelink</i>
                    <select id="Tipo" name="Tipo">
                    </select>
                    <label>Tipo</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">shopping_cart</i>
                    <select id="Adquisicion" name="Adquisicion">
                    </select>
                    <label>Adquisición</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">build</i>
                    <select id="Condicion" name="Condicion">
                    </select>
                    <label>Condición</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">contact_mail</i>
                    <select id="Encargado" name="Encargado">
                    </select>
                    <label>Encargado</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">school</i>
                    <select id="Nivel" name="Nivel">
                    </select>
                    <label>Nivel</label>
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
Dashboard_Page::footerTemplate('equipo.js');
?>