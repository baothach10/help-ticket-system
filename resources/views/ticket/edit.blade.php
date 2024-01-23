<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-black text-lg font-bold">Update Support Ticket</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{route('ticket.update', $ticket->id)}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="mt-4">
                    <x-input-label for='title' :value="__('Title')"/>
                    <x-text-input value="{{$ticket->title}}" id='title' class='block mt-1 w-full' type='text' name='title' autofocus/>
                    <x-input-error :messages="$errors->get('title')" class='mt-2'/>
                </div>

                <div class="mt-4">
                    <x-input-label for='description' :value="__('Description')"/>
                    <x-textarea default="{{$ticket->description}}" name="description" id="description" />
                    <x-input-error :messages="$errors->get('description')" class='mt-2'/>
                </div>

                <div class="mt-4">
                    <x-input-label for='attachment' :value="__('Current Attachment')"/>
                    @if (empty($ticket->attachment))
                        <x-file-input name='attachment' id='attachment'/>
                        <x-input-error :messages="$errors->get('attachment')" class='mt-2'/>
                    @else
                        <a href="{{'../../'.$ticket->attachment}}">See Attachment</a>
                        {{-- <img src="{{'../../'.$ticket->attachment}}" alt="Current Ticket Image"> --}}
                        <x-file-input name='attachment' id='attachment'/>
                        <x-input-error :messages="$errors->get('attachment')" class='mt-2'/>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-4">        
                    <x-primary-button class="ms-3">
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>