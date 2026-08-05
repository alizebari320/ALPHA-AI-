<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FirebaseAuthController;
use App\Models\Faq;

// سنگکرۆنی نیشتنیشانەکانی Firebase لەگەڵ نیشتنیشانەی Laravel (Breeze)
Route::post('/api/firebase-auth-sync', [FirebaseAuthController::class, 'sync']);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// پەڕەی سەرەکی
Route::get('/', function () {
    $faqs = Faq::all(); // هەموو پرسیارەکان بهێنە
    return view('home', compact('faqs'));
});

// پەڕەکانی چوونەژوورەوە و پڕۆفایل
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::get('/profile', function () {
    return view('profile');
})->middleware('admin')->name('profile');


// ==========================================
// بەشی بینینی گشتی (Public read-only pages)
// ==========================================
Route::get('/courses', [AdminController::class, 'showCourses']);
Route::get('/ai-tools', [AdminController::class, 'showAiTools']);
Route::get('/academic-guide', [AdminController::class, 'showAcademicGuide']);
Route::get('/ferga', [AdminController::class, 'showFerga']);


// ==========================================
// بەشی ئەدمین — پارێزراو بە middleware('admin')
// Every route that mutates Firebase data lives in this group.
// ==========================================
Route::middleware('admin')->group(function () {

    // کۆرسەکان (Courses)
    Route::post('/store-course', [AdminController::class, 'storeCourse'])->name('store.course');
    Route::get('/courses/{id}/edit', [AdminController::class, 'editCourse'])->name('edit.course');
    Route::put('/courses/{id}', [AdminController::class, 'updateCourse'])->name('update.course');
    Route::delete('/courses/{id}', [AdminController::class, 'destroyCourse'])->name('destroy.course');

    // ئامرازەکانی زیرەکی دەستکرد (AI Tools)
    Route::post('/store-ai-tool', [AdminController::class, 'storeAiTool'])->name('store.ai_tool');
    Route::get('/ai-tools/{id}/edit', [AdminController::class, 'editAiTool'])->name('edit.ai_tool');
    Route::put('/ai-tools/{id}', [AdminController::class, 'updateAiTool'])->name('update.ai_tool');
    Route::delete('/ai-tools/{id}', [AdminController::class, 'destroyAiTool'])->name('destroy.ai_tool');

    // ڕێنیشاندەری ئەکادیمی (Academic Guide / FAQs)
    Route::post('/store-academic-guide', [AdminController::class, 'storeAcademicGuide'])->name('store.academic_guide');
    Route::get('/academic-guide/{id}/edit', [AdminController::class, 'editAcademicGuide'])->name('edit.academic_guide');
    Route::put('/academic-guide/{id}', [AdminController::class, 'updateAcademicGuide'])->name('update.academic_guide');
    Route::delete('/academic-guide/{id}', [AdminController::class, 'destroyAcademicGuide'])->name('destroy.academic_guide');

});



// ==========================================
// بەشی لاراڤێڵ بریز (ئەگەر پێشتر ئینستاڵت کردبێت)
// ==========================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar', 'ckb', 'kmr'])) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
});
Route::middleware('auth')->group(function () {
    Route::get('/profile-breeze', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-breeze', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile-breeze', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/news', function () {
    return view('news');
});
Route::get('/universities', function () {
    return view('universities');
});
require __DIR__.'/auth.php';
