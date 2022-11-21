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
    <div id="app">
        <loan-form-wrapper :equipment="{{ $equipment }}" user-name="{{ Auth::user()->name }}" ></loan-form-wrapper>
        {{-- omat lainat --}}
        <div class="row mt-5">
            <div class="col-md-6">
                <own-loans :own-loans="{{ $own_loans }}"/>
                </div>
            </div>
    </div>
    @endsection
