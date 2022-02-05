@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <x-panel header="Uusi ryhmää">
            <div class="alert delInfo" style="display: none"></div>
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-warning" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row">

                <div class="col-md-12">
                    <form id="groupForm" method="post"
                        action="{{ route('store.group') }}" class="form-horizontal"
                        enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nimi:<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="group_name" id="GroupName" class="form-control"
                                    required></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kokouspäivä:<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="MeetingDaySelect" name="meeting_day">
                                    @foreach($weekDays as $day)
                                        <option value="{{ $day }}">{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kokous alkaa:<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                            <input type="time" class="form-control" name="meeting_start" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kokous loppuu:<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                            <input type="time" class="form-control" name="meeting_end">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kokoontuu:<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" name="repeat">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ikäryhmä:<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" name="age">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Johtajat:<span style="color:red">*</span></label>
                            <button class="btn btn-primary add_field_button">Lisää johtaja</button>

                            <div class="col-sm-4" id='LeaderListWrapper'>
                                <div class="mb-2">
                                    <input type="text" name="leader_list[]" id="leader_list" class="form-control">
                                </div>
                            </div>
                            <small class="text-muted pl-3">
                                Jos haluat poistaa johtajan jätä kenttä tyhjäksi
                              </small>

                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-1">
                                    <button class="btn btn-primary" name="submit" type="submit">Luo</button>
                                </div>
                                
                              
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </x-panel>
    </div>
</div>
@endsection
@section('script')
<script>
    var wrapper = $("#LeaderListWrapper"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    $(add_button).click(function (e) { //on add input button click
        e.preventDefault();
        $(wrapper).append(
            '<div class="mb-2"><input type="text" name="leader_list[]" id="leader_list" class="form-control"></input></div>'
            ); //add input box
    });

</script>
@endsection
