<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Page d'accueil - Liste de toutes les tâches
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

// Routes pour la création de tâches
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Route pour basculer l'état d'une tâche (terminée/non terminée)
Route::patch('/tasks/{id}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

// Route pour supprimer une tâche
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Routes bonus pour l'édition (optionnel)
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
