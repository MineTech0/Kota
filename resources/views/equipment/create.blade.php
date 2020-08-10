@extends('layouts.app')
@section('head')
    <script src="{{asset('js/moment.min.js')}}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <x-panel header='Varusteet'>
            <div class="table-responsive">
                <table id='loanTable' class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Nimi</th>
                            <th>Sarjanumero</th>
                            <th>Kunto</th>
                            <th>Laina-aika</th>
                            <th>Tiedot</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipment as $index => $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->serial }}</td>
                                <td>{{ $item->form }}</td>
                                <td>{{ $item->loan_time == 0 ? 'Ei rajoitettu' : $item->loan_time }}</td>
                                <td>{{ $item->info }}</td>
                                <td><button data-id='{{$item->id}}' class="btn btn-primary btn-sm addBtn">Lainaa</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
    <div class="col-md-6">
        <x-panel header='Uusi laina'>
            <form action="{{ route('store.equipment') }}" class="form-horizontal" method="POST"
                enctype="multipart/form-data" id="loanForm">
                <div class="form-row form-group">
                    <div class="col-md-3">
                        <label for="heading">Lainaaja</label><span style="color:red">*</span>
                        <input type="text" name="loaner" id="loaner" class="form-control form-control-lg"
                            value="{{ Auth::user()->name }}" required readonly>
                    </div>
                </div>
                <div class="form-row form-group">
                    <div class="col">
                        <label for="loanList">Lainat</label>
                        <table id="loanList" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nimi</th>
                                    <th>Määrä</th>
                                    <th>Laina päivä</th>
                                    <th>Palautus päivä</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="form-row form-group">
                    <div class="col">
                        <label for="description">Kuvaus</label><span style="color:red">*</span>
                        <textarea class="form-control  form-control-lg" name="description" id="description" rows="5" placeholder="Lainauksen syy ja perustelut"
                            value="{{ old('description') }}" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Mihin</label>
                    <select class="form-control" name="reason" id="reason">
                        <option>Partio tapahtumaan</option>
                        <option>Omaan käyttöön</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg ">Lainaa</button>
                </div>

            </form>
            <div id="info">  
            </div>
        </x-panel>
    </div>
</div>
<div class="row mt-5">
    <div class="col-md-6">
        <x-panel header='Omat lainat'>
            <div class="table-responsive">
                <table id='OwnLoansTable' class="display table table-striped table-bordered table-hover" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Nimi</th>
                            <th>Sarjanumero</th>
                            <th>Määrä</th>
                            <th>Laina päivä</th>
                            <th>Palautus päivä</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>niger</td>
                                <td>#NG01</td>
                                <td>1</td>
                                <td>dd.mm.yyyy</td>
                                <td>dd.mm.yyyy</td>
                                <td><button data-id='' class="btn btn-primary btn-sm addBtn">Avaa tiedot</button></td>
                            </tr>
                       
                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
</div>
<form action="{{ route('store.equipment') }}" method="POST" enctype="multipart/form-data" id="realLoanForm" hidden>
    @csrf
    <input type="text" name="loaner" value="{{ Auth::id() }}">
</form>
@endsection
@section('script')
<script>

    $(document).on("click", ".addBtn", function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $(this).prop('disabled', true);
    $.get( "/equipment/"+id )
                .done(function( data ) {
                        console.log(data);
                        let loanDays = data.loan_time == 0 ? 7 : data.loan_time 
                        let Today = moment().format('YYYY-MM-DD');
                        let loanTime = moment().add(loanDays, 'd').format('YYYY-MM-DD')
                        $('#loanList > tbody:last-child').append('<tr><td>'+data.name+'</td><td hidden id="id"value="'+data.id+'"></td><td><input class="form-control quantityInput" type="text" value="'+data.quantity+'" data-quantity="'+data.quantity+'"data-name="'+data.name+'" data-id="'+data.id+'"></td><td><input class="form-control" type="date" name="loanDate" id="loanDate" value="'+Today+'"></td><td><input class="form-control" type="date" name="returnDate" value="'+loanTime+'" data-time="'+data.loan_time+'"></td><td><a style="cursor:pointer; color:#37a6c4" class="delete" data-id="'+data.id+'">Poista</a></td></tr>');
                        $(this)
                    })
                .fail(function( data ) {
                    console.log(data);
                });

    });
                
            

    $(document).on("click", ".delete", function (e) {
                $(this).closest('tr').remove();
                let id = $(this).data('id');
                $("#loanTable").find("td button[data-id="+id+"]").prop('disabled', false);
            });

    $(document).on("change", ".quantityInput", function (e) {
                
                let quantity = $(this).data('quantity');
                let id = $(this).data('id');
                let name = $(this).data('name');
                let value = $(this).val();
                if(value > quantity){
                    console.log('activated');
                    $('#info').append('<div class="alert alert-danger" role="alert" data-id="'+id+'">'+quantity+' on suurin määrä mitä varustetta '+name+' voi lainata</div>')
                }
                else {
                    $('#info').find('div[data-id="'+id+'"]').remove();
                }
            });
    $(document).on("change", "#reason", function (e) {
                let value = $(this).val();
                if (value =="Omaan käyttöön"){
                    $('button[type=submit]').html('Pyydä lupaa');
                }
                else{
                    $('button[type=submit]').html('Lainaa');
                }
            });
    $('#loanForm').on('submit', function(e) { 
        e.preventDefault();
        $('#loanList > tbody > tr').each(function(i){
            $('#realLoanForm').append('<input name="item['+i+']" value="'+id+'"/>');
        })
        

    });
</script>
@endsection
