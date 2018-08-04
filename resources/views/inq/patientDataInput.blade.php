<!-- 檔案目錄：resources/views/reg/deptSelect.blade.php -->

<!-- 指定繼承 layout.master 母模板 -->
@extends('layout.master')

<!-- 傳送資料到母模板，並指定變數為 title -->
@section('title', $title)
@section('regNavActive', '')
@section('inqNavActive', 'active')
@section('script')
    <script src="/assets/js/inq_laravel.js" defer></script>
@endsection

<!-- 傳送資料到母模板，並指定變數為 content -->
@section('content')

    <div class="title_container">
        <h3>{{ $title }}</h3>


        <div class="row">
            <div class="col-md-12">


            </div>

            {{-- 僅第一次載入時顯示對話框 --}}
            @if($dialogOpen)
                <div id="dataInputDialog" title="輸入資料以查詢掛號">
                    <form id="dataInput" method="GET" action="/list">
                        <label >身份證字號：</label>
                        <input type="text" id="id_field" class="form-control" name="id" maxlength="10" placeholder="輸入身份證字號" value="{{ old('id', $id) }}">
                        <label >出生年月日：</label>
                        <input type="text" id="birthday_field" class="form-control" name="birthday" placeholder="請點選輸入日期" value="{{ old('birthday', $birthday) }}">
                        
                        {{-- 錯誤訊息模板元件 --}}
                        {{-- @include('components.validationErrorMessage') --}}
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection