$document = $(document);

$document.ready(function(){
    // 文件載入完成

    //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    // 導覽列動態底色---已使用html之@yield('regNavActive')取代
    /* $('.nav a').on("click", function(){
        $(".nav").find(".active").removeClass("active");
        $(this).parent().addClass("active");    
    }); */

    // bootstrap 新增按鈕，及按按鈕觸發送出表單功能
    $( "#radioset" ).buttonset().click(function(){
//    $( ".radio-dept" ).click(function(){
            $('#form_dept').submit();   
    });

    //掛號日期預設為之前輸入之日期:因為選擇日期及科別後，網頁會重新載入，掛號日期維持重新載入之前的日期
    var tempDate = $('input[name="registerDate"]').val(); 
    var ryyyy = parseInt(tempDate.substr(0,4));
    var rmm   = parseInt(tempDate.substr(5,2)) - 1;
    var rdd   = parseInt(tempDate.substr(8,2));
    var preDate = new Date(ryyyy,rmm,rdd);    

    // 挑選掛號日期工具，傳送挑選日的週日數
    $( "#reg_date" ).datepicker({
        changeMonth: true,
        changeYear: true,
        maxDate: '+4w',
        minDate: 0,
        dateFormat: 'yyyy-mm-dd',
        //挑選後，將日期轉為 yyyy-mm-dd 格式輸出，並輸出該日週日數
        onSelect: function(dateText, inst){
            var dateP = $(this).datepicker('getDate');
            var day = dateP.getDay();
            //日及月欄位數須為2位
            var dd = (dateP.getDate() < 10 ? '0' : '' ) + dateP.getDate();
            var mm = ((dateP.getMonth() + 1) < 10 ? '0' : '' ) + (dateP.getMonth() + 1);
            var yyyy = dateP.getFullYear();
                date = yyyy + '-' + mm + '-' + dd;
                dDate = dd + '/' + mm + '/' + yyyy;
            $('#showDay').val(day);
            $('#date_input').val(date);
        }
    //維持掛號日期
    }).datepicker('setDate', preDate);
//    });


    $( ".dialogWin" ).dialog({
        modal: true,
        autoOpen: false,
        //width: 400,
        autoSize: true,
        show: 500,
        hide: 500,
/*        buttons: [
            {
                text: "確認掛號",
                click: function() {
                    $( this ).dialog( "close" );
                }
            },
            {
                text: "取消",
                click: function() {
                    $( this ).dialog( "close" );
                }
            }
        ] */
    });

    // 開啟「確認掛號」對話方塊
    $( ".confirmDialog" ).click(function() {
        //將上一個錯誤訊息刪除
        $(".dialog-msg").remove();

        // .confirmDialog標籤中將 dialog-id, birthday_picker, 身份證欄位之id記載於 "data-"欄
        var dialog_id = $(this).data("dialog-id");
        $(dialog_id).dialog( "open" );
        var birthday_picker = $(this).data("birthday-id");
        var id_field = $(this).data("identity-id");
        var register_form = $(this).data("form-id");
        var ajax_button = $(this).data("button-id");

        //從隱藏的input欄位中取得ajax需要的room_info資料表資訊
        var registerDate= $(register_form).find('input[name="confirmDate"]').val();
        var room        = $(register_form).find('input[name="confirmRoom"]').val();
        var am_pm       = $(register_form).find('input[name="confirmAmPm"]').val();
        var doctor      = $(register_form).find('input[name="confirmDoctor"]').val();

        console.log("data=", registerDate, room, am_pm);        

        // 挑選生日日期工具
        $( birthday_picker ).datepicker({
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            minDate: '-120y',
            dateFormat: 'yy-mm-dd',
        }); 

             
        //確認掛號，送出 id 及 birthday 給 laravel 
        //
        $(ajax_button).off('click').click(function(){

            //將上一個錯誤訊息刪除
            $(".dialog-msg").remove();

            var patient_id = $(id_field).val(); 
            var patient_birthday = $(birthday_picker).val();            

            //console.log("date:",registerDate," room:", room, " am_pm:", am_pm);
            var idData = {
                id : patient_id,
                birthday : patient_birthday,
                registerDate : registerDate,
                room : room,
                am_pm : am_pm,
                doctor : doctor
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/ajax',
                type: 'POST',
                data: idData,
                dataType: 'JSON',
                success: function(data) {
                    if(data.status=='success' ){
                        alert(data.msg);
                        $(register_form).submit();
                    }else{
                        var msgHTML = '<div class="dialog-msg">' + data.msg + '</div>';
                        //將錯誤訊息加到birthday欄位的下方
                        $(birthday_picker).parent().append(msgHTML);
                    }
                }// end of success
            });// end of ajax
           
        });//end of ajax-button
        
        return false;
    });// end of confirmDialog

});