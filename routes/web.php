<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Livewire\Actions\Logout;
use Illuminate\Http\Request;
use App\Models\Post;
use Spatie\YamlFrontMatter\YamlFrontMatter;
// Zorg dat dit hier staat voor het verwerken van YAML front matter in markdown-bestanden
use App\Models\Category;
use App\Models\User;

Route::get('/', function () {
return view('welcome');
});

// Inloggen en registreren routes zijn al ingesteld door Breeze
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Dashboard route, alleen voor ingelogde gebruikers
Route::get('/dashboard', function () {
return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Routes voor profielbeheer
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::post('newsletter', function () {
    request()->validate(['email' => 'required|email']);

    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => 'us12'
    ]);
    try {
        $response = $mailchimp->lists->addListMember('aebc1a781e', [
            'email_address' => request('email'),
            'status' => 'subscribed'
        ]);
    } catch (\Exception $e) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'This email could not be added'
        ]);

    }
    return redirect('/');

});
Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('posts/{post:slug}', [PostController::class, 'show'])->name('post');

Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

Route::get('register', [RegisteredUserController::class, 'create']);

// Route to display the form
Route::get('admin/posts/make', [PostController::class, 'make'])->name('posts.create');

// Route to handle form submission
Route::post('admin/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');

// Route to display the edit form for a post
Route::get('admin/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');

// Route to handle the update of a post
Route::patch('admin/posts/{post}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');

// Route to handle the deletion of a post
Route::delete('admin/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');


// Route voor het dashboard, toegankelijk voor geverifieerde gebruikers
Route::get('/dashboard', function () {
    return view('dashboard'); // Weergeeft de 'dashboard' view voor geverifieerde gebruikers
})->middleware(['auth', 'verified'])->name('dashboard'); // Middleware 'auth' en 'verified' zorgen dat alleen ingelogde en geverifieerde gebruikers toegang hebben

// Routes die alleen toegankelijk zijn voor ingelogde gebruikers (auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Route voor het bewerken van het profiel
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Route voor het updaten van het profiel
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Route voor het verwijderen van het profiel
});
require __DIR__.'/auth.php'; // Zorg ervoor dat dit bestand wordt ingeladen
