var tableRoles;

document.addEventListener('DOMContentLoaded', function(){

    tableRoles = $('#tableRoles').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"RolesUsuarios/getRoles",
            "dataSrc":""
        },
        "columns":[ 
            {"data": "id_rol"},
            {"data": "nombre_rol"},
            {"data": "descripcion"},
            {"data": "status"},
            {"data": "options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
        
    });

//Nuevo tipo de vehiculo
var formRoles = document.querySelector("#formRoles");
formRoles.onsubmit = function(r) {
    r.preventDefault();

    var strNombre = document.querySelector('#txtNombre').value;
    var strDescripcion = document.querySelector('#txtDescripcion').value;
    var intStatus = document.querySelector('#listStatus').value;

    if(strNombre == '' || strDescripcion == '' || intStatus == '')
    {
        swal("Atención", "Todos los campos son obligatios." , "error");
        return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'RolesUsuarios/setRolesUsuario';
    var formData = new FormData(formRoles);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                $('#modalFormRoles').modal("hide");
                formRoles.reset();
                swal("Nuevo Vehiculo", objData.msg ,"success");
                tableRoles.api().ajax.reload(function(){
                    //ftnEditTpVehiculo();
                });
            } else {
                swal("Error", objData.msg , "error" );
            }
        }
    }
}
});
function openModalRoles(){

    /*document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector('#formUsuario').reset();*/

    $('#modalFormRoles').modal('show');
}