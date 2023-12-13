const API_CON = '../../app/api/admin/condicion.php?action=';

document.addEventListener('DOMContentLoaded', function () {
    readRows(API_CON);
});

function fillTable(dataset) {
    let content = '';
    dataset.map(function (row) {
        content += `
            <tr>
                <td>${row.condicion}</td>
                <td>
                    <a href="#" onclick="openUpdateDialog(${row.idcondicion})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                    <a href="#" onclick="openDeleteDialog(${row.idcondicion})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                    <a href="../../app/reports/admin/equiposCon.php?id=${row.idcondicion}" target="_blank" class="btn waves-effect amber tooltipped" data-tooltip="Reporte de Equipos"><i class="material-icons">assignment</i></a>
                </td>
            </tr>
        `;
    });
    document.getElementById('tbody-rows').innerHTML = content;
    M.Materialbox.init(document.querySelectorAll('.materialboxed'));
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

document.getElementById('search-form').addEventListener('submit', function (event) {
    event.preventDefault();
    searchRows(API_CON, 'search-form');
});

function openCreateDialog() {
    document.getElementById('save-form').reset();
    let instance = M.Modal.getInstance(document.getElementById('save-modal'));
    instance.open();
    document.getElementById('modal-title').textContent = 'Crear Condición';
}

function openUpdateDialog(id) {
    document.getElementById('save-form').reset();
    let instance = M.Modal.getInstance(document.getElementById('save-modal'));
    instance.open();
    document.getElementById('modal-title').textContent = 'Actualizar Condición';
    const data = new FormData();
    data.append('idcondicion', id);

    fetch(API_CON + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    document.getElementById('idcondicion').value = response.dataset.idcondicion;
                    document.getElementById('condicion').value = response.dataset.condicion;
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

document.getElementById('save-form').addEventListener('submit', function (event) {
    event.preventDefault();
    let action = '';
    (document.getElementById('idcondicion').value) ? action = 'update' : action = 'create';
    saveRow(API_CON, action, 'save-form', 'save-modal');
});

function openDeleteDialog(id) {
    const data = new FormData();
    data.append('idcondicion', id);
    confirmDelete(API_CON, data);
}