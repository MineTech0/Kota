@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <x-panel header="Muokkaa tiedotetta">
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
            <div class="form-group mb-3">
                <label class="col-sm-2 control-label" for="NoteSelect">Tiedote:</label>
                <div class="col-sm-4">
                    <select class="custom-select" name="NoteSelect" id="NoteSelect">
                        <option selected>Valitse</option>
                        @foreach($notes as $note)
                            <option value="{{ $note->id }}">{{ $note->heading }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr />
            <div class="row">
  
                <div class="col-md-12">
                    <form id="noteForm"method="post" action="/notes" class="form-horizontal" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Otsikko<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ old('title') }}" required></input>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kuvaus<span style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="description" name="description"
                                    value="{{ old('description') }}" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button class="btn btn-primary" name="submit" type="submit">Tallenna</button>
                                <button class="btn btn-danger ml-4" name="delete"  type="button" id="delete">Poista</button>
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
    $(document).on('change', '#NoteSelect', function (e) {
        let id = $(this).val();
        if(id=='Valitse'){
            $('#title').val('');
            $('#description').val('');
        }
        else{
            $.get("notes/"+id+'/edit', function (data, status) {
                $("#noteForm").attr('action', 'notes/'+id);
                $('#title').val(data.heading);
                $('#description').val(data.text);
            });    
        }
    });
    $(document).on('click', '#delete', function (e) {
                    let id = $('#NoteSelect').val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                        $.ajax({
                            url: '/notes/'+ id,
                            type: 'DELETE',
                            success: function (result) {
                                $('.delInfo').html('Poistettu');
                                $('.delInfo').addClass('alert-success');
                                $('.delInfo').show();
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            },
                            error: function (xhr, Status, error) {
                                const json = JSON.parse(xhr.responseText);
                                $('.delInfo').html(json.error);
                                $('.delInfo').addClass('alert-danger');
                                $('.delInfo').show();
                            }
                        });
                    });

</script>
@endsection
