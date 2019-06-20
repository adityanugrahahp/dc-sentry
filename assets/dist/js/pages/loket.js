$(document).ready(function () {
    var current_antrian = "000";
	var pre_speak = document.getElementById("inAudio");
    var post_speak = document.getElementById("outAudio");

    $.ajax({
        url: base_url+'Antrian/get_current_handle',
        type: 'POST',
        dataType: 'json',
        data: {id_user: loket_id,id_lokasi :location_id},
        success : function (json) 
        {
            if(json.status=="success")
            {
                var data = json.data;
                current_antrian = data.current_antrian;
                 $("#handle-area").html("<strong>"+data.current_antrian+"</strong>")
            }
        }
    });

    $('#next-antrian-button').on('click', function(event) {
    	event.preventDefault();
    	
    	$.ajax({
    		url: base_url+'Antrian/request_next_handle',
    		type: 'POST',
    		dataType: 'json',
    		data: {id_user: loket_id,id_lokasi :location_id},
    		success : function (json) 
    		{
    			if(json.status=="success")
    			{
    				var data_antri = json.data;
    				current_antrian = data_antri.next_antrian;
    				var split_antrian = current_antrian.split("");
    				var text_speech = "Nomor Antrian,, ";
    				for (var i = 0; i < split_antrian.length; i++) {
    					text_speech= text_speech+split_antrian[i]+",,";
    				}
    				text_speech +=" Silahkan menuju,, "+nama_loket; 
                    
    				if(parseInt(current_antrian)>0)
    				{
    					pre_speak.play();
    					pre_speak.onended = function() {
        					responsiveVoice.speak(
    							text_speech,
    							"Indonesian Female",
    							{
    							pitch: 1,
    							rate: 1,
    							volume: 5,
    							onend: function()
    							{
    								post_speak.play();
    							}
    							}	
    						)	
                        };

                        $("#handle-area").html("<strong>"+current_antrian+"</strong>");
                        cek_status();
    				}
    				
    			}
    		}
    	});
    });

    $("#panggil-ulang-button").on('click', function(event) {
    	event.preventDefault();
    	var split_antrian = current_antrian.split("");
		var text_speech = "Nomor Antrian,, ";
		for (var i = 0; i < split_antrian.length; i++) {
			text_speech= text_speech+split_antrian[i]+", , ,";
		}
		text_speech +="Silahkan menuju,, "+nama_loket; 
		if(parseInt(current_antrian)>0)
		{
			pre_speak.play();
			pre_speak.onended = function() {
			responsiveVoice.speak(
				text_speech,
				"Indonesian Female",
				{
				pitch: 1,
				rate: 1,
				volume: 5,
				onend: function()
				{
					post_speak.play();
				}
				},
				
			)	};
		}
    });

    cek_status();
    var interval = setInterval(cek_status,5000);

    function cek_status() {
        $.ajax({
            url: base_url+'Antrian/get_status_antrian',
            type: 'POST',
            dataType: 'json',
            data: {id_lokasi: location_id},
            success : function(json)
            {
                if(json.status=='success')
                {
                    var data = json.data;
                    $("#current-area").html("<strong>"+data.current_antrian+"</strong>");
                    $("#total-area").html("<strong>"+data.total_antrian+"</strong>");
                    $("#sisa-area").html("<strong>"+data.sisa_antrian+"</strong>");
                    $('.tgl-now').text(moment().format('DD/MM/YYYY'));
                }
            }
        });
    }
});