@component('mail::message')
# Olá, {{ $participantName }}

Você está participando de um novo sorteio de amigo secreto.    

**Nome do grupo:** {{ $groupName }}  
**Data da Troca de Presentes:** {{ $exchangeDate }}  

Você deve levar um presente para: **{{ $friendName }}**    

@if ($gifts)
Aqui estão algumas sugestões de presente cadastradas pelo seu amigo:
<br>   
@foreach ($gifts as $gift)
<a href="https://www.buscape.com.br/search/{{ str_slug($gift->name) }}" target="_blank">{{ $gift->name }}</a>  
@endforeach
<br>
@else
O sorteado não cadastrou nenhuma sugestão de presente :(  
<br>
@endif
Obrigado,<br>
{{ config('app.name') }}
@endcomponent
