@component('mail::message')
# Olá, {{ $client->name }} 🌟

Boas notícias: você tem pontos suficientes para resgatar o **Almoço Especial** (20 pontos).

@component('mail::button', ['url' => 'https://empresa-x.com/catalogo-premios'])
Resgatar agora
@endcomponent

Não deixe seus pontos parados, aproveite o benefício hoje mesmo!
**Equipe Empresa X**
@endcomponent
