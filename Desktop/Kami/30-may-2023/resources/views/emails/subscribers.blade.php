@component('mail::message')

# Welcome to the Jeevansoft

Dear {{$email}},

Jeevansoft, as the name suggests owes you the best. 
As one of the renowned and leading IT companies with a global market presence

@component('mail::button', ['url' => 'https://clinicsystem.stage02.obdemo.com/'])
Jeevansoft
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
