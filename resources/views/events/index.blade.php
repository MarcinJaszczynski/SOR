@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Imprezy</h4> |
                <a href="?eventStatus=Potwierdzona">Potwierdzona</a> |
                <a href="?eventStatus=OdprawaOK">OdprawaOK</a> |
                <a href="?eventStatus=DoRozliczenia">DoRozliczenia</a> |
                <a href="?eventStatus=Planowana">Planowana</a> |
                <a href="?eventStatus=Zakończona">Zakończona</a> |
                <a href="?eventStatus=Zmiana terminu">Zmiana terminu</a> |
                <a href="?eventStatus=Anulowana">Anulowana</a> |
                <a href="?eventStatus=Archiwum">Archiwum</a> |
                <a href="?createTime=True">Najnowsze</a> | |

                <a href="?">Reset</a> |



                <form action='events'>
                    <input type="hidden" name="search" value="search">
                    Szukaj:
                    <input type="text" name="searchText">
                    w
                    <select name="searchColumn">
                        <option value="eventName">nazwa imprezy</option>
                        <option value="eventOfficeId">kod imprezy</option>
                        <option value="eventPurchaserName">nazwa zamawiającego</option>
                        <option value="eventPurchaserContactPerson">osoba zamawiająca</option>
                        <option value="eventPilot">pilot</option>
                        <option value="eventDriver">kierowca</option>

                    </select>

                    <input type="submit" value="Szukaj">
                </form>

                @can('role-create')
                <span class="float-right d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('events.create') }}">Nowa impreza</a>
                </span>
                @endcan
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Start</th>
                            <th>długość</th>
                            <th>Nazwa/klient</th>
                            <th>Hotel</th>
                            <th>Pilot/Kierowca</th>
                            <th>Status</th>

                            <th>Operacje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $event)
                        <tr <?php
                            $addTime = new DateTime($event->created_at);
                            $todayTime = new DateTime();
                            $dateInterval = $todayTime->diff($addTime);
                            if ($dateInterval->format('%a') < 4) {
                                echo ' class = "newEvent"';;
                            }

                            ?>>
                            <td>{{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }}</td>
                            <td>
                                <?php
                                $datetime1 = new DateTime($event->eventStartDateTime);
                                $datetime2 = new DateTime($event->eventEndDateTime);
                                $interval = $datetime1->diff($datetime2);
                                $days = $interval->format('%a') + 1;

                                echo $days . ' dni';
                                ?>
                            </td>
                            <td><strong>{{ $event->eventName }}</strong><br>
                                {{ $event->eventOfficeId }}<br>
                                {{ $event->eventPurchaserName }}<br>
                                {{ $event->eventPurchaserContactPerson}}<br>
                            </td>
                            <td>
                                @foreach($event->hotels as $hotel)

                                <strong>{{ $hotel->hotelName }}</strong></br>
                                {{ $hotel->hotelStreet }}, {{ $hotel->hotelCity }}<br>

                                @endforeach
                            </td>
                            <td>
                                <div><strong>U:</strong> {{ $event->eventTotalQty }} osób</div>
                                <div><strong>K:</strong> {{$event->eventDriver }}</div>
                                <div><strong>P:</strong> {{ $event->eventPilot }} </div>

                            </td>
                            <td>
                                <details data-popover="down">
                                    <summary>
                                        <span class="{!!$event->eventStatus!!}">{{ $event->eventStatus }}</span>
                                    </summary>
                                    <div>
                                        {!! $event->eventNote !!}
                                    </div>
                                </details>
                            </td>
                            <td>

                                @can('event-edit')
                                <a class="btn btn-outline-primary" href="{{ route('events.edit',$event->id) }}"><i class="bi bi-pencil-square"></i></a>
                                @endcan

                                <!-- <details data-popover="down">
  <summary>I'm a popover</summary>
  <div>
    {!! $event->eventNote !!}
  </div>
</details> -->




                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
</script>





@endsection