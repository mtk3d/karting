@extends('layouts.app')

@section('title', 'Reservations')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            📄 Reservations
        </h2>
    </div>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 px-6">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            📅 Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ✅ Confirmed
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            🛣️ Track
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            💰 Price
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Pay</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($reservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservation->from }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ __("reservation.$reservation->status") }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservation->track->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservation->price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if ($reservation->paid)
                                    <button class="text-indigo-600 hover:text-indigo-900 disabled:opacity-50" disabled>💳 Pay</button>
                                @else
                                    <button class="text-indigo-600 hover:text-indigo-900">💳 Pay</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="p-6">
        <button class="py-2 px-4 rounded-lg shadow focus:outline-none">
            ➕ Add reservation
        </button>
    </div>
@endsection
