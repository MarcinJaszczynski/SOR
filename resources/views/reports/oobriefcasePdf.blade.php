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

<div class="titleclass textcenter"><strong>TECZKA IMPREZY </strong></div>

<div class="titleclass  textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
<div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>
<hr>

<div class="titleclass  textcenter"><strong>Zamawiający: </strong>{{ $event->eventPurchaserName }}, {{ $event->eventPurchaserStreet }} {{ $event->eventPurchaserCity }}</div>




<div class="page_break"></div>


<div class="titleclass textcenter"><strong>PROGRAM IMPREZY </strong></div>


<div class="titleclass  textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
<div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>

<hr>




    <table class="tablebordered">
        <tr>
            <td class="tdbordered lightgrey">Termin: </td>
            <td colspan="3" class="tdbordered">{{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</td>
        </tr>
        <tr>
            <td class="tdbordered lightgrey">Pilot</td>
            <td class="tdbordered"><div> {{ $event->eventPilot }}</div> </td>

            <td class="tdbordered lightgrey">Kierowca: </td>
            <td class="tdbordered"><div>{{ $event->eventDriver }}</div></td>
        </tr>
        <tr>
            <td class="tdbordered lightgrey">Start: </td>
            <td  class="tdbordered"><div>wyjazd: {{ date('H:m d/m/Y',  strtotime($event->eventStartDateTime)) }} </div>
            <hr>
            <div>podstawienie: {{ $event->busBoardTime }}</div><div>{{ $event->eventStartDescription }}</div></td>
            <td class="tdbordered lightgrey">Koniec:</td>
            <td class="tdbordered"><div>powrót {{ date('H:m d/m/Y',  strtotime($event->eventEndDateTime)) }}</div>
            <hr>
            <div> {{ $event->eventEndDescription }}</div></td>
        </tr>
        <tr>
            <td class="tdbordered lightgrey">Zamawiający: </td>
            <td class="tdbordered"><div>{{ $event->eventPurchaserContactPerson }}</div><div> {{ $event->eventPurchaserTel }}</div></td>
            <td class="tdbordered lightgrey">Uczestnicy łącznie: </td>
            <td class="tdbordered">{{ $event->eventTotalQty }} (w tym {{ $event->eventGuardiansQty }} opiekunów) </td>
        </tr>
        <tr>
        <td class="tdbordered lightgrey">Noclegi: </td>
        <td class="tbordered">
            @foreach($event->hotels as $hotel)
            <div class="p5"><strong>{{ $hotel->hotelName }}</strong> - {{ $hotel->hotelStreet }} {{ $hotel->hotelCity }}, tel.: {{ $hotel->hotelPhone }} </div>
            <hr>
            @endforeach
        </td>
        <td class="tdbordered lightgrey">Dieta: </td>
            <td class="tdbordered"><pre>{{ $event->eventDietAlert }}</pre></td>
        </tr>
    </table>

    
    <p><strong>PROGRAM</strong></p>

    

    <table class="tablebordered">
        <tr>
            <th class="tdbordered lightgrey">data</th><th class="tdbordered lightgrey">Program</th><th class="tdbordered lightgrey">kontakt/miejsce</th><th class="tdbordered lightgrey">Rezerwacje</th>
</tr>
    @foreach($event->eventElements->sortBy('eventElementStart') as $element)
        <tr>
            <td class="tdbordered"><div>{{ date('H:m',  strtotime($element->eventElementStart)) }} - {{ date('H:m',  strtotime($element->eventElementEnd)) }}</div>
            <div>{{ date('d.m.Y',  strtotime($element->eventElementStart)) }}</div></td>
            <td class="tdbordered"><strong>{{ $element->element_name }}</strong>
            <pre>{!! $element->eventElementDescription !!}</pre></td>
            <td class="tdbordered"><pre>{!! $element->eventElementContact !!}</pre></td>
            <td class="tdbordered"><pre>{!! $element->eventElementReservation !!}</pre><br>
            {!! $element->eventElementCostNote !!}
        </td>



        </tr>
        @endforeach
    </table>

    <div class="page_break"></div>

    <div class="titleclass textcenter"><strong>NOTATKI/STRUKTURA POKOJÓW</strong></div>
    <div class="titleclass  textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
    <div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>


    <hr>

    <br>
    @foreach($event->hotels as $hotel)

    <div class="titleclass2">{{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelStartDate)) }} - {{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelEndDate))}}: <strong>{{ $hotel->hotelName }},</strong> {{$hotel->hotelStreet}}, {{$hotel->hotelCity}}, tel.: {{$hotel->hotelPhone}}</div>
    <div>Notatki do hotelu: {{ $hotel->pivot->eventHotelNote }}</div>
    <div>Pokoje: <pre>{{ $hotel->pivot->eventHotelRooms }}</pre></div>
    <hr>

    @endforeach

    <div class="textcenter titleclass2">Notatki dla pilota: </div>
