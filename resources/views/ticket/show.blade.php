<?php 
    use Carbon\Carbon;
    use App\Enums\TicketStatus;
    if (auth()->user()->isAdmin) {
        $tickets = DB::table('tickets')->latest()->get();
    } 
    else {
        $tickets = DB::table('tickets')->where('user_id', auth()->id())->latest()->get();
    }
?>
{{-- <x-app-layout> --}}
    <div class="flex flex-col space-y-5 sm:justify-center items-center sm:pt-0 m-auto">
        
        {{-- @if ($tickets->isEmpty())
            <div class="w-full sm:max-w-xl px-5 bg-black shadow-md overflow-hidden sm:rounded-lg p-2">
                <p>There is no tickets to show</p>
            </div>
        @else
            @foreach ($tickets as $ticket)
                <h1 class="mt-5 pt-6 text-black text-medium font-bold">{{$ticket->title}}</h1>
                <div class="w-full sm:max-w-xl px-5 bg-black shadow-md overflow-hidden sm:rounded-lg p-2">
                    <div class="text-black flex justify-between py-4">
                        <p>{{$ticket->description}}</p>
                        <p>{{Carbon::parse($ticket->created_at)->diffForHumans()}}</p>
                        @if ($ticket->attachment)
                            {{-- <img src="{{$ticket->attachment}}" alt="Attachment"/> --}}
                            {{-- <a href="{{$ticket->attachment}}">Attachment</a>
                        @endif
                    </div>
                    <div class="flex justify-between p-2">
                        <a href="{{route('ticket.edit', $ticket->id)}}">
                            <x-primary-button >Edit</x-primary-button>
                        </a>
                        <form method="post" action="{{route('ticket.destroy', $ticket->id)}}">
                            @method('delete')
                            @csrf
                            <x-primary-button >Delete</x-primary-button>
                        </form>
                    </div>
                    <div class="flex justify-between p-2">
                        <a href="{{route('ticket.edit', $ticket->id)}}">
                            <x-primary-button >Approve</x-primary-button>
                        </a>
                        <form method="post" action="{{route('ticket.destroy', $ticket->id)}}">
                            @method('delete')
                            @csrf
                            <x-primary-button >Reject</x-primary-button>
                        </form>
                    </div>
                </div>  
            @endforeach
        @endif --}}
        

        @forelse ($tickets as $ticket)
            <div class="w-full sm:max-w-xl px-5 bg-black shadow-md overflow-hidden sm:rounded-lg p-2">
                <h1 class="mt-2 pt-3 text-black text-medium font-bold">Ticket: {{$ticket->title}}</h1>
                <?php
                    $user = DB::table('users')->where('id', $ticket->user_id)->get()->first();
                ?>
                @if(auth()->user()->isAdmin)
                    <h2 class="mt-2 pt-3 text-black text-medium font-bold">Author: {{$user->name}}</h2>
                @endif
                <div class="text-black flex justify-between py-4">
                    <p>{{$ticket->description}}</p>
                    <p>{{Carbon::parse($ticket->created_at)->diffForHumans()}}</p>
                    @if ($ticket->attachment)
                        {{-- <img src="{{$ticket->attachment}}" alt="Attachment"/> --}}
                        <a href="{{$ticket->attachment}}">Attachment</a>
                    @endif
                </div>

                <div class="flex justify-between p-2">
                    <a href="{{route('ticket.edit', $ticket->id)}}">
                        <x-primary-button >Edit</x-primary-button>
                    </a>
                    <form method="post" action="{{route('ticket.destroy', $ticket->id)}}">
                        @method('delete')
                        @csrf
                        <x-primary-button >Delete</x-primary-button>
                    </form>
                </div>
                <div class="flex justify-between p-2">
                    @if(auth()->user()->isAdmin)
                        @switch ($ticket->status)
                            @case(TicketStatus::OPEN->value)
                                <form action="{{route('ticket.update', $ticket->id)}}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="status"  value="{{TicketStatus::RESOLVED}}"/>
                                    <x-primary-button >Approve</x-primary-button>
                                </form>
                                
                                <form method="post" action="{{route('ticket.destroy', $ticket->id)}}">
                                    @method('delete')
                                    @csrf
                                    <x-primary-button >Reject</x-primary-button>
                                </form>
                                @break
                            
                            @case(TicketStatus::RESOLVED->value)
                                <form method="post" action="{{route('ticket.destroy', $ticket->id)}}">
                                    @method('delete')
                                    @csrf
                                    <x-primary-button >Reject</x-primary-button>
                                </form>
                                @break
                        @endswitch
                    @endif
                    <p class="text-black">Status: {{$ticket->status}}</p>
                </div>  
            </div>
        
        @empty
            <div class="w-full sm:max-w-xl px-5 bg-black shadow-md overflow-hidden sm:rounded-lg p-2">
                <p>There is no tickets to show</p>
            </div>
        @endforelse

    </div>
{{-- </x-app-layout> --}}