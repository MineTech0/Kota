@extends('layouts.app')
@section('head')
<script src="{{ asset('js/moment.min.js') }}"></script>
<style>
</style>
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
    <div class="col-md-12">
        
            <x-panel header="Ohjeet">
                <p>Tammipartion varusteita voidaan lainata aktiivisille johtajille, joko partiotapahtumaan tai omaan käyttöön. 
                    Varusteita lainatessa pitää ottaa huomioon, että palauttaa varusteen hyvässä kunnossa takaisin eli käytännössä sellaisessa kunnossa kuin ne olivat lainatessa.
                </p>
                <div class="alert alert-info">
                    <a href="{{$guide_url}}" target="_blank">Katso pappilan ohje lainaamisesta</a>
                  </div>
                <div class="row">
                    
                    <div class="col-md-5">
                        <h2 class="pb-2">Lainaaminen:</h2>
                        <div class="alert alert-light">
                          1. Valitse haluamasi varusteet osion <a href="#equipment">Varusteet</a> listasta. Paina nappia lainaa.
                        </div>
                        <div class="alert alert-light">
                          2. Valitsemasi varusteet ilmestyvät osion <a href="#newLoan">Uusi laina</a> listaan. Valitse haluamasi lainapäivä, palautuspäivä ja määrä.
                        </div>
                        <div class="alert alert-light">
                          3. Kirjoita kuvaus lainasta. Esimerkiksi miksi lainaat ja mihin.
                        </div>
                        <div class="alert alert-light">
                          4. Valitse lainan tyyppi kohdasta "Mihin".
                        </div>
                        <div class="alert alert-light">
                          5. Jos lomake ei ilmoita virheista, voit lähettää lainahakemuksen painamalla nappia "Lainaa".
                        </div>
                        <div class="alert alert-light">
                          6. Lainaamasi varusteet näkyvät osiosta <a href="#ownLoans">Omat lainat</a>. Sieltä voit tarkistaa onko laina hyväksytty ja missä varustetta säilytetään. <b>Muista tarkistaa varustetta hakiessasi, että lainaamasi varusteen sarjanumero on sama kuin lainahakemuksessa.</b> 
                        </div>
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-5">
                        <h2 class="pb-2">Palautus:</h2>
                        <div class="alert alert-light">
                          1. Mene kohtaa <a href="#ownLoans">Omat lainat</a> ja paina "Avaa tiedot".
                        </div>
                        <div class="alert alert-light">
                          2. Näytölle avautuu ikkuna, jossa on tietoa lainasta.
                        </div>
                        <div class="alert alert-light">
                          3. Palauttaaksesi varusteen paina "Palauta" nappia.
                        </div>
                        <div class="alert alert-light">
                          4. Lainasi on nyt palautettu ja se on poistunut <a href="#ownLoans">Omat lainat</a> osiosta.
                        </div>
                    </div>
                </div>
            </x-panel>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <x-panel header='Varusteet'>
            <a name="equipment" class="anchor"></a>
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
            <a name="newLoan" class="anchor"></a>
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
                            placeholder="Miksi lainaat ja mihin tarkoitukseen?"
                            value="{{ old('description') }}" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Mihin</label><span style="color:red">*</span>
                    <select class="form-control" name="reason" id="reason">
                        <option>Partiotapahtumaan</option>
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
            <a name="ownLoans" class="anchor"></a>
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
                                    @if(Carbon\Carbon::createFromFormat('d/m/Y',$loan->return_date)->lt(Carbon\Carbon::now()))
                                        <span class="badge badge-danger">Myöhässä</span>
                                    @elseif($loan->state==0)
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
                $('#info').append('<div class="alert alert-danger" role="alert" data-id="' + id + '">Varustetta ' + name + ' voi lainata enintään '+
                    quantity+' kappaletta.</div>')
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
