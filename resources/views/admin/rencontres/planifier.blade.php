@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Planifier une rencontre</h2>
    <p class="mb-4">Utilisez le formulaire classique d'ajout de rencontre pour planifier un match. (À personnaliser selon vos besoins de planification avancée.)</p>
    <a href="{{ route('admin.rencontres.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter une rencontre</a>
</div>
@endsection
