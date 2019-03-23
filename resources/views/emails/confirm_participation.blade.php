@component('mail::message')
# Olá, {{ $participantName }}

Você foi adicionado em uma novo grupo de amigo secreto

**Nome do grupo:** {{ $groupName }}  
**Criador:** {{ $groupCreatorName }}

Para confirmar sua participação, clique no botão abaixo.    
@component('mail::button', ['url' => $confirmUrl])
Confirmar
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
