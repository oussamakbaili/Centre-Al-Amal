<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MarquerAbsents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:marquer-absents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $seances = Seance::where('heure_fin', '<=', now())->get();

    foreach ($seances as $seance) {
        $etudiants = $seance->etudiants;

        foreach ($etudiants as $etudiant) {
            $alreadyPresent = Presence::where('etudiant_id', $etudiant->id)
                ->where('seance_id', $seance->id)
                ->exists();

            if (!$alreadyPresent) {
                Presence::create([
                    'etudiant_id' => $etudiant->id,
                    'seance_id' => $seance->id,
                    'etat' => 'absent'
                ]);
            }
        }
    }

    $this->info("Absents marqués avec succès.");
}
}
