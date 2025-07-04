@extends('layouts.admin')
@section('title', 'TOPS BUTEURS')
@section('content')
<div class="container mx-auto py-8">
    <div class="mb-6 flex justify-start">
        <a href="/admin/classement" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded shadow transition">&larr; Retour</a>
    </div>
    <h1 class="text-3xl font-bold mb-8 text-center text-yellow-600 dark:text-yellow-300">TOPS BUTEURS - Pool {{ $pool->nom }}</h1>
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white dark:bg-gray-900 text-sm">
            <thead class="bg-yellow-100 dark:bg-yellow-900">
                <tr>
                    <th class="px-2 py-2">PL</th>
                    <th class="px-2 py-2 text-left">Joueur</th>
                    <th class="px-2 py-2 text-left">Photo</th>
                    <th class="px-2 py-2 text-left">Équipe</th>
                    <th class="px-2 py-2">Buts</th>
                    <th class="px-2 py-2">Matchs</th>
                    <th class="px-2 py-2">Ratio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buteurs as $index => $buteur)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition cursor-pointer" onclick="window.location='{{ route('admin.joueurs.show', $buteur->id) }}'">
                    <td class="text-center font-bold">{{ $index + 1 }}</td>
                    <td class="font-semibold text-gray-800 dark:text-gray-100">
                        <a href="{{ route('admin.joueurs.show', $buteur->id) }}" class="hover:underline">{{ $buteur->nom }} {{ $buteur->prenom }}</a>
                    </td>
                    <td>
                        @if($buteur->photo)
                            <img src="{{ asset('storage/'.$buteur->photo) }}" alt="Photo" class="h-10 w-10 rounded-full object-cover bg-gray-200 border border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td class="flex items-center gap-2">
                        @if($buteur->equipe)
                            <x-team-logo :team="$buteur->equipe" :size="24" />
                        @else
                            <span class="h-6 w-6 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-5 w-5">
                                    <path d="M12 2C7.03 2 2.5 6.03 2.5 11c0 4.97 4.53 9 9.5 9s9.5-4.03 9.5-9c0-4.97-4.53-9-9.5-9zm0 16c-3.87 0-7-3.13-7-7 0-3.87 3.13-7 7-7s7 3.13 7 7c0 3.87-3.13 7-7 7z"/>
                                </svg>
                            </span>
                        @endif
                        <span>{{ $buteur->equipe->nom ?? '-' }}</span>
                    </td>
                    <td class="text-center font-bold text-yellow-600 dark:text-yellow-300">{{ $buteur->buts_count ?? 0 }}</td>
                    <td class="text-center text-gray-700 dark:text-gray-200">
                        @php
                            $matchs = $buteur->buts ? $buteur->buts->pluck('rencontre_id')->unique()->count() : 0;
                        @endphp
                        {{ $matchs }}
                    </td>
                    <td class="text-center text-gray-700 dark:text-gray-200">
                        @php
                            $ratio = ($matchs > 0) ? round(($buteur->buts_count ?? 0) / $matchs, 2) : 0;
                        @endphp
                        {{ $ratio }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
