// Constantes para establecer las rutas y parámetros de comunicación con la API.
const API_EQUIPOS = '../../app/api/admin/equipos.php?action=';
const ENDPOINT_TIPO = '../../app/api/admin/tipos.php?action=readAll';
const ENDPOINT_ADQ = '../../app/api/admin/adquisicion.php?action=readAll';
const ENDPOINT_CON = '../../app/api/admin/condicion.php?action=readAll';
const ENDPOINT_ENCAR = '../../app/api/admin/usuarios.php?action=readAll';
const ENDPOINT_NIVEL = '../../app/api/admin/nivel.php?action=readAll';
const ENDPOINT_MARCA = '../../app/api/admin/marca.php?action=readAll';
// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows(API_EQUIPOS);
});

// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
                <td>${row.nombremarca}</td>
                <td>${row.modelo}</td>
                <td>${row.serie}</td>
                <td>${row.activo}</td>
                <td>${row.tipoequipo}</td>
                <td>${row.adquisicion}</td>
                <td>${row.condicion}</td>
                <td>${row.nombres}</td>
                <td>${row.nivel}</td>
                <td>
                    <a href="#" onclick="openUpdateDialog(${row.idequipo})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                    <a href="#" onclick="openDeleteDialog(${row.idequipo})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows').innerHTML = content;
    // Se inicializa el componente Material Box asignado a las imagenes para que funcione el efecto Lightbox.
    M.Materialbox.init(document.querySelectorAll('.materialboxed'));
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('search-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda. Se encuentra en el archivo components.js
    searchRows(API_EQUIPOS, 'search-form');
});

// Función para preparar el formulario al momento de insertar un registro.
function openCreateDialog() {
    // Se restauran los elementos del formulario.
    document.getElementById('save-form').reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    let instance = M.Modal.getInstance(document.getElementById('save-modal'));
    instance.open();
    // Se asigna el título para la caja de dialogo (modal).
    document.getElementById('modal-title').textContent = 'Crear Equipo';
    // Se establece el campo de archivo como obligatorio.
    fillSelect(ENDPOINT_MARCA, 'Marca', null);
    fillSelect(ENDPOINT_TIPO, 'Tipo', null);
    fillSelect(ENDPOINT_ADQ, 'Adquisicion', null);
    fillSelect(ENDPOINT_CON, 'Condicion', null);
    fillSelect(ENDPOINT_ENCAR, 'Encargado', null);
    fillSelect(ENDPOINT_NIVEL, 'Nivel', null);
}

// Función para preparar el formulario al momento de modificar un registro.
function openUpdateDialog(id) {
    // Se restauran los elementos del formulario.
    document.getElementById('save-form').reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    let instance = M.Modal.getInstance(document.getElementById('save-modal'));
    instance.open();
    // Se asigna el título para la caja de dialogo (modal).
    document.getElementById('modal-title').textContent = 'Actualizar Equipo';
    // Se establece el campo de archivo como opcional.

    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('idEquipo', id);

    fetch(API_EQUIPOS + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del registro seleccionado.
                    document.getElementById('idEquipo').value = response.dataset.idequipo;
                    document.getElementById('Modelo').value = response.dataset.modelo;
                    document.getElementById('Serie').value = response.dataset.serie;
                    document.getElementById('Activo').value = response.dataset.activo;
                    fillSelect(ENDPOINT_MARCA, 'Marca', response.dataset.idmarca);
                    fillSelect(ENDPOINT_TIPO, 'Tipo', response.dataset.idtipoequipo);
                    fillSelect(ENDPOINT_ADQ, 'Adquisicion', response.dataset.idadquisicion);
                    fillSelect(ENDPOINT_CON, 'Condicion', response.dataset.idcondicion);
                    fillSelect(ENDPOINT_ENCAR, 'Encargado', response.dataset.idusuario);
                    fillSelect(ENDPOINT_NIVEL, 'Nivel', response.dataset.idnivel);
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();
                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de guardar.
document.getElementById('save-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se define una variable para establecer la acción a realizar en la API.
    let action = '';
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('idEquipo').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_EQUIPOS, action, 'save-form', 'save-modal');
});

// Función para establecer el registro a eliminar y abrir una caja de dialogo de confirmación.
function openDeleteDialog(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('idEquipo', id);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete(API_EQUIPOS, data);
}