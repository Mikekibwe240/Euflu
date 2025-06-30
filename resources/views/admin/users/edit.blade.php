@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Modifier l'utilisateur</h2>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block font-semibold">Nom</label>
            <input type="text" name="name" id="name" class="form-input w-full" value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="email" class="block font-semibold">Email</label>
            <input type="email" name="email" id="email" class="form-input w-full" value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password" class="block font-semibold">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" id="password" class="form-input w-full">
            @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password_confirmation" class="block font-semibold">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input w-full">
        </div>
        <div>
            <label for="role" class="block font-semibold">Rôle</label>
            <select name="role" id="role" class="form-select w-full" required>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ (old('role', $user->roles->first()?->name) == $role) ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                @endforeach
            </select>
            @error('role')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex gap-4 items-center">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
            <a href="{{ route('admin.users.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </div>
    </form>
</div>
@endsection
