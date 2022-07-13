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
     
    </table>

 




    
</body>
</html>




