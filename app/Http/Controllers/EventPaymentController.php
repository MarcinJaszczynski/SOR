<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; 

class EventPaymentController extends Controller
{

    public function index(Request $request)

    {
        $data = EventPayment::where('event_id', $request->event_id)->get();
        $event = Event::find($request->event_id);
        return view('eventPayments.index',compact('data', 'event'));
    }

    // Start - funkcje podstawowe


        public function store(Request $request)
        {
            $this->validate($request, [
                'paymentName' => 'required',
            ]);
            $input = $request->except(['_token']);
        
            EventPayment::create($input);
        
            return back();
        }

        public function update(Request $request){



            $data=EventPayment::findOrFail($request->id);
            $data->update($request->all());
            return back();
        }

        public function destroy($id)
        {
            $payment=EventPayment::findOrFail($id);
            $payment->delete();
            return back();
        }


}



