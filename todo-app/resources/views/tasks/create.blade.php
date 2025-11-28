@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto fade-in-up">
    <div class="glass rounded-2xl p-8 card-3d">
        <!-- En-tête -->
        <div class="mb-8">
            <a href="{{ route('tasks.index') }}" 
               class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium mb-4 transition-colors">
                <span class="mr-2">←</span>
                <span>Retour aux tâches</span>
            </a>
            
            <h2 class="text-3xl font-bold text-gray-800 mb-2">✨ Créer une nouvelle tâche</h2>
            <p class="text-gray-500">Ajoutez les détails de votre prochaine tâche</p>
        </div>

        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Champ Titre -->
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-2">
                    Titre de la tâche <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required
                           autofocus
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all outline-none text-gray-800 font-medium"
                           placeholder="Ex: Préparer la présentation du projet"
                           value="{{ old('title') }}">
                    <div class="absolute right-3 top-3 text-2xl">📝</div>
                </div>
                @error('title')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <span class="mr-1">⚠️</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Champ Description -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="6"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all outline-none text-gray-800 resize-none"
                          placeholder="Ajoutez des détails sur cette tâche... (optionnel)">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <span class="mr-1">⚠️</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('tasks.index') }}" 
                   class="btn-3d bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-3 rounded-xl font-semibold transition-all">
                    Annuler
                </a>
                
                <button type="submit" 
                        class="btn-3d bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-3 rounded-xl font-semibold flex items-center space-x-2">
                    <span>✨</span>
                    <span>Créer la tâche</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Conseils -->
    <div class="glass rounded-xl p-6 mt-6 card-3d">
        <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
            <span class="mr-2">💡</span>
            Conseils pour une bonne tâche
        </h4>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Utilisez un titre clair et actionnable</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Ajoutez des détails dans la description pour ne rien oublier</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Décomposez les grandes tâches en sous-tâches plus petites</span>
            </li>
        </ul>
    </div>
</div>

<script>
    // Animation au focus du champ titre
    document.getElementById('title').addEventListener('focus', function() {
        this.parentElement.classList.add('scale-105');
        this.parentElement.style.transition = 'transform 0.3s ease';
    });

    document.getElementById('title').addEventListener('blur', function() {
        this.parentElement.classList.remove('scale-105');
    });
</script>
@endsection