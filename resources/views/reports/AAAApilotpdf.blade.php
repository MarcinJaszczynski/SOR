<!DOCTYPE html>
<html lang="pl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odprawa pilota</title>
    <link href="{{ public_path('css/print.css') }}" rel="stylesheet">


</head>

<body>
    @inject('carbon', 'Carbon\Carbon')

    <footer>
        <hr>
        <p>Biuro Podróży RAFA, ul. Nowogrodzka 42, lok. 501, 00-695 Warszawa, tel.: + 48 606 102 243, nip: 716-250-87-61</p>
    </footer>

    <div class="titleclass textcenter"><strong>TECZKA PILOTA </strong></div>


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
            <td class="tdbordered">
                <div> {{ $event->eventPilot }}</div>
            </td>

            <td class="tdbordered lightgrey">Kierowca: </td>
            <td class="tdbordered">
                <div>{{ $event->eventDriver }}</div>
            </td>
        </tr>
        <tr>
            <td class="tdbordered lightgrey">Start: </td>
            <td class="tdbordered">
                <div>podstawienie: <strong>{{ date('H:i d/m/Y', strtotime($event->busBoardTime)) }}</strong></div>
                <hr>
                <div>wyjazd: <strong>{{ date('H:i d/m/Y',  strtotime($event->eventStartDateTime)) }} </strong></div>
                <hr>

                <div class="tabletext">{{ $event->eventStartDescription }}</div>
            </td>
            <td class="tdbordered lightgrey">Koniec:</td>
            <td class="tdbordered">
                <div>powrót {{ date('H:i d/m/Y',  strtotime($event->eventEndDateTime)) }}</div>
                <hr>
                <div class="tabletext"> {{ $event->eventEndDescription }}</div>
            </td>
        </tr>
        <tr>
            <td class="tdbordered lightgrey">Zamawiający: </td>
            <td class="tdbordered">
                <div>{{ $event->eventPurchaserContactPerson }}</div>
                <div> {{ $event->eventPurchaserTel }}</div>
            </td>
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
            <td class="tdbordered tabletext">{{ $event->eventDietAlert }}</td>
        </tr>
    </table>


    <p><strong>PROGRAM</strong></p>



    <table class="tablebordered" width="100%">
        <tr>
            <th class="tdbordered lightgrey" width="70px">data</th>
            <th class="tdbordered lightgrey">Program</th>
            <th class="tdbordered lightgrey">kontakt/miejsce</th>
            <th class="tdbordered lightgrey">Rezerwacje</th>
        </tr>
        @php
        $first_datetime = new DateTime($event->eventStartDateTime);
        $f_datetime = $first_datetime->format("d");
        $timeInterval = 1;
        echo '<tr>
            <td class="tdbordered" colspan="4">
                <h4><strong>DZIEŃ '.$timeInterval.'</strong></h4>
            </td>
        </tr>';
        @endphp

        @foreach($event->eventElements->where('eventElementPilotPrint', 'tak')->sortBy('eventElementStart') as $element)

        <?php
        $last_datetime = new DateTime($element->eventElementStart);
        $l_datetime = $last_datetime->format("d");
        if ($f_datetime != $l_datetime) {
            $timeInterval++;
            $f_datetime = $l_datetime;
            echo '<tr><td class="tdbordered" colspan="4"><h4><strong>DZIEŃ ' . $timeInterval . '</strong></h4></td></tr>';
        }

        ?>

        <tr>
            <td class="tdbordered">
                <div>{{ date('H:i',  strtotime($element->eventElementStart)) }}-{{ date('H:i',  strtotime($element->eventElementEnd)) }}</div>
                <div>{{ date('d.m.Y',  strtotime($element->eventElementStart)) }}</div>
            </td>
            <td class="tdbordered"><strong>
                    {{ $element->element_name }}</strong>
                <div class="tabletext">{!! $element->eventElementDescription !!}</div>
            </td>
            <td class="tdbordered tabletext">{!! $element->eventElementContact !!}</td>
            <td class="tdbordered tabletext">{!! $element->eventElementReservation !!}</td>



        </tr>
        @endforeach
    </table>

    <div class="page_break"></div>

    <div class="titleclass textcenter"><strong>STRUKTURA POKOJÓW/NOTATKI DLA PILOTA</strong></div>
    <div class="titleclass  textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
    <div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>


    <hr>

    <br>
    @foreach($event->hotels as $hotel)

    <div class="titleclass2">{{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelStartDate)) }} - {{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelEndDate))}}: <strong>{{ $hotel->hotelName }},</strong> {{$hotel->hotelStreet}}, {{$hotel->hotelCity}}, tel.: {{$hotel->hotelPhone}}</div>
    <div class="tabletext tabletext"><strong>Pokoje:</strong><br>{{ $hotel->pivot->eventHotelRooms }}</div>
    <div class="tabletex tabletext"><strong>Notatki do hotelu:</strong> <br>{{ $hotel->pivot->eventHotelNote }}</div>
    <hr>

    @endforeach

    <br>
    <div class="textcenter titleclass"><strong>Notatki dla pilota: </strong></div>
    <hr>


    <div class="formatedText tabletext">{!! $event->eventPilotNotes !!}</div>




    <div class="page_break"></div>

    <div class="titleclass textcenter"><strong>ROZLICZENIE IMPREZY</strong></div>


    <div class="titleclass textcenter"><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</div>
    <div class="textcenter">Imię i nazwisko pilota: {{ $event->eventPilot }}</div>

    <hr>

    <table class="tablebordered" width="100%">
        <tr>
            <td colspan="2" class="tdbordered">ILOSĆ UCZESTNIKÓW</td>
        </tr>
        <tr>
            <td class="tdbordered">PLANOWANA: {{$event->eventTotalQty}} w tym {{ $event->eventGuardiansQty }} opiekunów</td>
            <td class="tdbordered">RZECZYWISTA: </td>
        </tr>
    </table>
    <table class="tablebordered" width="100%">
        <tr>
            <td colspan="2" class="tdbordered">LICZNIK AUTOKARU</td>
        </tr>
        <tr>
            <td class="tdbordered">START:</td>
            <td class="tdbordered">KONIEC</td>
        </tr>
    </table>


    <table class="tablebordered">
        <tr>
            <th class="tdbordered lightgrey"">miejsce</th>
            <th  class=" tdbordered lightgrey"">cena/os</th>
            <th class="tdbordered lightgrey"">ilość</th>
            <th  class=" tdbordered lightgrey"">suma planowana</th>
            <th class="tdbordered lightgrey">data</th>
            <th class="tdbordered lightgrey">nr faktury</th>
            <th class="tdbordered lightgrey">suma zapłacona</th>
        </tr>



        @foreach($event->eventPayment->where('payer', 'pilot') as $payment)



        <tr>
            <td class="tdbordered tabletext">{{ $payment->paymentName }}<br>{{ $payment->paymentNote }}</td>
            <td class="tdbordered">{{ $payment->price }}</td>
            <td class="tdbordered">{{ $payment->qty }}</td>
            <td class="tdbordered"><strong> {{ $payment->price * $payment->qty }}</strong></td>
            <td class="tdbordered"></td>
            <td class="tdbordered"></td>
            <td class="tdbordered"></td>
        </tr>

        @endforeach
        @for ($i = 0; $i < 5; $i++) <tr>
            <td class="tdbordered">:</td>
            <td class="tdbordered"></td>
            <td class="tdbordered"></td>
            <td class="tdbordered"></td>
            <td class="tdbordered"></td>
            <td class="tdbordered"></td>
            <td class="tdbordered"></td>
            </tr>

            @endfor

            <tr>
                <td colspan="4" class="titleclass2 tdbordered">Razem: {{ $event->pilotSum($event->id) }}</td>
                <td colspan="3" class="titleclass2 tdbordered">
                    Wydano: </td>
            </tr>
            <tr>
                <td colspan="4" class="titleclass2 tdbordered">Zaliczka dla pilota: {{ $event->eventAdvancePayment }}</td>
                <td colspan="3" class="titleclass2 tdbordered">
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
            <td class="titleclass2">Plik</td>
            <td class="titleclass2">Opis</td>
        </tr>
        @foreach($event->files->where('filePilotSet', 'tak') as $file)

        <tr>
            <td class="titleclass2"><a href="https://host378742.xce.pl/storage/{{ $file->fileName }}" download>{{ $file->fileName }}</a></td>
            <td class="titleclass2">{{ $file->FileNote }}</td>
        </tr>

        @endforeach
    </table>










</body>

</html>