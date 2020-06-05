$(document).ready(function(){
	$('#Daftar').submit(function(e) {
		e.preventDefault()
        var data = $(this).serialize()
        var method = $(this).attr('method')
        var action = $(this).attr('action')
        $.ajax({
        	url: action,
            data: data,
            method: method,
            beforeSend: function() {

            },
            success: function(data) {
                $("#myAlert").show();
                $('#formhide').hide();
            }
        });
	});
});



$(document).ready(function () {
	// datetimepicker initialization
    $(".datepicker").datetimepicker({ format: 'MM-DD-YYYY' });
});

$(function(){
	$(".rad").click(function(){
		$("#form1, #form2").hide()
        if($(this).val() == "1"){
            $("#form1").show();
        }else{
            $("#form2").show();
        }
	});
});

$(function(){
	$(".radstatus").click(function(){
		$("#formstatus1, #formstatus2").hide()
        if($(this).val() == "1"){
            $("#formstatus1").show();
        }else{
            $("#formstatus2").show();
        }
	});
});

$(function(){
	$(".radperjalanan").click(function(){
		$("#formperjalanan1, #formperjalanan2").hide()
        if($(this).val() == "1"){
            $("#formperjalanan1").show();
        }else{
            $("#formperjalanan2").show();
        }
	});
});