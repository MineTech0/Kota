@component('mail::message')
# Laina hyväksytty

## Lainahakemuksesi varusteesta {{$loan->equipment->name}} on hyväksytty!

@component('mail::table')
| Varuste      | Paikka   | Määrä     | Laina-aika |
|:-----------: |:--------:|:--------: |:---------: |
| {{$loan->equipment->name}}     | {{$loan->equipment->location}} |{{$loan->quantity}} |{{$loan->loan_date}} - {{$loan->return_date}}|
@endcomponent

@component('mail::button', ['url' => 'https://johtajat.tammipartio.fi/loan'])
    Avaa lainat
@endcomponent

Terveisin,<br>
{{ config('app.name') }}
@endcomponent