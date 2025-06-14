<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PreinscriptionController;
use App\Http\Controllers\Admin\EtudiantController;
use App\Http\Controllers\Admin\EnseignantController;
use App\Http\Controllers\Admin\AbsenceController;
use App\Http\Controllers\Admin\EmploiDuTempsController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ScanController;
use App\Http\Controllers\Etudiant\DashboardController as EtudiantDashboardController;
use App\Http\Controllers\Etudiant\AbsenceController as EtudiantAbsenceController;
use App\Http\Controllers\Etudiant\EmploiController as EtudiantEmploiController;
use App\Http\Controllers\Etudiant\NoteController as EtudiantNoteController;
use App\Http\Controllers\Etudiant\DocumentController as EtudiantDocumentController;
use App\Http\Controllers\Etudiant\ProfileController as EtudiantProfileController;
use App\Http\Controllers\Enseignant1\DashboardController as EnseignantDashboardController;
use App\Http\Controllers\Enseignant1\EnseignantEtudiantController;
use App\Http\Controllers\Enseignant1\EnseignantModuleController;
use App\Http\Controllers\Enseignant1\PostController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\Enseignant1\AbsenceController as EnseignantAbsenceController;
use App\Http\Controllers\Enseignant1\NoteController as EnseignantNoteController;
use App\Http\Controllers\Enseignant1\ProfileController as EnseignantProfileController;
use App\Http\Controllers\Enseignant1\EmploiDuTempsController as EnseignantEmploiController;
use App\Http\Controllers\Enseignant1\DocumentController as EnseignantDocumentController;
use App\Http\Controllers\QRScanController;
use App\Http\Controllers\PresenceController;


/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'));

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/preinscription', [PreinscriptionController::class, 'create'])->name('preinscription.create');
Route::post('/preinscription/store', [PreinscriptionController::class, 'store'])->name('preinscription.store');

