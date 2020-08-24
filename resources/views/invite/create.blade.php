@extends('layouts.app')
@section('head')
<style>

    .add_field_button {
        margin-bottom: 12px;
    }

    .col-sm-6 {
        margin-bottom: 12px;
    }

    .remove_field {
        font-size: 15px;
    }

    .col-sm-2 {
        padding-top: 1rem;
    }

</style>    
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <h2>Uusi kutsu</h2>
                <x-panel header='Kutsu uusia'>
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <form method="post" class="form-horizontal" action="{{route('store.invite')}}" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Käyttäjät<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <button class="btn btn-primary add_field_button">Lisää rivi</button>
                                <div class="input_fields_wrap">
                                    <div class="row cont">
                                        <div class="col-sm-6">
                                        <input type="text" name="emails[]" class="form-control" value="{{old('emails.0')}}">
                                        </div>
                                        <div class="col-sm-2"></div>
                                    </div>
                                    @if(old())
                                    @foreach (old('emails') as $key => $item)
                                        @if ($key>0)
                                        <div class="row cont">
                                            <div class="col-sm-6">
                                                <input type="text" name="emails[]"/ class="form-control" value="{{$item}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="#" class="remove_field">Poista</a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button class="btn btn-primary" name="submit" type="submit">Lähetä</button>
                            </div>
                        </div>

                    </form>
                </x-panel>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <x-panel header='Lähetetyt kutsut'>
                    <div class="table-responsive">
                    <table id='clist' class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sähköposti</th>
                            <th>Päivämäärä</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invites as $index => $invite)
                        <tr> 
                            <td>{{$index +1}}</td>
                            <td>{{$invite->email}}</td>
                            <td>{{$invite->created_at->diffForHumans()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                </x-panel>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {

        //input fields
        var max_fields = 10; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="row cont"><div class="col-sm-6"><input type="text" name="emails[]"/ class="form-control"></div><div class="col-sm-2"><a href="#" class="remove_field">Poista</a></div></div>'); //add input box
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
            e.preventDefault();
            $(this).parents('.cont').remove();
            x--;
        })



    });

</script>
@endsection