<hr>


    <div class="formatedText"><pre>{!! $event->eventPilot !!}</pre></div>




    <div class="page_break"></div>

    <div class="titleclass textcenter"><strong>ROZLICZENIE IMPREZY</strong></div>


    <div class="titleclass  textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
    <div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>

    <hr>

    <table class="tablebordered" width="100%">
    <tr><td colspan="2" class="tdbordered">ILOSĆ UCZESTNIKÓW</td></tr>
    <tr>
        <td class="tdbordered">PLANOWANA: {{$event->eventTotalQty}} w tym {{ $event->eventGuardiansQty }} opiekunów</td>
        <td class="tdbordered">RZECZYWISTA: </td>
    </tr>
</table>
    <table class="tablebordered" width="100%">
    <tr><td colspan="2" class="tdbordered">LICZNIK AUTOKARU</td></tr>
    <tr>
        <td class="tdbordered">START:</td>
        <td class="tdbordered">KONIEC</td>
    </tr>
</table>
    

    <table  class="tablebordered">
        <tr>
            <th  class="tdbordered lightgrey"">miejsce</th>
            <th  class="tdbordered lightgrey"">cena/os</th>            
            <th  class="tdbordered lightgrey"">ilość</th>
            <th  class="tdbordered lightgrey"">suma</th>
            <th class="tdbordered lightgrey">data</th>
            <th class="tdbordered lightgrey">nr faktury</th>
            <th  class="tdbordered lightgrey">zapłacone</th>
        </tr>



        @foreach($event->eventPayment as $payment)

        
        
        <tr>
            <td class="tdbordered">{{ $payment->paymentName }}<br>{{ $payment->paymentDescription }}
            <td class="tdbordered">{{ $payment->price }}</td>
            <td class="tdbordered">{{ $payment->qty }}</td>
            <td class="tdbordered"><strong> {{ $payment->price * $payment->qty }}</strong></td>
            <td class="tdbordered">{{ $payment->paymentDate }}</td>
            <td class="tdbordered">{{ $payment->invoice }}<br>{{ $payment->paymentNote }}</td></td>
            <td class="tdbordered">        
                @if($payment->paymentStatus == 0)
            niezapłacone
        @else
            zapłacone
        @endif</td>
        </tr>

        @endforeach

        <tr><td colspan="4" class="titleclass2 tdbordered"></td><td colspan="3" class="titleclass2 tdbordered">
            Łącznie: {{ $event->totalSum($event->id) }}</td>
        </tr>
        <tr><td colspan="4" class="titleclass2 tdbordered"></td><td colspan="3" class="titleclass2 tdbordered">
            Do zwrotu: </td>
        </tr>
    </table>

        <div class="page_break"></div>

<div class="titleclass textcenter"><strong>PLIKI</strong></div>


<div class="titleclass  textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
<div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>

<hr>


    <table>


    <tr>
        <td class="titleclass2">Plik</td><td class="titleclass2">Opis</td>
    </tr>
        @foreach($event->files as $file)

        <tr>
        <td class="titleclass2"><a href="https://host378742.xce.pl/storage/{{ $file->fileName }}" download>{{ $file->fileName }}</a></td>
        <td class="titleclass2">{{ $file->FileNote }}</td>
        </tr>

        @endforeach
    </table>









    
</body>
</html>




