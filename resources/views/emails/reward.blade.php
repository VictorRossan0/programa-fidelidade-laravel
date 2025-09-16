@component('mail::message')
# Parabéns, {{ $client->name }} 🎊

Você resgatou o prêmio: **{{ $reward->name }}**
Custo em pontos: **{{ $reward->points_required }}**

Seu saldo atual é: **{{ $balance }} pontos**.

@component('mail::button', ['url' => 'https://empresa-x.com/catalogo-premios'])
Ver mais prêmios
@endcomponent

Continue acumulando pontos e aproveite nossos benefícios!
**Equipe Empresa X**
@endcomponent
