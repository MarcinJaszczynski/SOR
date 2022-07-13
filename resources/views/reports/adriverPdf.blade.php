<!DOCTYPE html>
<html lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teczka imprezy</title>
    <link href="{{ public_path('css/print.css') }}" rel="stylesheet">
    

</head>
<body>

<footer>
    <hr>
    Biuro Podróży RAFA, tel.: + 48 606 102 243, www.bprafa.pl, nip: 716-250-87-61
        </footer>

<div class="titleclass textcenter"><strong>INFORMACJE DLA KIEROWCY</strong></div>


<div class="titleclass  textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
<div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>

<hr>
<table class="tablebordered titleclass">
    <tr>
        <td class="tdbordered" ><strong>Podstawienie: </strong></td>
        <td class="tdbordered">godz: {{ date('H:i d/m/Y', strtotime($event->busBoardTime)) }}</td>
    </tr>
    <tr>
        <td class="tdbordered"><strong>Odjazd: </strong></td>
        <td class="tdbordered">godz: {{ date('H:i d/m/Y', strtotime($event->eventStartDateTime)) }}</td>
    </tr>
</table>

<div class="titleclass"><strong>Uwagi do podstawienia/wyjazdu: </strong></div>
<div class="tabletext">{{ $event->eventStartDescription }}</div>

<table class="tablebordered titleclass">
    <tr>
        <td class="tdbordered" ><strong>Powrót: </strong></td>
        <td class="tdbordered">godz: {{ date('H:i d/m/Y', strtotime($event->eventEndDateTime)) }}</td>
    </tr>
</table>
<div class="titleclass"><strong>Uwagi do powrotu: </strong></div>
<div class="tabletext">{{ $event->eventEndDescription }}</div>
<hr>
<div class="titleclass"><strong>Hotele: </strong></div>
@foreach($event->hotels as $hotel)

<div>{{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelStartDate)) }}-{{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelEndDate))}} - <strong>{{ $hotel->hotelName }}, </strong> {{$hotel->hotelStreet}}, {{$hotel->hotelCity}}, tel.: {{$hotel->hotelPhone}}</div>
@endforeach


    
</body>
</html>




