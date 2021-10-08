<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('clients.create') }}" class="mt-5 p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-sm rounded-sm focus:border-4 border-blue-300">{{ __('Create client') }}</a>
                    <x-alert></x-alert>
                    <div class="my-6">
                        <livewire:export /> 
                        <livewire:import /> 
                    </div>
                    <livewire:clients-filter /> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>