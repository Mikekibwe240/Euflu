@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4 max-w-xl">
    <h2 class="text-2xl font-bold mb-6">Mon profil</h2>
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nom</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nouveau mot de passe <span class="text-xs text-gray-400">(laisser vide pour ne pas changer)</span></label>
                <input type="password" name="password" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
