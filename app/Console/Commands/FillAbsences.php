<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Presence;
use App\Models\Absence;
use App\Models\Seance;
use App\Models\EmploiDuTemps;
use App\Models\Etudiant;
use Carbon\Carbon;

class FillAbsences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absences:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill absences table for students who were not present in sessions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->processSeances();
        $this->processEmploiDuTemps();
        
        $this->info('Absences have been filled successfully!');
    }

    private function processSeances()
    {
        // Get all seances that have ended
        $endedSeances = Seance::where('date', '<=', now()->toDateString())
            ->where('heure_fin', '<', now()->toTimeString())
            ->get();

        foreach ($endedSeances as $seance) {
            // Get all students who should have been present
            $allStudents = Etudiant::all();
            
            // Get students who were present
            $presentStudents = Presence::where('seance_id', $seance->id)
                ->where('type', 'seance')
                ->where('date', $seance->date)
                ->pluck('etudiant_id');

            // For each student who wasn't present, create an absence record
            foreach ($allStudents as $student) {
                if (!$presentStudents->contains($student->id)) {
                    Absence::firstOrCreate([
                        'etudiant_id' => $student->id,
                        
                        'type' => 'Étudiant',
                        'date_absence' => $seance->date,
                        'module_id' => $seance->module_id,
                        'heure_cours' => $seance->heure_debut,
                        'etat' => 'Non justifié'
                    ]);
                }
            }
        }
    }

    private function processEmploiDuTemps()
    {
        // Get today's day name in French
        $today = now()->locale('fr')->dayName;
        
        // Get all emploi entries for today that have ended
        $endedEmplois = EmploiDuTemps::where('jour', $today)
            ->where('heure_fin', '<', now()->toTimeString())
            ->get();

        foreach ($endedEmplois as $emploi) {
            // Get all students who should have been present
            $allStudents = Etudiant::all();
            
            // Get students who were present
            $presentStudents = Presence::where('emploi_du_temps_id', $emploi->id)
                ->where('type', 'emploi')
                ->where('date', now()->toDateString())
                ->pluck('etudiant_id');

            // For each student who wasn't present, create an absence record
            foreach ($allStudents as $student) {
                if (!$presentStudents->contains($student->id)) {
                    Absence::firstOrCreate([
                        'etudiant_id' => $student->id,
                        'type' => 'Étudiant',
                        'date_absence' => now()->toDateString(),
                        'module_id' => $emploi->module_id,
                        'heure_cours' => $emploi->heure_debut,
                        'emploi_id' => $emploi->id,
                        'etat' => 'Non justifié'
                    ]);
                }
            }
        }
    }
}
