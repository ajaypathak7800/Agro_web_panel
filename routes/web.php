<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
Route::post('/auth', [AdminController::class, 'auth'])->name('auth');
Route::post('/register', [AdminController::class, 'register'])->name('register');
Route::get('admin', [AdminController::class, 'index']);

Route::group(['middleware' => ['admin_auth', ]], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('report', [AdminController::class, 'hello'])->name('report');
    Route::get('/guest-data', [AdminController::class, 'getGuestData']);
    Route::get('/customer', [AdminController::class, 'import'])->name('import');
    Route::post('/importexcel', [AdminController::class, 'importexcel'])->name('importexcel');
    Route::get('export-users', [AdminController::class, 'exportUsers'])->name('export-users');
    Route::get('/customerfpo', [AdminController::class, 'indexFPO'])->name('customerfpo');
    Route::get('/export', [AdminController::class, 'export'])->name('export');
    Route::post('/importfpo', [AdminController::class, 'importFPO'])->name('importFPO');
    Route::get('export-cbbo', [AdminController::class, 'exportCbbo'])->name('exportCbbo');
    Route::post('import-cbbo', [AdminController::class, 'importCbbo'])->name('importCbbo');
    Route::get('importExportView', [AdminController::class, 'importExportView'])->name('importExportView');
    Route::get('/INDEXUSER', [AdminController::class, 'INDEXUSER'])->name('INDEXUSER');
    Route::get('/users/create', [AdminController::class, 'create'])->name('create');
    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/users/{id}/update', [AdminController::class, 'update'])->name('update');
    Route::delete('/users/{id}/destroy', [AdminController::class, 'destroy'])->name('destroy');
    Route::post('/storeg', [AdminController::class, 'storeg'])->name('storeg');
    //export aricuturte
Route::get('agricultural', [AdminController::class, 'agricultural'])->name('importExportViewe');
Route::post('importagricultural', [AdminController::class, 'importagricultural'])->name('importagricultural');
Route::get('exportagricultural', [AdminController::class, 'exportagricultural'])->name('exportagricultural');


//CBBO OFLINE
Route::get('cbbo_offline', [AdminController::class, 'indexc'])->name('cbbo_offline');
Route::get('cbbo_offline/export', [AdminController::class, 'exportb'])->name('cbbo_offline.export');
Route::post('cbbo_offline/import', [AdminController::class, 'importb'])->name('cbbo_offline.import');

Route::get('/logs', [AdminController::class, 'showLogs'])->name('showLogs');

//importCbboUniqueIdMapping
Route::post('import-cbbo-unique-id-mapping', [AdminController::class, 'importCbboUniqueIdMapping'])->name('importCbboUniqueIdMapping');

Route::get('export-cbbo-unique-id-mapping', [AdminController::class, 'exportCbboUniqueIdMapping'])->name('exportCbboUniqueIdMapping');
Route::get('cbbo-unique-id-mapping', [AdminController::class, 'showCbboUniqueIdMapping'])->name('showCbboUniqueIdMapping');

    Route::get('/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('error', 'Logout successfully');
        return redirect('admin'); // Redirect to the login page or another appropriate page
    });
});
