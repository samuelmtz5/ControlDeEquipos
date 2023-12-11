<?php
require_once('../../app/helpers/adminPage.php');
Dashboard_Page::headerTemplate('Iniciar Sesión');
?>

<div class="container">
    <div class="row">
        <!-- Formulario para iniciar sesión -->
        <form method="post" id="session-form">
            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">person_pin</i>
                <input id="usuario" type="text" name="usuario" class="validate" required/>
                <label for="usuario">Usuario</label>
            </div>
            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">security</i>
                <input id="passwrd" type="password" name="passwrd" class="validate" required/>
                <label for="passwrd">Contraseña</label>
            </div>
            <div class="col s12 center-align">
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Ingresar"><i class="material-icons">send</i></button>
            </div>
        </form>
    </div>
</div>

<?php
Dashboard_Page::footerTemplate('index.js');
?>
