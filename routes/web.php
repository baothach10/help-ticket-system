<?php

use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    // $users = DB::select('select * from users');
    // $users = DB::table('users')->get();

    // $users = DB::table('users')->insert([
    //     'name' => 'abd',
    //     'email' => 'abd@gmail.com',
    //     'password' => 'password'
    // ]);

    // $user = DB::insert('insert into users (name, email, password) values (?,?,?)', ['bcd', 'bcd@gmail.com', 'abcabc']);

    // $user = DB::update("update users set email = 'abd@gmail.com' where id = 2");

    // $user = DB::delete('delete from users where id=2');

    // $users = User::where('id', 1)->update([
    //     'name' => 'abcbabc'
    // ]);

    // $users = User::create([
    //     'name' => 'gfh',
    //     'email' => 'gfh@gmail.com',
    //     'password' => 'password',
    // ]);

    // $users = User::find(1);
    // dd($users->name);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');
 
Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    $user = User::firstOrCreate(['email' => $user->email], [
        'name' => $user->nickname,
        'password' => 'password',
    ]);

    Auth::login($user);
    return redirect('/dashboard');
    // $user->token
});

Route::middleware('auth')->group(function () {
    Route::resource('ticket', TicketController::class);
});
