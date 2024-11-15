@component('mail::message')
# Laina  {{ $loan->state == 2 ? 'hyväksytty' : 'hylätty' }}

## Lainahakemuksesi varusteesta {{$loan->equipment->name}} on {{ $loan->state == 2 ? 'hyväksytty' : 'hylätty' }}!

@component('mail::table')
| Varuste      | Paikka   | Määrä     | Laina-aika |
|:-----------: |:--------:|:--------: |:---------: |
| {{$loan->equipment->name}}     | {{$loan->equipment->location}} |{{$loan->quantity}} |{{$loan->loan_date}} - {{$loan->return_date}}|
@endcomponent

@component('mail::button', ['url' => 'https://johtajat.tammipartio.fi/loan'])
    Avaa lainat
@endcomponent

Terveisin,<br>
PTP Johtajat
@endcomponent