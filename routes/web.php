<?php

use App\Livewire\Pos\Index;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Stock\In;
use App\Livewire\Stock\Out;
use App\Livewire\Reports\OutOfStock;
use App\Livewire\Reports\PhysicalCount;
use App\Livewire\Reports\ProfitReport;
use App\Livewire\Reports\TopLowItems;
use App\Livewire\Users\ManageUsers;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/pos', Index::class)->name('pos.index');
});

// Route::middleware(['auth','role:admin,manager'])->group(function () {
//      Route::get('/stock/in', In::class)->name('stock.in');
// });

Route::get('/stock/in', In::class)->name('stock.in');
Route::get('/stock/out', Out::class)->name('stock.out');

Route::get('/reports/daily-sales', \App\Livewire\Reports\DailySales::class)->name('reports.daily-sales');
Route::get('/reports/my-daily-sales', \App\Livewire\Reports\DailyMySales::class)
    ->middleware('auth')
    ->name('reports.my-daily-sales');

   Route::get('/reports/out-of-stock', OutOfStock::class)
    ->middleware('auth')
    ->name('reports.out-of-stock');

    Route::get('/reports/profit', ProfitReport::class)
    ->name('reports.profit')
    ->middleware('auth');

    Route::get('/reports/top-low-items', TopLowItems::class)
    ->name('reports.top-low-items')
    ->middleware('auth');

    Route::get('/reports/physical-count', PhysicalCount::class)
    ->name('reports.physical-count')
    ->middleware('auth');

    Route::get('/reports/daily-stock', \App\Livewire\Reports\DailyStockReport::class)
    ->name('reports.daily-stock')
    ->middleware('auth');

    Route::get('/products/add', \App\Livewire\Product\AddProduct::class)
    ->name('products.add')
    ->middleware('auth');

//     Route::middleware(['auth', 'can:admin'])->group(function() {
   
// });
 Route::get('/users', ManageUsers::class)->name('users.manage');
    Route::get('/products/stock-report', \App\Livewire\Product\StockReport::class)
    ->name('products.stock-report')
    ->middleware('auth');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
