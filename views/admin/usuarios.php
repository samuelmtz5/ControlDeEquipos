<?php
require_once('../../app/helpers/adminPage.php');
Dashboard_Page::headerTemplate('Usuarios');
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

<table class="highlight centered responsive-table">
    <thead>
        <tr>
            <th>NOMBRES</th>
            <th>APELLIDOS</th>
            <th>CORREO</th>
            <th>USUARIO</th>
            <th>TIPO</th>
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
            <input class="hide" type="number" id="idUsuario" name="idUsuario"/>
            <div class="row">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="nombres" type="text" name="nombres" class="validate" maxlength="20" required/>
                    <label for="nombres">Nombres</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="apellidos" type="text" name="apellidos" class="validate" maxlength="20" required/>
                    <label for="apellidos">Apellidos</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">email</i>
                    <input id="correo" type="email" name="correo" class="validate" maxlength="50" required/>
                    <label for="correo">Correo</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">contact_mail</i>
                    <input id="username" type="text" name="username" class="validate" maxlength="10" required/>
                    <label for="username">Usuario</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">supervisor_account</i>
                    <select id="Tipo" name="Tipo">
                    </select>
                    <label>Tipo</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">school</i>
                    <select id="Nivel" name="Nivel">
                    </select>
                    <label>Nivel</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">security</i>
                    <input id="passwrd" type="password" name="passwrd" class="validate" maxlength="50" required/>
                    <label for="passwrd">Clave</label>
                </div>
                <div class="input-field col s12 m6">
                    <i id="iconopass" class="material-icons prefix">security</i>
                    <input id="confirmar_clave" type="password" name="confirmar_clave" class="validate" maxlength="50" required/>
                    <label id="label" for="confirmar_clave">Confirmar clave</label>
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
Dashboard_Page::footerTemplate('usuarios.js');
?>