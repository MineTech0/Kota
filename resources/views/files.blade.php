@extends('layouts.app')

@section('head')
<style>
    .single {
        padding: 30px 15px 0px;
        background: #fcfcfc;
        margin-top: 25px;
        display: block;
    }

    .single ul {
        margin-bottom: 0;
    }

    .single li a {
        color: #666;
        font-size: 14px;
        text-transform: uppercase;
        border-bottom: 1px solid #f0f0f0;
        line-height: 40px;
        display: block;
        text-decoration: none;
    }

    .single li a:hover {
        color: #28a9e1;
    }

    .single li:last-child a {
        border-bottom: 0;
    }

    .single span {
        font-size: 8pt;
        opacity: 0.5;
    }

    .selCon {
        display: block;
        margin: 0.6rem;
        display: flex;
        justify-content: flex-end;
    }

    .selCon .btn {
        padding-bottom: 6px;
        padding-top: 6px;
    }

</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <x-panel header='Tiedostot'>
                    <div class="selCon">
                        <select id="kategoria" class="selectpicker " title="Kategoria" data-width="100%">
                            <option>Kaikki</option>
                            <option>Leirikirje</option>
                            <option>Asiakirja</option>
                            <option>Muu</option>
                        </select>
                    </div>

                    <div class="single category">
                        <ul class="list-unstyled">
                            @foreach($files as $file)
                        <li><a class="link" href="/files/{{ $file->id }}/token/{{$token}}">{{ $file->name }}<span
                                            class="pull-right">{{ $file->kategory }}</span></a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </x-panel>
            </div>
            <div class="col-md-6">
                <x-panel header='Lomakkeet'>
                    <p class="text-muted">Coming soon...</p>
                </x-panel>
            </div>

        </div>
    </div>
</div>

</div>
</div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('select').selectpicker();

        $('#kategoria').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            var sel = this.value;
            if (this.value == "Kaikki") {
                var all = true;
            }
            $('.list-unstyled li').each(function (i, option) {

                if (($(this).find('span').text().toLowerCase() == sel.toLowerCase()) || all) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });

</script>

@endsection
