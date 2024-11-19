<x-mail::message>
    Prezada(o): {{ $notifiable->name }} <br>
    Mensagem: {{ $message }}

    Att.
    {{ config('app.name') }}
</x-mail::message>
