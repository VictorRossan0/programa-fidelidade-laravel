@component('mail::message')
# Olá, {{ $client->name }} 👋

Você acabou de ganhar **{{ $points }} pontos** pela sua última compra!

Seu saldo atual é: **{{ $balance }} pontos**.

@component('mail::button', ['url' => 'https://empresa-x.com/fidelidade'])
Acompanhar meu saldo
@endcomponent

Obrigado por participar do nosso programa de fidelidade!
**Equipe Empresa X**
@endcomponent
