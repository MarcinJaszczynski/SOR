<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;


class EventElement extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'element_name', 
        'eventIdinEventElements', 
        'eventElementDescription', 
        'eventElementPilotPrint', 
        'eventElementHotelPrint',
        'eventElementStart',
        'eventElementEnd',
        'eventElementCost',
        'eventElementCostStatus',
        'eventElementCostPayer',
        'eventElementNote',
        'eventElementCostQty',
        'eventElementCostNote',
        'eventElementContact',
        'eventElementReservation',
        'eventElementInvoiceNo'

];


    public function events(){
        return $this->belongsTo(Event::class, 'id', 'eventId');
    }
}