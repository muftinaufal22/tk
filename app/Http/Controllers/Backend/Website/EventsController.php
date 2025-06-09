<?php

namespace App\Http\Controllers\Backend\Website;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Requests\EventRequest;
use ErrorException;
use Session;
use Str;

class EventsController extends Controller
{
    public function index()
    {
        $event = Events::all();
        return view('backend.website.content.event.index', compact('event'));
    }

    public function create()
    {
        return view('backend.website.content.event.create');
    }

    public function store(EventRequest $request)
    {
        try {
            // Create Slug
            $slug = Str::slug($request->title);

            $event = new Events;
            $event->title        = $request->title;
            $event->slug         = $slug;
            $event->desc         = $request->desc;
            $event->jenis_event  = $request->jenis_event;
            $event->acara        = $request->acara;
            $event->lokasi       = $request->lokasi;
            $event->is_active    = 0; // PERBAIKAN: Set langsung ke 0 (aktif)
            $event->save();

            Session::flash('success','Event Berhasil ditambah !');
            return redirect()->route('backend-event.index');
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $event = Events::find($id);
        return view('backend.website.content.event.edit', compact('event'));
    }

    public function update(EventRequest $request, $id)
    {
        try {
            $event = Events::find($id);
            $event->title        = $request->title;
            // $event->desc         = $request->desc;
            $event->jenis_event  = $request->jenis_event;
            $event->acara        = $request->acara ?? $event->acara;
            $event->lokasi       = $request->lokasi;
            // PERBAIKAN: Handle is_active dengan benar
            $event->is_active    = $request->has('is_Active') ? (int)$request->is_Active : $event->is_active;
            $event->save();

            Session::flash('success','Event Berhasil diupdate !');
            return redirect()->route('backend-event.index');
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $event = Events::findOrFail($id);
            $event->delete();
        
            Session::flash('success', 'Event berhasil dihapus!');
            return redirect()->route('backend-event.index');
        
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus event: ' . $e->getMessage());
            return redirect()->route('backend-event.index');
        }
    }
}