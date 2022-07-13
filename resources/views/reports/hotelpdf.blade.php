<!DOCTYPE html>
<html lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda dla hotelu</title>
    <link href="{{ public_path('css/print.css') }}" rel="stylesheet">
    

</head>
<body>

<footer>
    <hr>
    Biuro Podróży RAFA, tel.: + 48 606 102 243, www.bprafa.pl, nip: 716-250-87-61
        </footer>

<div class="titleclass textcenter"><strong>AGENDA DLA HOTELU</strong></div>


<div class="titleclass  textcenter"><strong>{{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>

<hr>




    <table class="tablebordered">
        <tr>
            <td class="tdbordered lightgrey">Termin: </td>
            <td colspan="3" class="tdbordered">{{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</td>
        </tr>
        <tr>
            <td class="tdbordered lightgrey">Pilot</td>
            <td class="tdbordered">{{ $event->eventPilot }}</td>

            <td class="tdbordered lightgrey">Kierowca: </td>
            <td class="tdbordered">{{ $event->eventDriver }}
        </tr>

        <tr>
            <td class="tdbordered lightgrey">Zamawiający: </td>
            <td class="tdbordered"><div>Biuro Podróży RAFA</div><div>tel.: 48 660 699 210, 48 606 102 243</div><div>Osoba odpowiedzialna w notatkach poniżej</div></td>
            <td class="tdbordered lightgrey">Uczestnicy łącznie: </td>
            <td class="tdbordered">{{ $event->eventTotalQty }} (w tym {{ $event->eventGuardiansQty }} opiekunów) <br>+ pilot i kierowca</td>
        </tr>
        <tr>
        <td class="tdbordered lightgrey"></td>
        <td class="tbordered">
           
        </td>
        <td class="tdbordered lightgrey">Dieta: </td>
            <td class="tdbordered tabletext">{{ $event->eventDietAlert }}</td>
        </tr>
    </table>

    
    <p><strong>PROGRAM</strong></p>

    

    <table class="tablebordered" width="100%">
        <tr>
            <th class="tdbordered lightgrey" width="70px">data</th><th class="tdbordered lightgrey">Program</th><th class="tdbordered lightgrey">Rezerwacje</th>
</tr>
    @foreach($event->eventElements->where('eventElementHotelPrint', 'tak')->sortBy('eventElementStart') as $element)
        <tr>
            <td class="tdbordered"><div>{{ date('H:i',  strtotime($element->eventElementStart)) }}-{{ date('H:i',  strtotime($element->eventElementEnd)) }}</div>
            <div>{{ date('d.m.Y',  strtotime($element->eventElementStart)) }}</div></td>
            <td class="tdbordered"><strong>{{ $element->element_name }}</strong>
            <pre>{!! $element->eventElementDescription !!}</pre></td>
            <td class="tdbordered"><pre>{!! $element->eventElementReservation !!}</pre>
        </td>
        </tr>
        @endforeach
    </table>

    <div class="page_break"></div>

    @foreach($event->hotels as $hotel)

    <!-- START - tabela nagłówka -->

    <div class="titleclass textcenter"><strong>AGENDA DLA HOTELU</strong></div>


<div class="titleclass  textcenter"><strong>Wycieczka: {{ $event->eventName }}</strong><br>{{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelStartDate)) }} - {{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelEndDate))}}</div>
<div class="titleclass  textcenter" > <strong>{{ $hotel->hotelName }},</strong> {{$hotel->hotelStreet}}, {{$hotel->hotelCity}}, tel.: {{$hotel->hotelPhone}}</div>

<hr>




    <table class="tablebordered">

        <tr>
            <td class="tdbordered lightgrey">Pilot</td>
            <td class="tdbordered">{{ $event->eventPilot }}</td>

            <td class="tdbordered lightgrey">Kierowca: </td>
            <td class="tdbordered">{{ $event->eventDriver }}
        </tr>

        <tr>
            <td class="tdbordered lightgrey">Zamawiający: </td>
            <td class="tdbordered"><div>Biuro Podróży RAFA</div><div>tel.: 48 660 699 210, 48 606 102 243</div><div>Osoba odpowiedzialna w notatkach poniżej</div></td>
            <td class="tdbordered lightgrey">Uczestnicy łącznie: </td>
            <td class="tdbordered">{{ $event->eventTotalQty }} (w tym {{ $event->eventGuardiansQty }} opiekunów) <br>+ pilot i kierowca</td>
        </tr>
        <tr>
        <td class="tdbordered lightgrey"></td>
        <td class="tbordered">
           
        </td>
        <td class="tdbordered lightgrey">Dieta: </td>
            <td class="tdbordered tabletext">{{ $event->eventDietAlert }}</td>
        </tr>
    </table>

    <!-- END - Tabele nagłówka -->
    <div class="titleclass">Struktura pokojów:</div>
    <div class="tabletext">{{ $hotel->pivot->eventHotelRooms }}</div>
    <hr>
    <div class="titleclass">Notatki do hotelu:</div>
    <div class="tabletext">{{ $hotel->pivot->eventHotelNote }}</div>
    <hr>

    <!-- Start - tabela programu -->

    <div class="titleclass">Program pobytu</div>
    <table class="tablebordered" width="100%">
        <tr>
            <th class="tdbordered lightgrey" width="70px">data</th><th class="tdbordered lightgrey">Program</th><th class="tdbordered lightgrey">Rezerwacje</th>
</tr>

    

    @foreach($event->eventElements->where('eventElementHotelPrint', 'tak')->sortBy('eventElementStart') as $element)

      
    @if (date('d.M.Y H:i', strtotime($element->eventElementStart)) >= date('d.M.Y H:i', strtotime($hotel->pivot->eventHotelStartDate)) && date('d.M.Y H:i', strtotime($element->eventElementEnd))<=date('d.M.Y H:i', strtotime($hotel->pivot->eventHotelEndDate)))

        <tr>
            <td class="tdbordered"><div>{{ date('H:i',  strtotime($element->eventElementStart)) }}-{{ date('H:i', strtotime($element->eventElementEnd)) }}</div>
            <div>{{ date('d.m.Y',  strtotime($element->eventElementStart)) }}</div></td>
            <td class="tdbordered tabletext"><strong>{{ $element->element_name }}</strong><br>{!! $element->eventElementDescription !!}</td>
            <td class="tdbordered tabletext">{!! $element->eventElementReservation !!}
        </td>
        </tr>
        @endif

        @endforeach
    </table>

    <!-- End - tabela programu -->    

    <div class="page_break"></div>

    @endforeach

<div class="titleclass textcenter"><strong>PLIKI</strong></div>


<div class="titleclass  textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
<div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>

<hr>


    <table>


    <tr>
        <td class="titleclass2">Plik</td><td class="titleclass2">Opis</td>
    </tr>
        @foreach($event->files->where('fileHotelSet', 'tak') as $file)

        <tr>
        <td class="titleclass2"><a href="https://host378742.xce.pl/storage/{{ $file->fileName }}" download>{{ $file->fileName }}</a></td>
        <td class="titleclass2">{{ $file->FileNote }}</td>
        </tr>

        @endforeach
    </table>

    
</body>
</html>