/*
|--------------------------------------------------------------------------
| Authentification globale
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route de déconnexion globale
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| SuperAdmin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('admins', AdminController::class)->except(['show']);
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Étudiants
    Route::resource('etudiants', EtudiantController::class);
    Route::get('etudiants/{etudiant}/absences', [EtudiantController::class, 'showAbsences'])->name('etudiants.absences');

    // Enseignants
    Route::resource('enseignants', EnseignantController::class);
    Route::get('enseignants/{enseignant}/modules', fn(App\Models\Enseignant $enseignant) => response()->json($enseignant->modules))->name('enseignants.modules');
    Route::get('enseignants/{id}/absences', [AbsenceController::class, 'showByEnseignant'])->name('enseignants.absences');

    // Absences
    Route::resource('absences', AbsenceController::class);

    // Modules
    Route::resource('modules', ModuleController::class);
    Route::get('modules/{module}/students', [ModuleController::class, 'students'])->name('modules.students');

    // Emplois du temps
    Route::resource('emplois', EmploiDuTempsController::class);

    // Notes
        Route::get('/notes/statistics', [NoteController::class, 'statistics'])->name('notes.statistics');
    Route::get('/notes/export', [NoteController::class, 'export'])->name('notes.export');

    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');

    // Update this route to accept two parameters
    Route::get('/notes/{etudiant_id}/{module_id}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('/notes/{etudiant_id}/{module_id}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{etudiant_id}/{module_id}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{etudiant_id}/{module_id}/all', [NoteController::class, 'destroyAll'])->name('notes.destroyAll');

    Route::get('/notes/{id}/edit-notes', [NoteController::class, 'editNotes'])->name('notes.editNotes');
    Route::put('/notes/{id}/update-notes', [NoteController::class, 'updateNotes'])->name('notes.updateNotes');
    Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');


    // Préinscriptions
    Route::resource('preinscriptions', PreinscriptionController::class)->except(['create', 'store']);
    Route::post('/preinscriptions', [PreinscriptionController::class, 'store'])->name('preinscriptions.store');
    Route::post('preinscriptions/{id}/accept', [PreinscriptionController::class, 'accept'])->name('preinscriptions.accept');
    Route::delete('preinscriptions/{id}/reject', [PreinscriptionController::class, 'reject'])->name('preinscriptions.reject');

    //Scanner
    Route::get('/scanner', [ScanController::class, 'showScanner'])->name('admin.scanner');
    Route::post('/scanner/process', [ScanController::class, 'processScan'])->name('admin.scan.process');

    //presence

    Route::get('/presences/index', [PresenceController::class, 'index'])->name('presences.index');
    Route::get('/presences/scan/{type}/{id}', [ScanController::class, 'start'])->name('presences.scan');
    Route::post('/scanner/presence/store', [ScanController::class, 'store'])->name('scanner.presence.store');
});


/*
|--------------------------------------------------------------------------
| Étudiant
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:etudiant'])->prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/dashboard', [EtudiantDashboardController::class, 'index'])->name('dashboard');
    Route::get('absences', [EtudiantAbsenceController::class, 'index'])->name('absences.index');
    Route::get('/emploi', [EtudiantEmploiController::class, 'index'])->name('emploi');
    Route::get('/notes', [EtudiantNoteController::class, 'index'])->name('notes');
    Route::get('documents', [EtudiantDocumentController::class, 'index'])->name('documents.index');
    Route::get('documents/{module}', [EtudiantDocumentController::class, 'show'])->name('documents.show');
    Route::get('documents/module/{module}/document/{document}/download', [EtudiantDocumentController::class, 'download'])->name('documents.download');
    Route::get('/profile', [EtudiantProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [EtudiantProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [EtudiantProfileController::class, 'updatePassword'])->name('profile.password');
});

// Routes pour le QR Code
Route::get('/qr-scanner', function() {
    return view('qr-scanner');
})->name('qr.scanner');

Route::post('/qr-scan', [QRScanController::class, 'scan'])->name('qr.scan');
Route::get('/mark-absents', [QRScanController::class, 'markAbsents'])->name('mark.absents');


/*
|--------------------------------------------------------------------------
| Enseignant
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:enseignant'])->prefix('enseignant')->name('enseignant.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [EnseignantDashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('profile/edit', [EnseignantProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [EnseignantProfileController::class, 'update'])->name('profile.update');

    // Étudiants
    Route::prefix('etudiants')->name('etudiants.')->group(function () {
        Route::get('/', [EnseignantEtudiantController::class, 'index'])->name('index');
        Route::get('/{etudiant}/absences', [EnseignantEtudiantController::class, 'showAbsences'])->name('absences');
        Route::get('/{etudiant}', [EnseignantEtudiantController::class, 'showProfile'])->name('profile');
    });

    // Absences
    Route::resource('absences', \App\Http\Controllers\Enseignant1\AbsenceController::class);

    // Emplois du temps
    Route::get('/emploi-du-temps', [EnseignantEmploiController::class, 'index'])->name('emploi.index');

    // Modules & posts
    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [EnseignantModuleController::class, 'index'])->name('index');
        Route::post('/{module}/posts', [PostController::class, 'store'])->name('posts.store');
    });

    // Notes
    Route::prefix('notes')->name('notes.')->group(function () {
        Route::get('/', [EnseignantNoteController::class, 'index'])->name('index');
        Route::get('/create', [EnseignantNoteController::class, 'create'])->name('create');
        Route::post('/', [EnseignantNoteController::class, 'store'])->name('store');
    });

    // Documents
    Route::get('/documents', [EnseignantDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [EnseignantDocumentController::class, 'create'])->name('documents.create');
    Route::delete('/documents/{id}', [EnseignantDocumentController::class, 'destroy'])->name('documents.destroy');
    Route::post('/documents', [EnseignantDocumentController::class, 'store'])->name('documents.store');

    // Cours
    Route::resource('cours', CoursController::class);

    // Classes
    Route::resource('classes', ClasseController::class);

});
Route::get('/presence/scan', [PresenceController::class, 'scan'])->name('presence.scan');


