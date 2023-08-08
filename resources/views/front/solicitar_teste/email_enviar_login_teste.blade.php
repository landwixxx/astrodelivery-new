@component('mail::message')
## Login para teste

<p class="">
    Com este login você pode acessar o painel do AstroDelivery por 7 dias e testar todos os recursos disponíveis.
</p>
<p class="">
    Após encerrar o período de teste por 7 dias, você pode entrar em contato conosco e contratar o serviço pelo tempo que desejar.
</p>

<p class="">
    E-mail: {{$userTest->email}}<br>
    Senha: {{$pass}}
</p>

@component('mail::button', ['url' => route('login')])
Fazer Login
@endcomponent
 
Saudações,<br>
<a href="{{config('app.url')}}" class="">{{ config('app.name') }}</a>

{{-- @component('mail::subcopy')
Se você estiver com problemas para clicar no botão "Ver publicação completa", copie e cole o URL abaixo em seu navegador da web: {{route('post', $post->slug)}}
@endcomponent --}}
@endcomponent


