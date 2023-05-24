@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="app">
            <create-expenses-page :infos="{{$expenseInfos}}" :groups="{{$groups}}"/>
        </div>
    </div>
</div>
@endsection