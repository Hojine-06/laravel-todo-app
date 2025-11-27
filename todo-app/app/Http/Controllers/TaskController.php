<?php

namespace App\Http\Controllers;

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
            // Version PROVISOIRE avec données fictives - AUCUNE erreur
            $tasks = $this->getTasks();
            return view('tasks.index', compact('tasks'));

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des tâches: ' . $e->getMessage());
            return view('tasks.index', ['tasks' => []]);
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
            // Validation des données du formulaire
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            // Simulation pour le moment - sera remplacé par le vrai modèle
            Log::info('Tâche simulée créée: ' . $validatedData['title']);

            return redirect()->route('tasks.index')
                ->with('success', 'Tâche créée avec succès! (Mode simulation)');

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
            // Simulation du toggle
            Log::info("Toggle simulé pour la tâche ID: $id");

            return redirect()->route('tasks.index')
                ->with('success', 'Statut de la tâche mis à jour! (Mode simulation)');

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
            // Simulation de suppression
            Log::info("Suppression simulée de la tâche ID: $id");

            return redirect()->route('tasks.index')
                ->with('success', 'Tâche supprimée avec succès! (Mode simulation)');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression de la tâche.');
        }
    }

    /**
     * Afficher le formulaire d'édition d'une tâche (Bonus)
     */
    public function edit($id)
    {
        try {
            // Simulation - données fictives pour l'édition
            $task = $this->getMockTask($id);
            return view('tasks.edit', compact('task'));

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'édition: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tâche non trouvée.');
        }
    }

    /**
     * Mettre à jour une tâche existante (Bonus)
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            // Simulation de mise à jour
            Log::info("Mise à jour simulée de la tâche ID: $id - " . $validatedData['title']);

            return redirect()->route('tasks.index')
                ->with('success', 'Tâche mise à jour avec succès! (Mode simulation)');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la tâche.');
        }
    }

    /**
     * Méthode privée pour obtenir les tâches (simulation)
     */
    private function getTasks()
    {
        // Données fictives pour le développement
        return [
            (object)[
                'id' => 1,
                'title' => 'Tâche exemple 1',
                'description' => 'Description de test - modèle Task pas encore créé',
                'completed' => false,
                'created_at' => now()
            ],
            (object)[
                'id' => 2,
                'title' => 'Tâche exemple 2',
                'description' => 'Une autre tâche test - en attente du modèle',
                'completed' => true,
                'created_at' => now()->subHour()
            ],
            (object)[
                'id' => 3,
                'title' => 'Tâche exemple 3',
                'description' => 'Le modèle Task sera créé par un autre membre',
                'completed' => false,
                'created_at' => now()->subMinutes(30)
            ]
        ];
    }

    /**
     * Méthode privée pour simuler une tâche unique
     */
    private function getMockTask($id)
    {
        return (object)[
            'id' => $id,
            'title' => 'Tâche exemple ' . $id,
            'description' => 'Description simulée pour l\'édition',
            'completed' => false,
            'created_at' => now()
        ];
    }
}
