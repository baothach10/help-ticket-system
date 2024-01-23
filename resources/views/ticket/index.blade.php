<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h1 class="text-xl text-center font-bold mb-6">Support Tickets</h1>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col space-y-5 ">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    @include('ticket.show')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
