@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <x-panel header="Ryhmät">
            <div class="table-responsive">
                <table id="clist" class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Nimi</th>
                            <th>Johtajat</th>
                            <th>Kokouspäivä</th>
                            <th>Aika</th>
                            <th>Kokoontuu</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td>{{ $group->name }}</td>
                                <td>{!! str_replace(',', '<br />', $group->leaders) !!}
                                </td>
                                <td>{{ $group->day }}</td>
                                <td>{{ date('H:i',strtotime($group->time)) }}</td>
                                <td>{{ $group->repeat }}</td>
                                <td>
                                    @if ($group->contact)
                                    <button data-id='{{$group->id}}' class="btn btn-primary btn-sm contactBtn">Ota yhteyttä</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
</div>
<div class="modal fade" id="contactModal" aria-hidden="true"></div>
@endsection
@section('script')
    <script>
       $(document).on('click', '.contactBtn', function (e) {
        $('#contactModal').load('/contact/group/'+$(this).data("id")
        ,function (responseText, textStatus, req) {
            if(textStatus != 'error'){
                $('#contactModal').modal({
                    show: true
                });
            }
        });
    });
    </script>
    
@endsection
