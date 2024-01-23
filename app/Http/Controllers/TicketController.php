<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Notifications\TickeUpdatedNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $default_txt ="Default Description";
        return view('ticket.create', ['default_txt' => $default_txt]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);
        if ($request->file('attachment')) {
            $this->storeAttachment($request, $ticket);
        }
        return redirect(route('ticket.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // return view('ticket.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {   
        $ticket->update($request->except('attachment'));

        if ($request->has('status')) {
            // $user = User::find($ticket->user_id);
            $ticket->user->notify(new TickeUpdatedNotification($ticket));
            // return (new TickeUpdatedNotification($ticket))->toMail($user);
        }

        if ($request->file('attachment')) {
            Storage::disk('public_uploads')->delete($ticket->attachment);
            $this->storeAttachment($request, $ticket);
        }

        return redirect(route('ticket.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        if ($ticket->attachment) {
            $user = User::find($ticket->user_id);
            $user->notify(new TickeUpdatedNotification($ticket));
            Storage::disk('public_uploads')->delete($ticket->attachment);
        }
        $ticket->delete();
        return redirect(route('ticket.index'));
    }

    protected function storeAttachment($request, $ticket) {
        $extension = $request->file('attachment')->extension();
        $content = file_get_contents($request->file('attachment'));
        $filename= Str::random(25);
        $path = "images/attachments/$filename.$extension";
        Storage::disk('public_uploads')->put($path, $content);
        $ticket->update(['attachment' => $path]);
    }
}
