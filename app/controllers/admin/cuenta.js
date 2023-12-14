const API = '../../app/api/admin/usuarios.php?action=';

function openProfileDialog() {
    let instance = M.Modal.getInstance(document.getElementById('profile-modal'));
    instance.open();

    fetch(API + 'readProfile', {
        method: 'get'
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    document.getElementById('nombres').value = response.dataset.nombres;
                    document.getElementById('apellidos').value = response.dataset.apellidos;
                    document.getElementById('correo').value = response.dataset.correo;
                    document.getElementById('username').value = response.dataset.username;
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

document.getElementById('profile-form').addEventListener('submit', function (event) {
    event.preventDefault();
    fetch(API + 'editProfile', {
        method: 'post',
        body: new FormData(document.getElementById('profile-form'))
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    let instance = M.Modal.getInstance(document.getElementById('profile-modal'));
                    instance.close();
                    sweetAlert(1, response.message, 'main.php');
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
});

function openPasswordDialog() {
    document.getElementById('password-form').reset();
    let instance = M.Modal.getInstance(document.getElementById('password-modal'));
    instance.open();
}

document.getElementById('password-form').addEventListener('submit', function (event) {
    event.preventDefault();

    fetch(API + 'changePassword', {
        method: 'post',
        body: new FormData(document.getElementById('password-form'))
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    let instance = M.Modal.getInstance(document.getElementById('password-modal'));
                    instance.close();
                    sweetAlert(1, response.message, null);
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
});

function logOut() {
    swal({
        title: 'Advertencia',
        text: '¿Quiere cerrar la sesión?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        if (value) {
            fetch(API + 'logOut', {
                method: 'get'
            }).then(function (request) {
                if (request.ok) {
                    request.json().then(function (response) {
                        if (response.status) {
                            sweetAlert(1, response.message, 'index.php');
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
        } else {
            sweetAlert(4, 'Puede continuar con la sesión', null);
        }
    });
}