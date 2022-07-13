<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventElement;
use App\Models\Eventfile;
use App\Models\Hotel;
use App\Models\EventPayment;
use Illuminate\Support\Facades\DB;



class Event extends Model
{
    use HasFactory;

    protected $fillable=[

    'eventName',
    'eventOfficeId',
    'eventNote',
    'eventStartDateTime',
    'eventEndDateTime',
    'eventStartDescription',
    'eventEndDescription',
    'eventDietAlert',
    'eventTotalQty',
    'eventGuardiansQty',
    'eventFreeQty',
    'eventStatus',
    'eventPurchaserName',
    'eventPurchaserStreet',
    'eventPurchaserCity',
    'eventPurchaserNip',
    'eventPurchaserContactPerson',
    'eventPurchaserTel',
    'eventPurchaserEmail',
    'eventPilot',
    'eventDriver',
    'eventAdvancePayment',
    'eventPilotNotes',
    'busBoardTime',
    
    

    ];

    public function files(){
        return $this->hasMany(Eventfile::class, 'eventId', 'id');
    }

    public function eventElements(){
        return $this->hasMany(EventElement::class, 'eventIdinEventElements', 'id');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'event_hotel')->withPivot('eventHotelNote', 'eventHotelStartDate', 'eventHotelEndDate', 'eventHotelRooms');
    }

    public function eventPayment(){
        return $this->hasMany(EventPayment::class, 'event_id', 'id');
    }

    public function totalSum($id){    
        $total=DB::table('event_payments')->where('event_id', $id )->sum(DB::raw('qty * price'));     
        
        return $total;
    }

    public function pilotSum($id){    
   
        $total=DB::table('event_payments')->where('event_id', $id )->where('payer','pilot')->sum(DB::raw('qty * price'));       
        return $total;
    }

    public function paidSum($id){
    
        $total=DB::table('event_payments')->where('event_id', $id )->where('paymentStatus','1')->sum(DB::raw('qty * price'));       
        
        return $total;
    }

   


}

