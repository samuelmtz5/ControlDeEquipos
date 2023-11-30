/*
Archivo de uso general en las paginas
*/

/*funcion para obtener todos los resultados disponibles en los mantenimientos de tablas */
function readRows(api) {
    fetch(api + 'readAll', {
        method: 'get'
    }).then(function(request) {
        if(request.ok){
            request.json().then(function(response) {
                let data = [];

                if(response.status){
                    data = response.dataset;
                }else{
                    sweetAlert(4, response.exception, null);
                }
                fillTable(data);
            });
        }else{
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function(error) {
        console.log(error)
    });
}

/*Funcion para obtener los resultados de una busqueda en las tablas */
function searchRows(api, form){
    fetch(api + 'search', {
        method: 'post',
        body: new FormData(document.getElementById(form))
    }).then(function (request) {
        if(request.ok){
            request.json().then(function (response) {
                if(response.status){
                    fillTable(response.dataset);
                    sweetAlert(1, response.message, null)
                }else {
                    sweetAlert(2, response.exception, null);
                }
            });
        }else{
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function(error) {
        console.log(error);
    });
}

/*Funcion para crear o actualizar registros en las tablas */
function saveRow(api, action, form, modal) {
    fetch(api + action, {
        method: 'post',
        body: new FormData(document.getElementById(form))
    }).then(function (request) {
        if(request.ok){
            request.json().then(function (response) {
                if(response.status){
                    let instance = M.Modal.getInstance(document.getElementById(modal));
                    instance.close();
                    readRows(api);
                    sweetAlert(1, response.message, null);
                }else{
                    sweetAlert(2, response.exception, null);
                }
            });
        }else{
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

