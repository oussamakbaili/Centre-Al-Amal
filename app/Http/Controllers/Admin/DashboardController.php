<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Module;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Emploidutemps;
use App\Models\Preinscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $nombreEtudiants = Etudiant::count();
        $nombreEnseignants = Enseignant::count();
        $nombreModules = Module::count();
        $nombreNotes = Note::count();
        $nombreAbsences = Absence::count();
        $nombreEmploidutemps = Emploidutemps::count();
        $nombrePreinscriptions = Preinscription::count();

        // Recent activities (last 7 days)
        $recentStudents = Etudiant::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $recentAbsences = Absence::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $recentNotes = Note::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // Today's statistics
        $todayAbsences = Absence::whereDate('created_at', Carbon::today())->count();
        $todaySchedules = Emploidutemps::whereDate('jour', Carbon::today())->count();

        // Monthly trends
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;
        
        $currentMonthStudents = Etudiant::whereMonth('created_at', $currentMonth)->count();
        $lastMonthStudents = Etudiant::whereMonth('created_at', $lastMonth)->count();
        
        $studentGrowth = $lastMonthStudents > 0 ? 
            round((($currentMonthStudents - $lastMonthStudents) / $lastMonthStudents) * 100, 1) : 0;

        // Recent activities for timeline
        $recentActivities = collect();
        
        // Recent students
        $newStudents = Etudiant::latest()->take(3)->get()->map(function($student) {
            return [
                'type' => 'student',
                'message' => "Nouvel étudiant inscrit: {$student->nom} {$student->prenom}",
                'time' => $student->created_at,
                'icon' => 'fas fa-user-plus',
                'color' => 'blue'
            ];
        });

        // Recent absences
        $newAbsences = Absence::with(['etudiant'])->latest()->take(2)->get()->map(function($absence) {
            $etudiantNom = $absence->etudiant ? $absence->etudiant->nom : 'Étudiant';
            $etudiantPrenom = $absence->etudiant ? $absence->etudiant->prenom : '';
            return [
                'type' => 'absence',
                'message' => "Absence signalée: {$etudiantNom} {$etudiantPrenom}",
                'time' => $absence->created_at,
                'icon' => 'fas fa-calendar-times',
                'color' => 'red'
            ];
        });

        // Recent notes
        $newNotes = Note::with(['etudiant', 'module'])->latest()->take(2)->get()->map(function($note) {
            $etudiantNom = $note->etudiant ? $note->etudiant->nom : 'Étudiant';
            $moduleNom = $note->module ? $note->module->nom : 'Module';
            return [
                'type' => 'note',
                'message' => "Note ajoutée: {$etudiantNom} - {$moduleNom}",
                'time' => $note->created_at,
                'icon' => 'fas fa-clipboard-list',
                'color' => 'green'
            ];
        });

        $recentActivities = $recentActivities->concat($newStudents)
                                           ->concat($newAbsences)
                                           ->concat($newNotes)
                                           ->sortByDesc('time')
                                           ->take(5);

        // Performance metrics
        $averageGrade = Note::avg('note');
        if ($averageGrade === null) {
            $averageGrade = 0;
        }
        $totalNotes = Note::count();
        $passRate = $totalNotes > 0 ? (Note::where('note', '>=', 10)->count() / $totalNotes * 100) : 0;
        $attendanceRate = $nombreEtudiants > 0 ? (100 - (Absence::count() / ($nombreEtudiants * 30) * 100)) : 100;

        return view('admin.dashboard', compact(
            'nombreEtudiants',
            'nombreEnseignants', 
            'nombreModules',
            'nombreNotes',
            'nombreAbsences',
            'nombreEmploidutemps',
            'nombrePreinscriptions',
            'recentStudents',
            'recentAbsences',
            'recentNotes',
            'todayAbsences',
            'todaySchedules',
            'studentGrowth',
            'recentActivities',
            'averageGrade',
            'passRate',
            'attendanceRate'
        ));
    }
}
