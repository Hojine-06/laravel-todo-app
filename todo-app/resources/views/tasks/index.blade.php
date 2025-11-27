@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto fade-in-up">
    <!-- En-tête avec statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="glass rounded-xl p-6 card-3d">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $tasks->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">📊</span>
                </div>
            </div>
        </div>

        <div class="glass rounded-xl p-6 card-3d">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">En cours</p>
                    <p class="text-3xl font-bold text-orange-500 mt-1">{{ $tasks->where('completed', false)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="glass rounded-xl p-6 card-3d">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Terminées</p>
                    <p class="text-3xl font-bold text-green-500 mt-1">{{ $tasks->where('completed', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">✅</span>
                </div>
            </div>
        </div>

        <div class="glass rounded-xl p-6 card-3d">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Progression</p>
                    <p class="text-3xl font-bold text-purple-500 mt-1">
                        {{ $tasks->count() > 0 ? round(($tasks->where('completed', true)->count() / $tasks->count()) * 100) : 0 }}%
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">🎯</span>
                </div>
            </div>
        </div>
    </div>

    <!-- En-tête avec bouton d'ajout -->
    <div class="glass rounded-xl p-6 mb-6 card-3d">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Mes Tâches</h2>
                <p class="text-gray-500 mt-1">Gérez vos tâches efficacement</p>
            </div>
            <a href="{{ route('tasks.create') }}" 
               class="btn-3d bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold flex items-center space-x-2 shadow-lg">
                <span class="text-xl">➕</span>
                <span>Nouvelle tâche</span>
            </a>
        </div>
    </div>

    @if($tasks->isEmpty())
        <!-- État vide avec illustration -->
        <div class="glass rounded-2xl p-12 text-center card-3d">
            <div class="max-w-md mx-auto">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-6xl">📝</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Aucune tâche pour le moment</h3>
                <p class="text-gray-500 mb-6">Commencez par créer votre première tâche et organisez votre journée !</p>
                <a href="{{ route('tasks.create') }}" 
                   class="btn-3d inline-flex items-center space-x-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-semibold">
                    <span>✨</span>
                    <span>Créer ma première tâche</span>
                </a>
            </div>
        </div>
    @else
        <!-- Liste des tâches style Trello -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tasks as $index => $task)
                <div class="glass rounded-xl p-6 card-3d task-card" style="animation-delay: {{ $index * 0.1 }}s">
                    <!-- En-tête de la carte -->
                    <div class="flex items-start justify-between mb-4">
                        <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="checkbox-3d {{ $task->completed ? 'checked' : '' }}"></button>
                        </form>

                        <form action="{{ route('tasks.destroy', $task->id) }}" 
                              method="POST" 
                              class="ml-auto"
                              onsubmit="return confirm('Supprimer cette tâche ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-8 h-8 rounded-lg hover:bg-red-100 flex items-center justify-center transition-all group">
                                <span class="text-gray-400 group-hover:text-red-500 transition-colors">🗑️</span>
                            </button>
                        </form>
                    </div>

                    <!-- Contenu de la carte -->
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 {{ $task->completed ? 'line-through opacity-50' : '' }}">
                            {{ $task->title }}
                        </h3>
                        
                        @if($task->description)
                            <p class="text-gray-600 text-sm leading-relaxed {{ $task->completed ? 'line-through opacity-50' : '' }}">
                                {{ Str::limit($task->description, 100) }}
                            </p>
                        @endif
                    </div>

                    <!-- Footer de la carte -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                            <span>🕐</span>
                            <span>{{ $task->created_at->diffForHumans() }}</span>
                        </div>
                        
                        @if($task->completed)
                            <span class="priority-badge bg-green-100 text-green-700">
                                ✅ Terminée
                            </span>
                        @else
                            <span class="priority-badge bg-orange-100 text-orange-700">
                                ⏳ En cours
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
