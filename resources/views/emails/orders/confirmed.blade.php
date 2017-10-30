@component('mail::message')

#Order

Name: {{ $data[0]->name }}
@if ($data[0]->number) 
Number: {{ $data[0]->number }}
<br>
@endif
Email: {{ $data[0]->email }}

@foreach ($data as $order)
Product id: {{ $order->product_id }} <br>
Order: {{ $order->title }} <br>
Quantity: {{ $order->quantity }} <br>
Price: {{ $order->price * $order->quantity }}$ <br>
<br>
@endforeach

@endcomponent
