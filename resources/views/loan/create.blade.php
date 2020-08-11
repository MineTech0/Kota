@extends('layouts.app')
@section('head')
<script src="{{ asset('js/moment.min.js') }}"></script>
@endsection
@section('content')
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
                            <th>Määrä</th>
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
                                <td>{!! $item->quantity == 0 ? '<span
                                    class="badge badge-info">Lainassa</span>' : $item->quantity !!}</td>
                                <td>{{ $item->loan_time == 0 ? 'Ei rajoitettu' : $item->loan_time }}
                                </td>
                                <td>{{ $item->info }}</td>
                                <td><button data-id='{{ $item->id }}' class="btn btn-primary btn-sm addBtn"
                                        {{ $item->quantity == 0 ? 'disabled' : '' }}>Lainaa</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
    <div class="col-md-6">
        <x-panel header='Uusi laina'>
            <form action="{{ route('store.loan') }}" class="form-horizontal" method="POST"
                enctype="multipart/form-data" id="loanForm">
                @csrf
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
                        <div class="table-responsive">
                            <table id="loanList" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nimi</th>
                                        <th>Määrä</th>
                                        <th>Lainapäivä</th>
                                        <th>Palautuspäivä</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="form-row form-group">
                    <div class="col">
                        <label for="description">Kuvaus</label><span style="color:red">*</span>
                        <textarea class="form-control  form-control-lg" name="description" id="description" rows="5"
                            placeholder="Lainauksen syy ja perustelut"
                            value="{{ old('description') }}" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Mihin</label><span style="color:red">*</span>
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
                            <th>Paikka</th>
                            <th>Lainapäivä</th>
                            <th>Viimeinen palautuspäivä</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($own_loans as $loan)
                            <tr>
                                <td>{{ $loan->equipment->name }}
                                    @if($loan->state==0)
                                        <span class="badge badge-primary">Hyväksytty</span>
                                    @elseif($loan->state==1)
                                        <span class="badge badge-info">Odottaa hyväksyntää</span>
                                    @elseif($loan->state==2)
                                        <span class="badge badge-success">Hyväksytty</span>
                                    @else
                                        <span class="badge badge-warning">Ei hyväksytty</span>
                                    @endif



                                </td>
                                <td>{{ $loan->equipment->serial }}</td>
                                <td>{{ $loan->quantity }}</td>
                                <td>{{ $loan->equipment->location }}</td>
                                <td>{{ $loan->loan_date }}</td>
                                <td>{{ $loan->return_date }}</td>
                                <td><button data-id='{{ $loan->id }}' class="btn btn-primary btn-sm openBtn">Avaa
                                        tiedot</button></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
</div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-hidden="true">
    @endsection
    @section('script')
    <script>
        let index = 0;
        $(document).on("click", ".addBtn", function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            $(this).prop('disabled', true);
            $.get("/equipment/available/" + id)
                .done(function (data) {
                    let loanDays = data.loan_time == 0 ? 7 : data.loan_time
                    let Today = moment().format('YYYY-MM-DD');
                    let loanTime = moment().add(loanDays, 'd').format('YYYY-MM-DD')
                    index++
                    $('#loanList > tbody:last-child').append('<tr><td>' + data.name +
                        '</td><td hidden><input name="items[item' + index + '][id]" value="' + data.id +
                        '"/></td><td><input class="form-control quantityInput" name="items[item' +
                        index + '][quantity]" type="text" value="' + data.quantity +
                        '" data-quantity="' + data.quantity + '"data-name="' + data.name +
                        '" data-id="' + data.id +
                        '"></td><td><input class="form-control" type="date" name="items[item' + index +
                        '][loanDate]" id="loanDate" value="' + Today +
                        '"></td><td><input class="form-control" type="date" name="items[item' + index +
                        '][returnDate]" id="returnDate" value="' + loanTime +
                        '" data-time="' + data.loan_time +
                        '"></td><td><a style="cursor:pointer; color:#37a6c4" class="delete" data-id="' +
                        data.id +
                        '">Poista</a></td></tr>');
                    $(this)
                })
                .fail(function (data) {
                    console.log(data);
                });

        });



        $(document).on("click", ".delete", function (e) {
            $(this).closest('tr').remove();
            let id = $(this).data('id');
            $("#loanTable").find("td button[data-id=" + id + "]").prop('disabled', false);
        });

        $(document).on("change", ".quantityInput", function (e) {

            let quantity = $(this).data('quantity');
            let id = $(this).data('id');
            let name = $(this).data('name');
            let value = $(this).val();
            if (value > quantity) {
                $('#info').append('<div class="alert alert-danger" role="alert" data-id="' + id + '">' +
                    quantity + ' on suurin määrä mitä varustetta ' + name + ' voi lainata</div>')
            } else {
                $('#info').find('div[data-id="' + id + '"]').remove();
            }
        });
        $(document).on("change", "#reason", function (e) {
            let value = $(this).val();
            if (value == "Omaan käyttöön") {
                $('button[type=submit]').html('Pyydä lupaa');
            } else {
                $('button[type=submit]').html('Lainaa');
            }
        });
        $('.openBtn').on('click', function (e) {
            $('#infoModal').load('/loan/' + $(e.target).data("id"), function () {
                $('#infoModal').modal({
                    show: true
                });
            });
        });
        $(document).on('click', '.returnBtn', function (e) {
                    let id = $(this).data('id');
                    let message = $(this).data('message');

                    console.log('fired');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                        $.ajax({
                            url: '/loan/' + id,
                            type: 'DELETE',
                            success: function (result) {
                                $('.returnInfo').html(message);
                                $('.returnInfo').addClass('alert-success');
                                $('.returnInfo').show();
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            },
                            error: function (xhr, Status, error) {
                                $('.returnInfo').html(Status);
                                $('.returnInfo').addClass('alert-danger');
                                $('.returnInfo').show();
                            }
                        });
                    });

    </script>
    @endsection
