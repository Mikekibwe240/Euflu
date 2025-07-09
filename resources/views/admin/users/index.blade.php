@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-bl-accent">Utilisateurs</h2>
    <div class="flex flex-wrap gap-4 mb-4">
        <a href="{{ route('admin.users.create') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Ajouter un utilisateur</a>
        <button onclick="window.history.back()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
    </div>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" class="mb-4" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" class="mb-4" />
    @endif
    <div class="mb-4 flex flex-wrap gap-4 items-end">
        <input type="text" id="search-users" placeholder="Recherche rapide..." class="form-input w-64 rounded border-bl-border bg-gray-800 text-white" />
    </div>
    <table class="min-w-full bg-bl-card text-white rounded shadow users-table table-fixed border border-bl-border">
        <thead class="bg-[#23272a]">
            <tr>
                <th class="px-4 py-2 w-1/4 text-left text-white">Nom</th>
                <th class="px-4 py-2 w-1/4 text-left text-white">Email</th>
                <th class="px-4 py-2 w-1/4 text-left text-white">Rôle</th>
                <th class="px-4 py-2 w-1/4 text-left text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-t border-bl-border align-middle hover:bg-bl-dark transition">
                    <td class="px-4 py-2 align-middle break-words">{{ $user->name }}</td>
                    <td class="px-4 py-2 align-middle break-words">{{ $user->email }}</td>
                    <td class="px-4 py-2 align-middle break-words">
                        {{ $user->roles->pluck('name')->implode(', ') }}
                    </td>
                    <td class="px-4 py-2 align-middle flex gap-2 flex-wrap">
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 border border-yellow-500 transition">Modifier</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4">Aucun utilisateur trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4 flex justify-center">
        {{ $users->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('search-users').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.users-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
@endsection
