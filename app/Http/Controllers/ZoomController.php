<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\ZoomServiceProvider as ZoomService;
use Carbon\Carbon;
use DateTime;

class ZoomController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function createMeeting(){
        return view('createMeeting');
    }

    public function showMeeting($meetingId)
    {
        $meeting = $this->zoomService->getMeeting($meetingId);
        
        // Genera la firma para unirte a la reunión
        $signature = $this->zoomService->generateSignature($meeting['id']);

        // Pasa la firma y otros datos necesarios a la vista
        return view('meeting', compact('meeting', 'signature'));
    }

    public function createMeetingStore(Request $request)
    {

        $data = [
            'topic' => $request->input('topic'),
            'type' => $request->input('type'), // Tipo de reunión programada
            'start_time' => Carbon::parse($request->input('start_time'))->format('Y-m-d\TH:i:s\Z'),            'duration' => $request->input('duration'),
            'timezone' => $request->input('timezone'),
            'agenda' => $request->input('agenda'),
        ];


        $meeting = $this->zoomService->createMeeting($data);

        //dd($meeting);

        $topic = $meeting['topic'];
        $host_email = $meeting['host_email'];
        $start_url = $meeting['start_url'];
        $join_url = $meeting['join_url'];
        $duration = $meeting['duration'];
        //$start_time = $meeting['start_time'];
        //$start_time = new DateTime($meeting['start_time']);

        // Pasamos la fecha y hora a un objeto Carbon
        $startTime = Carbon::parse($meeting['start_time']);

        // Formatear la fecha y hora como cadena
        $formattedTime = $startTime->format('Y-m-d H:i:s');

        // Ahora puedes usar $formattedTime con htmlspecialchars() para pasarlo a un string seguro
        $safeTime = htmlspecialchars($formattedTime, ENT_QUOTES, 'UTF-8');

        //return response()->json($meeting);
        return view('informationMeeting',compact('topic','host_email','start_url','join_url','duration','safeTime'));
    }
}
