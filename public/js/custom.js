$(document).ready(function () {
    $("#button_form").on("click", function(e){
        e.preventDefault();
        var tel = $("#tel").val();
        var check = validateInputPhone(tel);
        var status = "Запрос успешно выполнен!";
        if(check){
            $.ajax({
                url: '/',
                type: 'POST',
                data: {"tel" : check},
                dataType: "json",
                success: function(data){
                    //console.log(data);
                    if(data.country != "" && data.timezone != "") {
                        $(".alert-danger").hide();
                        $(".alert-success").show();
                        $(".alert-success").text(status);
                        $("#result").show();
                        $("#country").text(data.country);
                        $("#timezone").text(data.timezone);
                        if(data.region.length > 0){
                            $("#region_block").show();
                            $("#region").text(data.region);
                        }
                    }else{
                        $(".alert-danger").show();
                        $(".alert-success").hide();
                        $(".alert-danger").text("Вы ввели недействительный номер телефона! Проверьте, пожалуйста, еще раз.")
                    }
                },
                error: function(request, status, error){
                    $(".alert-danger").show();
                    $(".alert-success").hide();
                    $(".alert-danger").text("Ошибка выполнения запроса: "+request.status);
                }
            });
        }else{
            $(".alert-danger").show();
            $(".alert-success").hide();
            $(".alert-danger").text("Номер телефона должен быть минимум 10 цифр!");
        }
    });

    $("body").on("click", function(){
        $(".alert-success").hide();
        $(".alert-danger").hide();
    });

    $("#tel").on("keyup", function(){
        $("#country").text("");
        $("#region").text("");
        $("#timezone").text("");
        $("#result").hide();
    });
});

function validateInputPhone(tel){
    var phone = tel.replace(/[^0-9]/gim,'');
    if(tel.phone < 11){
        return false;
    }else{
        return phone;
    }
}