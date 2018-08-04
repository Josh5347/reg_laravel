<!-- 檔案目錄：resources/views/reg/deptSelect.blade.php -->

<!-- 指定繼承 layout.master 母模板 -->
@extends('layout.master')

<!-- 傳送資料到母模板，並指定變數為 title -->
@section('title', $title)

<!-- 傳送資料到母模板，並指定變數為 content -->
@section('content')
    <div class="title_container">
        <h3>{{ $title }}</h3>

        {{-- 錯誤訊息模板元件 --}}
        @include('components.validationErrorMessage')

        <div class="row" id="deptSelect">
            <div class="col-md-12">
                <form id="form_dept" action="/deptselect" method="post">
                    <div id=datePickerContainer>
                        <div id="datePickerDiv">    
                            <div id="reg_date">
                                <input name="registerDay" type="hidden" id="showDay">
                                <input name="registerDate" type="text" id="date_input">
                            </div>
                        </div>
                    </div>
                    <div id="radioset">
                        <table class="table table-hover">                          
                            <tbody>
                                <tr>
                                    <td>內科系</td>
                                    <td><input class="radio-dept" type="radio" id="radio1" name="dept" value="內科"><label for="radio1">內　科</label></td>
                                    <td><input class="radio-dept" type="radio" id="radio2" name="dept" value="小兒科"><label for="radio2">小兒科</label></td>
                                </tr>
                                <tr>
                                    <td>外科系</td>
                                    <td><input class="radio-dept" type="radio" id="radio3" name="dept" value="外科"><label for="radio3">外　科</label></td>
                                    <td><input class="radio-dept" type="radio" id="radio4" name="dept" value="復健科"><label for="radio4">復健科</label></td>

                                </tr>
                                <tr>
                                    <td>其他系</td>
                                    <td><input class="radio-dept" type="radio" id="radio5" name="dept" value="中醫科"><label for="radio5">中醫科</label></td>
                                    <td><input class="radio-dept" type="radio" id="radio6" name="dept" value="眼科"><label for="radio6">眼　科</label></td>
                                </tr>
                            </tbody>                           
                        </table>
                    </div>

                    <br/>
                    {{-- CSRF 欄位--}}
                    {{ csrf_field() }}
                </form>
                @if(isset($scheduleTable))
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="dialog-th">{{ $registerDate }}({{ $week_day_c }})&nbsp {{$registerDept}}</th>
                                <th class="dialog-th">診間</th>
                                <th class="dialog-th">醫師</th>
                                <th class="dialog-th">掛號數</th>
                            </tr>
                        </thead>
                        <tbody>            
                            @foreach($scheduleTable as $schedule)
                                <tr> 
                                    <form id="register-form{{++$formNo}}" action="/confirm" method="POST">
                                        <div>
                                            <td>    
                                                @if( $schedule->am_pm == "am" )
                                                    上午
                                                @else
                                                    下午
                                                @endif
                                            </td> 
                                            <td>{{ $schedule->room }}</td> 
                                            <td>{{ $schedule->doctor }}</td> 
                                            <td>
                                                已掛{{$schedule->patient_num}}人
                                                <button class="confirmDialog ui-button ui-corner-all ui-widget" 
                                                    data-dialog-id="#dialog{{$formNo}}" data-birthday-id="#birthday-picker{{$formNo}}" 
                                                    data-identity-id="#id-field{{$formNo}}" data-form-id="#register-form{{$formNo}}"
                                                    data-button-id="#dialog-button{{$formNo}}">
                                                    掛號
                                                </button>

                                            </td> 
                                            <input class="register-date" name="confirmDate" type="hidden" value="{{ $registerDate }}" >
                                            <input class="room"         name="confirmRoom" type="hidden" value="{{ $schedule->room }}" >
                                            <input class="am_pm"        name="confirmAmPm" type="hidden" value="{{ $schedule->am_pm }}" >
                                            <input                      name="confirmDept" type="hidden" value="{{ $registerDept }}" >
                                            <input                      name="confirmPatientNum" type="hidden" value="{{ $schedule->patient_num }}" >                                        
                                            
                                            {{ csrf_field() }}
                                        </div>
                                    </form>

                                    <!--「確認掛號」對話方塊 -->
                                    <div class="dialogWin" id="dialog{{$formNo}}" title="確認掛號">
                                        <div>您掛{{ $registerDate }}({{$week_day_c}})&nbsp
                                            @if( $schedule->am_pm == "am" )
                                                上午
                                            @else
                                                下午
                                            @endif
                                            {{ $registerDept }}&nbsp
                                            醫生：{{ $schedule->doctor }}&nbsp
                                            {{++$schedule->patient_num}}號
                                        </div><br/>
                                        <div>
                                            <div>
                                                <label for="id-field{{$formNo}}">身份證字號：</label>
                                                <input type="text" id="id-field{{$formNo}}" name="id-no" maxlength="10">
                                            </div>
                                            <br/>
                                            <div>
                                                <label for="birthday-picker{{$formNo}}">出生年月日：</label>
                                                <input type="text" id="birthday-picker{{$formNo}}" name="birthday">                      
                                            </div>
                                            <br/>
                                            <div class="dialog-button">
                                                <button id="dialog-button{{$formNo}}" class="button-ajax ui-button ui-corner-all ui-widget">確認掛號</button>
                                            </div>
                                        </div>
                                    </div>                                    
                                </tr>

                            @endforeach 
                                    

                        </tbody>

                    </table>

                @endif
            </div>
        </div>
    </div>
@endsection