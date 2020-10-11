var tableVehiculos;

document.addEventListener('DOMContentLoaded', function(){

    tableVehiculos = $('#tableVehiculos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"RegistroVehiculos/getVehiculos",
            "dataSrc":""
        },
        "columns":[ 
            {"data": "placa"},
            {"data": "fk_num_documento"},
            {"data": "fk_id_tp_documento"},
            {"data": "fk_id_tp_vehiculo"},
            {"data": "numero_modelo"},
            {"data": "options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
        
    });

//Nuevo tipo de vehiculo
var formVehiculo = document.querySelector("#formVehiculo");
formVehiculo.onsubmit = function(e) {
    e.preventDefault();
    
    var strIdUsuario = document.querySelector('#idTpVehiculo').value;
    var strNombreVehiculo = document.querySelector('#txtnomTp').value;
    if(strNombreVehiculo == '')
    {
        swal("Atención", "Todos los campos son obligatios." , "error");
        return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'TipoVehiculo/setTipoVehiculo';
    var formData = new FormData(formTipoVehiculo);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                $('#modalFormVehiculo').modal("hide");
                formVehiculo.reset();
                swal("Nuevo Vehiculo", objData.msg ,"success");
                tableVehiculos.api().ajax.reload(function(){
                    //ftnEditTpVehiculo();
                });
            } else {
                swal("Error", objData.msg , "error" );
            }
        }
    }
}
});

$('#tableVehiculos').DataTable();

function openModalVehiculos() {

    /* document.querySelector('#idPlaca').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Vehiculo";
    document.querySelector('#modalFormVehiculo').reset();*/

    $('#modalFormVehiculo').modal('show');
}