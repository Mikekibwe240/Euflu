@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Utilisateurs</h2>
    <a href="{{ route('admin.users.create') }}" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter un utilisateur</a>
    <button onclick="window.history.back()" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour</button>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 border border-green-300 dark:bg-green-900 dark:text-green-200 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4 border border-red-300 dark:bg-red-900 dark:text-red-200 dark:border-red-700">
            {{ session('error') }}
        </div>
    @endif
    <div class="mb-4 flex flex-wrap gap-4 items-end">
        <input type="text" id="search-users" placeholder="Recherche rapide..." class="form-input w-64 rounded border-gray-300 dark:bg-gray-700 dark:text-white" />
    </div>
    <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow text-gray-900 dark:text-gray-100 users-table table-fixed">
        <thead>
            <tr>
                <th class="px-4 py-2 w-1/4 text-left">Nom</th>
                <th class="px-4 py-2 w-1/4 text-left">Email</th>
                <th class="px-4 py-2 w-1/4 text-left">Rôle</th>
                <th class="px-4 py-2 w-1/4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-t border-gray-200 dark:border-gray-700 align-middle">
                    <td class="px-4 py-2 align-middle break-words">{{ $user->name }}</td>
                    <td class="px-4 py-2 align-middle break-words">{{ $user->email }}</td>
                    <td class="px-4 py-2 align-middle break-words">
                        {{ $user->roles->pluck('name')->implode(', ') }}
                    </td>
                    <td class="px-4 py-2 align-middle flex gap-2 flex-wrap">
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Modifier</a>
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
    <div class="mt-4">
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
