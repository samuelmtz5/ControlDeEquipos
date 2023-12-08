const API_USUARIOS = '../../app/api/admin/usuarios.php?action=';
const ENDPOINT_TIPOU = '../../app/api/admin/tipousuario.php?action=readAll';
const ENDPOINT_NIVEL = '../../app/api/admin/nivel.php?action=readAll';

document.addEventListener('DOMContentLoaded', function () {
    readRows(API_USUARIOS);
});

function fillTable(dataset) {
    let content = '';
    dataset.map(function (row) {
        content += `
            <tr>
                <td>${row.nombres}</td>
                <td>${row.apellidos}</td>
                <td>${row.correo}</td>
                <td>${row.username}</td>
                <td>${row.tipousuario}</td>
                <td>${row.nivel}</td>
                <td>
                    <a href="#" onclick="openUpdateDialog(${row.idusuario})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                    <a href="#" onclick="openDeleteDialog(${row.idusuario})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;
    });
    document.getElementById('tbody-rows').innerHTML = content;
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

document.getElementById('search-form').addEventListener('submit', function (event) {
    event.preventDefault();
    searchRows(API_USUARIOS, 'search-form');
});

function openCreateDialog() {
    document.getElementById('save-form').reset();
    let instance = M.Modal.getInstance(document.getElementById('save-modal'));
    instance.open();
    document.getElementById('modal-title').textContent = 'Crear usuario';
    document.getElementById('username').disabled = false;
    document.getElementById('passwrd').disabled = false;
    document.getElementById('confirmar_clave').disabled = false;
    fillSelect(ENDPOINT_TIPOU, 'Tipo', null);
    fillSelect(ENDPOINT_NIVEL, 'Nivel', null);
    
}

function openUpdateDialog(id) {
    document.getElementById('save-form').reset();
    let instance = M.Modal.getInstance(document.getElementById('save-modal'));
    instance.open();
    document.getElementById('modal-title').textContent = 'Actualizar usuario';
    document.getElementById('username').disabled = false;
    document.getElementById('passwrd').disabled = false;
    document.getElementById('confirmar_clave').disabled = false;
    const data = new FormData();
    data.append('idUsuario', id);

    fetch(API_USUARIOS + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    document.getElementById('idUsuario').value = response.dataset.idusuario;
                    document.getElementById('nombres').value = response.dataset.nombres;
                    document.getElementById('apellidos').value = response.dataset.apellidos;
                    document.getElementById('correo').value = response.dataset.correo;
                    document.getElementById('username').value = response.dataset.username;
                    fillSelect(ENDPOINT_TIPOU, 'Tipo', response.dataset.idtipousuario);
                    fillSelect(ENDPOINT_NIVEL, 'Nivel', response.dataset.idnivel);
                    document.getElementById('passwrd').disabled = true;
                    document.getElementById('confirmar_clave').disabled = true;
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
    (document.getElementById('idUsuario').value) ? action = 'update' : action = 'create';
    saveRow(API_USUARIOS, action, 'save-form', 'save-modal');
});

function openDeleteDialog(id) {
    const data = new FormData();
    data.append('idUsuario', id);
    confirmDelete(API_USUARIOS, data);
}