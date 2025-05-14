<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PreinscriptionController;
use App\Http\Controllers\Admin\EtudiantController;
use App\Http\Controllers\Admin\EnseignantController;
use App\Http\Controllers\Admin\AbsenceController;
use App\Http\Controllers\Admin\EmploiDuTempsController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Etudiant\DashboardController as EtudiantDashboardController;
use App\Http\Controllers\Enseignant1\DashboardController as EnseignantDashboardController;
use App\Http\Controllers\Enseignant1\EnseignantEtudiantController;
use App\Http\Controllers\Enseignant1\EnseignantModuleController;
use App\Http\Controllers\Enseignant1\PostController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CoursController;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('home'));




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/preinscription', [PreinscriptionController::class, 'create'])->name('preinscription.create');
Route::post('/preinscription', [PreinscriptionController::class, 'store'])->name('preinscription.store');

/*
|--------------------------------------------------------------------------
| Authentification globale
|--------------------------------------------------------------------------
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| SuperAdmin
|--------------------------------------------------------------------------
*/
Route::middleware(['superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
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
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Profil
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Étudiants
    Route::resource('etudiants', EtudiantController::class);
    Route::get('etudiants/{etudiant}/absences', [EtudiantController::class, 'showAbsences'])->name('etudiants.absences');

    // Enseignants
    Route::resource('enseignants', EnseignantController::class)->except(['show']);
    Route::get('enseignants/{enseignant}/modules', fn(App\Models\Enseignant $enseignant) => response()->json($enseignant->modules))->name('enseignants.modules');
    Route::get('enseignants/{id}/absences', [AbsenceController::class, 'showByEnseignant'])->name('enseignants.absences');

    // Absences
    Route::resource('absences', AbsenceController::class);

    // Modules
    Route::resource('modules', ModuleController::class);

    // Emplois du temps
    Route::resource('emplois', EmploiDuTempsController::class);

    // Notes
    Route::prefix('notes')->name('notes.')->group(function () {
        Route::get('/', [NoteController::class, 'index'])->name('index');
        Route::get('/create', [NoteController::class, 'create'])->name('create');
        Route::post('/', [NoteController::class, 'store'])->name('store');
        Route::get('/{note}/edit', [NoteController::class, 'edit'])->name('edit');
        Route::get('/{etudiant_id}/{module_id}/edit-notes', [NoteController::class, 'editNotes'])->name('editNotes');
        Route::put('/{id}/update-notes', [NoteController::class, 'updateNotes'])->name('updateNotes');
        Route::put('/{etudiant_id}/{module_id}', [NoteController::class, 'update'])->name('update');
        Route::delete('/{note}', [NoteController::class, 'destroy'])->name('destroy');
        Route::delete('/destroy/{etudiant_id}/{module_id}/{note_type}', [NoteController::class, 'destroyNote'])->name('destroyNote');
        Route::delete('/destroy-all/{etudiant_id}/{module_id}', [NoteController::class, 'destroyAll'])->name('destroyAll');
    });

    // Préinscriptions
    Route::resource('preinscriptions', PreinscriptionController::class)->except(['create', 'store']);
    Route::post('preinscriptions/{id}/accept', [PreinscriptionController::class, 'accept'])->name('preinscriptions.accept');
    Route::delete('preinscriptions/{id}/reject', [PreinscriptionController::class, 'reject'])->name('preinscriptions.reject');

    // Déconnexion admin
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Étudiant
|--------------------------------------------------------------------------
*/
Route::prefix('etudiant')->middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/dashboard', [EtudiantDashboardController::class, 'index'])->name('etudiant.dashboard');
    Route::get('/absences', [EtudiantAbsenceController::class, 'index'])->name('etudiant.absences');
    Route::get('/emploi-du-temps', [EtudiantEmploiController::class, 'index'])->name('etudiant.emploi');
    Route::get('/notes', [EtudiantNoteController::class, 'index'])->name('etudiant.notes');
    Route::get('/modules', [EtudiantModuleController::class, 'index'])->name('etudiant.modules');
});

/*
|--------------------------------------------------------------------------
| Enseignant
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:enseignant'])->prefix('enseignant1')->name('enseignant1.')->group(function () {
        // Dashboard
        Route::get('/dashboard1', [EnseignantDashboardController::class, 'dashboard1'])->name('dashboard1');

        // Profil
        Route::get('profile/edit', [EnseignantController::class, 'editProfile'])->name('profile.edit');
        Route::put('profile/update', [EnseignantController::class, 'updateProfile'])->name('profile.update');

        // Étudiants
        Route::prefix('etudiants')->name('etudiants.')->group(function () {
            Route::get('/{enseignantId}', [EnseignantEtudiantController::class, 'index'])->name('index');
            Route::get('/{etudiant}/absences', [EnseignantEtudiantController::class, 'showAbsences'])->name('absences');
            Route::get('/{etudiant}', [EnseignantEtudiantController::class, 'showProfile'])->name('profile');
        });

        // Absences
        Route::resource('absences', AbsenceController::class)->only(['index', 'create', 'store']);

        // Emplois du temps
        Route::prefix('emploi-du-temps')->group(function () {
            Route::get('/', [EmploiDuTempsController::class, 'index'])->name('enseignant.emploi.index');
        });

        // Modules & posts
        Route::prefix('modules')->group(function () {
            Route::get('/', [EnseignantModuleController::class, 'index'])->name('modules.index');
            Route::post('/{module}/posts', [PostController::class, 'store'])->name('modules.posts.store');
        });

        // Notes
        Route::prefix('notes')->group(function () {
            Route::get('/', [NoteController::class, 'index'])->name('notes.index');
            Route::get('/create', [NoteController::class, 'create'])->name('notes.create');
            Route::post('/', [NoteController::class, 'store'])->name('notes.store');
        });

        // Documents
        Route::resource('documents', DocumentController::class)->only(['index', 'create', 'store']);

        // Cours
        Route::resource('cours', CoursController::class);
});