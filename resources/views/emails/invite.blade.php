@component('mail::message')
# Sinut on kutsuttu {{config('kota.lippukunta')}} johtajien nettisivuille
Rekisteröidy alla olevasta napista:
@component('mail::button',['url'=>$invite->url])
Rekisteröidy  
@endcomponent
Terveisin,<br>
{{config('kota.lippukunta')}}
@endcomponent