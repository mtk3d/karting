@extends('layouts.app')

@section('title', 'Create Reservation')

@section('content')
<div class="max-w-2xl self-center w-1/2">
    <div class="p-6">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            ➕ Create Reservation
        </h2>
    </div>
    <div class="-my-2 overflow-x-auto">
        <div class="p-6">
            <form method="POST" action="/reservation/create" class="grid grid-cols-1 gap-6">
                @csrf
                <input type="hidden" name="uuid" value="{{ $uuid }}">
                <label class="block">
                    <span class="text-gray-700"><span class="mr-2">⏱️</span>From</span>
                    <input type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="from" required>
                </label>
                <label class="block">
                    <span class="text-gray-700"><span class="mr-2">🏁</span>To</span>
                    <input type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="to" required>
                </label>
                <label class="block">
                    <span class="text-gray-700"><span class="mr-2">🛣️</span>Select track</span>
                    <select class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="track_id" required>
                        @foreach($tracks as $track)
                            <option value="{{ $track->uuid }}">{{ $track->name }} - {{ $track->description }} - {{ $track->price }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <span class="text-gray-700"><span class="mr-2">🏎️</span>Select karts</span>
                    <select class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="karts_ids[]" multiple required>
                        @foreach($karts as $kart)
                            <option value="{{ $kart->uuid }}">{{ $kart->name }} - {{ $kart->description }} - {{ $kart->price }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <button type="submit" class="py-2 px-4 rounded-lg shadow focus:outline-none">
                        <span class="mr-2">💾</span>Reserve
                    </button>
                    <a href="/reservation" class="py-3 px-4 rounded-lg shadow focus:outline-none">
                        <span class="mr-2">🔙</span>Back
                    </a>
                </label>
            </form>
        </div>
    </div>
</div>
@endsection
