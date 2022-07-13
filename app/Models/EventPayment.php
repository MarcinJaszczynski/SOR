<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use Illuminate\Support\Facades\DB;



class EventPayment extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $fillable=[
        'paymentName',
        'paymentDescription',
        'event_id',
        'payer',
        'paymentStatus',
        'invoice',
        'paymentDate',
        'qty',
        'price',
        'paymentNote'];

        public function events(){
            return $this->belongsTo(Event::class, 'id', 'event_id');
        }


        
    

    
       
    
        
}
