const API_AD = '../../app/api/admin/adquisicion.php?action=';

document.addEventListener('DOMContentLoaded', function () {
    readRows(API_AD);
});

function fillTable(dataset) {
    let content = '';
    dataset.map(function (row) {
        content += `
            <tr>
                <td>${row.adquisicion}</td>
                <td>
                    <a href="#" onclick="openUpdateDialog(${row.idadquisicion})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                    <a href="#" onclick="openDeleteDialog(${row.idadquisicion})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                    <a href="../../app/reports/admin/equiposAdq.php?id=${row.idadquisicion}" target="_blank" class="btn waves-effect amber tooltipped" data-tooltip="Reporte de Equipos"><i class="material-icons">assignment</i></a>
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
    searchRows(API_AD, 'search-form');
});

function openCreateDialog() {
    document.getElementById('save-form').reset();
    let instance = M.Modal.getInstance(document.getElementById('save-modal'));
    instance.open();
    document.getElementById('modal-title').textContent = 'Crear Adquisición';
}

function openUpdateDialog(id) {
    document.getElementById('save-form').reset();
    let instance = M.Modal.getInstance(document.getElementById('save-modal'));
    instance.open();
    document.getElementById('modal-title').textContent = 'Actualizar Adquisición';
    const data = new FormData();
    data.append('idadquisicion', id);

    fetch(API_AD + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    document.getElementById('idadquisicion').value = response.dataset.idadquisicion;
                    document.getElementById('adquisicion').value = response.dataset.adquisicion;
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
    (document.getElementById('idadquisicion').value) ? action = 'update' : action = 'create';
    saveRow(API_AD, action, 'save-form', 'save-modal');
});

function openDeleteDialog(id) {
    const data = new FormData();
    data.append('idadquisicion', id);
    confirmDelete(API_AD, data);
}