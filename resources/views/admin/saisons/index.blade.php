@extends('layouts.admin')

@section('title', 'Gestion des Saisons')

@section('header')
    Gestion des Saisons
@endsection

@section('content')
<a href="{{ route('admin.dashboard') }}" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 border border-yellow-500 transition">← Retour</a>
<div class="mb-6">
    <a href="{{ route('admin.saisons.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 border border-green-700 transition">Nouvelle saison</a>
</div>

@if(session('success'))
    <x-alert type="success" :message="session('success')" />
@endif
@if(session('error'))
    <x-alert type="error" :message="session('error')" />
@endif
@if($errors->any())
    <x-alert type="error" :message="$errors->first()" />
@endif

<table class="min-w-full bg-bl-card rounded shadow table-fixed border border-bl-border">
    <thead>
        <tr>
            <th class="px-4 py-2 w-40 text-center text-white">Nom</th>
            <th class="px-4 py-2 w-32 text-center text-white">Début</th>
            <th class="px-4 py-2 w-32 text-center text-white">Fin</th>
            <th class="px-4 py-2 w-20 text-center text-white">Active</th>
        </tr>
    </thead>
    <tbody>
        @foreach($saisons as $saison)
        @php
            $rowClass = 'border-b border-bl-border text-center align-middle hover:bg-bl-dark transition cursor-pointer';
        @endphp
        <tr class="{{ $rowClass }}" onclick="window.location='{{ route('admin.saisons.show', $saison) }}'">
            <td class="px-4 py-2 font-semibold text-bl-accent underline">{{ $saison->nom }}</td>
            <td class="px-4 py-2 text-white">{{ $saison->date_debut }}</td>
            <td class="px-4 py-2 text-white">{{ $saison->date_fin }}</td>
            <td class="px-4 py-2">
                @if($saison->active)
                    <span class="text-green-500 font-bold">Oui</span>
                @else
                    <span class="text-bl-gray">Non</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
