<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Afficher la liste de toutes les tâches
     */
    public function index()
    {
        try {
            $tasks = Task::orderBy('created_at', 'desc')->get();
            return view('welcome', compact('tasks'));

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des tâches: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du chargement des tâches.');
        }
    }

    /**
     * Afficher le formulaire de création d'une nouvelle tâche
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Enregistrer une nouvelle tâche dans la base de données
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            Task::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'completed' => false
            ]);

            return redirect()->route('tasks.index')
                ->with('success', 'Tâche créée avec succès!');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la tâche: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la création de la tâche.');
        }
    }

    /**
     * Basculer l'état d'une tâche (terminée/non terminée)
     */
    public function toggle($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->completed = !$task->completed;
            $task->save();

            return redirect()->route('tasks.index')
                ->with('success', 'Statut de la tâche mis à jour!');

        } catch (\Exception $e) {
            Log::error('Erreur lors du changement de statut: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la tâche.');
        }
    }

    /**
     * Supprimer une tâche
     */
    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return redirect()->route('tasks.index')
                ->with('success', 'Tâche supprimée avec succès!');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression de la tâche.');
        }
    }

    /**
     * Afficher le formulaire d'édition d'une tâche
     */
    public function edit($id)
    {
        try {
            $task = Task::findOrFail($id);
            return view('tasks.edit', compact('task'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'édition: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tâche non trouvée.');
        }
    }

    /**
     * Mettre à jour une tâche existante
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $task = Task::findOrFail($id);
            $task->update($validatedData);

            return redirect()->route('tasks.index')
                ->with('success', 'Tâche mise à jour avec succès!');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la tâche.');
        }
    }
}
