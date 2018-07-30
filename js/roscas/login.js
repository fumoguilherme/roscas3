/**
 * Created by TechJonas on 07/23/2018.
 */
$(function () {


    $(document).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $('#bt_login').click();
        }
    });

    $('#bt_login').on('click', function () {

        var username = $('#username').val();
        var password = $('#password').val();


        if(username.length === 0 || password.length === 0){
            alert("Preencha os campos");
        }else {


            $.ajax({
                type: 'POST', //Or 'GET',
                url: ip+"php/controller/login/login.php?username=" + username + "&password=" + password + "&tipo_usuario=Tecnico",
                success: function (data) {

                    var result = JSON.parse(data);
                 
                    if (result.estado === 'sucesso') {

                        window.location.href = 'menu.html';

                    } else if (result.estado === 'erro') {
                        alert("Combinacao incorrecta");
                    } else {
                        alert("Ocorreu um erro inexperado");

                    }

                    return false;
                },
                error: function () {

                    alert("ocorreu um erro");

                    return false;
                }
            });


        }
    });


});


