@extends('layouts.app')

@section('title', 'Tracks')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            🏁 Tracks
        </h2>
    </div>
    <div class="-my-2 overflow-x-auto">
        <div class="p-6">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Slots
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Enabled
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Manage</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($tracks as $track)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $track->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $track->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $track->slots }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($track->enabled)
                                    ✅
                                @else
                                    🛑
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{ $track->price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button class="text-indigo-600 hover:text-indigo-900">Remove</button>
                                @if ($track->enabled)
                                    <button class="text-indigo-600 hover:text-indigo-900">Disable</button>
                                @else
                                    <button class="text-indigo-600 hover:text-indigo-900">Enable</button>
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
        <a href="/track/create" class="py-3 px-4 rounded-lg shadow focus:outline-none">
            <span class="mr-2">➕</span>Add track
        </a>
    </div>
@endsection
