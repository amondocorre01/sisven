window.angularApp.controller("AsignPricesController", [
    "$scope",
    "API_URL",
    "window",
    "jQuery",
    "$http",
    "EmailModal",
function (
    $scope,
    API_URL,
    window,
    $,
    $http,
    EmailModal
) {
    //"use strict";
    console.log('hey aqui estoy.');
    console.log('arra',arrayForSave);
    fillArrayForSave();

    function fillArrayForSave(){
        let idUser = getUserSelected();
        if(idUser){
            datos = {};
            datos.userSelected = idUser;
            datos.action_type = 'GETPRICESSUSER';
            datos.datos = arrayForSave;
            actionUrl = 'acciones.php';
            const options = {
                method: 'POST',
                url: window.baseUrl + "/_inc/" + actionUrl,
                headers: {
                'Content-Type': 'application/json',
                },
                data: datos
            };
            
            axios.request(options).then(function (response) {
                console.log('respuesta',response);
            }).catch(function (error) {
                console.error(error);
            });
        }
    }

    $(document).delegate("#savePricesUser", "click", function(e) {
        let user = $('#user').val();
        if(user.trim() == ''){
            window.swal('Aviso','Seleccione un usuario.',"error");
            return;
        }
        let resultadoArr = arrayForSave.filter(column => column.prices.length === 1);
        if(resultadoArr.length > 0){
            window.swal('Aviso','Verifique los datos de la tabla, No puede haber un solo precio seleccionado en cada fila.',"error");
            return;
        }
        var datos = new FormData();
        datos.append("user",user);
        datos.append("action_type",'SAVEPRICESUSER');
        datos.append("datos",arrayForSave);
        datos = {};
        datos.user = user;
        datos.action_type = 'SAVEPRICESUSER';
        datos.datos = arrayForSave;

        actionUrl = 'acciones.php';

        const options = {
            method: 'POST',
            url: window.baseUrl + "/_inc/" + actionUrl,
            headers: {
              'Content-Type': 'application/json',
            },
            data: datos
          };
          
          axios.request(options).then(function (response) {
            var alertMsg = response.data.msg;
            window.toastr.success(alertMsg, "Success!");
          }).catch(function (error) {
            console.error(error);
          });
    });
    
    $(document).delegate("#searchUserPrices", "click", function(e) {
        console.log('ssdddd');
        let user = $('#user').val();
        if(user.trim() == ''){
          window.swal('Aviso','Seleccione un usuario.',"error");
          return;
        }
        window.location.href = 'asign_prices.php?user='+user;
      });

}]);