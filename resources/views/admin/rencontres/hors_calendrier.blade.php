@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Ajouter un match hors calendrier</h2>
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 shadow">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 shadow">
            {{ $errors->first() }}
        </div>
    @endif
    <form action="{{ route('admin.rencontres.horscalendrier') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold text-gray-900 dark:text-gray-100 mb-1">Équipe 1 (libre)</label>
            <input type="text" name="equipe1_libre" class="form-input w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold text-gray-900 dark:text-gray-100 mb-1">Équipe 2 (libre)</label>
            <input type="text" name="equipe2_libre" class="form-input w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold text-gray-900 dark:text-gray-100 mb-1">Date</label>
            <input type="date" name="date" class="form-input w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold text-gray-900 dark:text-gray-100 mb-1">Heure</label>
            <input type="time" name="heure" class="form-input w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold text-gray-900 dark:text-gray-100 mb-1">Stade (personnalisé)</label>
            <input type="text" name="stade" class="form-input w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" required>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Ajouter le match</button>
    </form>
</div>
@endsection
