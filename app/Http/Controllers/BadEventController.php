<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Hotel;
use App\Models\Eventfile;
use App\Models\EventElement;
use App\Models\EventPayment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

// use ZipArchive;


class EventController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:event-list|event-create|event-edit|event-delete', ['only' => ['index', 'show']]);
         $this->middleware('permission:event-create', ['only' => ['create', 'store']]);
         $this->middleware('permission:event-edit', ['only' => ['edit', 'update']]);
         $this->middleware('permission:event-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   


        if (request()->has('eventStatus')){
            $data=Event::orderBy('eventStartDateTime', 'asc')->where('eventStatus', request('eventStatus'))->paginate(50)->appends('eventStatus', request('eventStatus'));

        }
        elseif (request()->has('createTime')){
            $data = Event::orderBy('created_at', 'desc')->where('eventStatus','!=','Archiwum')->paginate(50);
        }

        elseif ($request->search === 'search'){
            $searchColumn = $request->searchColumn;
            $searchText = $request->searchText;
            

            $data=Event::query()->where($searchColumn, 'LIKE', '%'.$searchText.'%')->Where('eventStatus','=','Potwierdzona')->orWhere('eventStatus','=','Planowana')->orderBy('eventStartDateTime')->paginate(50);

            // dd($data);

            // $query = DB::table("employee") ->where('employee_name', 'LIKE', '%'.$search.'%')->get();

        }
        else {
        $data = Event::orderBy('eventStartDateTime', 'asc')->where('eventStatus','=','Planowana')->orWhere('eventStatus','=','Potwierdzona')->paginate(50);

        }



        return view('events.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'eventName' => 'required',
            'eventOfficeId' => 'required',
        ]);
        $input = $request->except(['_token']);
    
        Event::create($input);
    
        return redirect()->route('events.index')
            ->with('success','Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        $allHotels=Hotel::all();


        return view('events.edit',compact('event','allHotels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'eventName' => 'required',
            'eventOfficeId' => 'required',
        ]);


        $event = Event::find($id);
        // dd($request);
    
        $event->update($request->all());

        // if($request->hasFile('eventFile')){

        //     $file=$request->File("eventFile");
        //     $fileName=time().'_'.$request['fileName'].'.'.$file->getClientOriginalExtension();
        //     $request['eventId']=$event->id;
        //     $request['fileName']=$fileName;

        //     $file->move(\public_path("/storage"),$fileName);
        //     Eventfile::create($request->all());
        // }

        return back()->with('succes', 'impreza została zaktualizowana');

            
        
    
        // return redirect()->route('events.index')
        //     ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event=Event::findOrFail($id);

        $files=Eventfile::where('eventId', $event->id)->get(); 
        foreach($files as $file){
            if(File::exists("/storage/".$file->fileName)){
                File::delete("/storage/".$file->fileName);
            }

            $event->steps->each->delete();

            $event->delete();

        }
    
        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function fileDelete(Request $request)
    {
        $file=Eventfile::findOrFail($request->id);
        if(File::exists(public_path("storage/").$file->fileName)){
            File::delete(public_path("storage/").$file->fileName);
        }
    else{
        dd('File does not exists.');
      }
        $file->delete();
        return back()->with('success', 'Plik skasowany');

        // {  
        //     if(\File::exists(public_path('upload/avtar.png'))){
        //       \File::delete(public_path('upload/avtar.png'));
        //     }else{
        //       dd('File does not exists.');
        //     }
        //   } 

    }

    // Zmienić na bez $d Update

    public function eventElementUpdate(Request $request){

        $this->validate($request, [
            'elementId' => 'required',
        ]);
        $element = EventElement::find($request->elementId);
        // dd($request);    
        $element->update($request->all());

        return back();

    }

    public function eventElementStore(Request $request){
       $this->validate($request, [
        'element_name' => 'required',
    ]);
    $input = $request->except(['_token']);

    EventElement::create($input);


        return back();
    } 

    public function elementDelete($id){
        $element=EventElement::findOrFail($id);
        $element->delete();

        return back()->with('success', 'Punkt programu skasowany');

    }

    // ////////////////////////////////////// START - Obsługa plików ///////////////////////////////

    public function fileStore(Request $request){


        if($request->hasFile('eventFile')){

            $file=$request->File("eventFile");
            $fileName=time().'_'.$request['fileName'].'.'.$file->getClientOriginalExtension();
            $request['fileName']=$fileName;

            $file->move(\public_path("/storage"),$fileName);
            Eventfile::create($request->all());

            return back()->with('success', 'Plik został dodany');
        }

    }

    public function eventFileUpdate(Request $request){
        $input = $request->except(['_token']);

        $file=Eventfile::findOrFail($request->id);
        $file->update($input);

        $event = Event::find($request->eventId);
        $allHotels=Hotel::all();


            return back()->with('success', 'Plik został dodany');


        // return view('events.edit',compact('event','allHotels'));
    }



    // /////////////////////////// END - Obsługa plików ///////////////////////////////

    // public function downloadZip(Request $request)
    // {
    //     $zip = new ZipArchive;
   
    //     $fileName = 'plikiPilota.zip';

    //     $pilotFiles=DB::table('eventfiles')->where([['eventId','=',$request->eventId],
    // ['filePilotSet','=','tak']])->get();

    //     dd($pilotFiles);
   
    //     // if ($zip->open(\public_path("/storage")($fileName), ZipArchive::CREATE) === TRUE)
    //     // {
    //     //     $files = File::files(public_path('myFiles'));
   
    //     //     foreach ($files as $key => $value) {
    //     //         $relativeNameInZipFile = basename($value);
    //     //         $zip->addFile($value, $relativeNameInZipFile);
    //     //     }
             
    //     //     $zip->close();
    //     // }
    
    //     // return response()->download(public_path($fileName));

    //     return back();
    // }

    public function eventHotelStore(Request $request){


        $event=Event::findOrFail($request->event_id);
        $event->hotels()->attach($request->hotel_id, ['eventHotelNote'=>$request->eventHotelNote, 'eventHotelStartDate'=>$request->eventHotelStartDate,
        'eventHotelEndDate'=>$request->eventHotelEndDate,
        'eventHotelRooms'=>$request->eventHotelRooms], );
        return back()->with('success', 'Hotel został dodany');


    }

    public function eventHotelUpdate(Request $request){


        $event=Event::findOrFail($request->event_id);
        $event->hotels()->updateExistingPivot($request->hotel_id,[ 'eventHotelNote'=>$request->eventHotelNote, 'eventHotelStartDate'=>$request->eventHotelStartDate,
        'eventHotelEndDate'=>$request->eventHotelEndDate,
        'eventHotelRooms'=>$request->eventHotelRooms], );

        return back()->with('success', 'Hotel został dodany');





    }



    

    public function eventHotelDelete(Request $request){

        // dd($request);


        $event=Event::find($request->event_Id);


        $event->hotels()->where('eventHotelNote',$request)->detach($request->hotel_Id);
        return back();
        // $allHotels=Hotel::all();

        // return view('events.edit',compact('event','allHotels'));
    }










}