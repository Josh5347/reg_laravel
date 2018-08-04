$document = $(document);

$document.ready(function(){
    

    // 文件載入完成
    $('#inqNavBar').click(function(){
        $( "#dataInputDialog" ).dialog( "open" );
    });
        $( "#dataInputDialog" ).dialog({
            modal: true,
            //autoOpen: true,
            //width: 400,
            autoSize: true,
            //hide: 500,
            buttons: [
                {
                    text: "確認",
                    class: "confirmButton",
                    click: function() {
                        var patient_id = $(id_field).val(); 
                        var patient_birthday = $(birthday_field).val();            
            
                        console.log("id:",patient_id,"birthday:",patient_birthday);
                        var idData = {
                            id : patient_id,
                            birthday : patient_birthday
                        };
                        //$( this ).dialog( "close" );
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/validation',
                            type: 'GET',
                            data: idData,
                            dataType: 'JSON',
                            success: function(data) {
                                
                                //將上次執行的訊息移除
                                $('.alert').remove();

                                // 若有錯誤訊息
                                //console.log(data);
                                if (data.length != 0){

                                    //將錯誤訊息以 bootstrap alert 方式加入網頁
                                    alertHTML =  '<div class="alert alert-warning" role="alert">';
                                    alertHTML += '<ul>';
                                    //data為物件型態，不能使用obj.forEach()
                                    $.each(data,function(index, err){
                                        alertHTML += '<li>';
                                        alertHTML +=  err;
                                        alertHTML += '</li>';
                                    });
                                    alertHTML += '</ul>';
                                    alertHTML += '</div>';
                                    var $jHTML = $(alertHTML);
                                    $('#dataInput').append($jHTML);
                                }
                                //console.log(data.length);
                            }// end of success
                        });// end of ajax
                        //$('#dataInput').submit();
                    }
                },
                {
                    text: "清除",
                    class: "clearButton",
                    click: function() {
                        $('#birthday_field').val("");
                        $('#id_field').val("");

                    }
                }
            ]
        });// end dialog 

        // 挑選生日日期工具
        $('#birthday_field').datepicker({
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            minDate: '-120y',
            dateFormat: 'yy-mm-dd',
        }); //end datepicker


});