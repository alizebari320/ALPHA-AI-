<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\ToolController;
use App\Models\Faq;
use Illuminate\Support\Str;

// سنگکرۆنی نیشتنیشانەکانی Firebase لەگەڵ نیشتنیشانەی Laravel (Breeze)
Route::post('/api/firebase-auth-sync', [FirebaseAuthController::class, 'sync']);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// پەڕەی سەرەکی — enhanced with platform data
Route::get('/', function () {
    $faqs = Faq::all();

    // Fetch approved AI tools from Firebase
    $rawTools = app('firebase.database')->getReference('ai_tools')->getValue();
    $tools = [];
    $locale = app()->getLocale();
    if (is_array($rawTools)) {
        foreach ($rawTools as $key => $node) {
            if (!is_array($node) || ($node['status'] ?? 'approved') !== 'approved') continue;
            $tool = [
                'id' => (string)($node['id'] ?? $key),
                'name' => $node['name'][$locale] ?? $node['name']['en'] ?? $node['title_so'] ?? 'AI Tool',
                'tagline' => $node['tagline'][$locale] ?? $node['tagline']['en'] ?? '',
                'description' => $node['description'][$locale] ?? $node['description']['en'] ?? $node['desc_so'] ?? '',
                'category' => $node['category'] ?? 'dev',
                'pricing_type' => $node['pricing_type'] ?? 'free',
                'website_url' => $node['website_url'] ?? $node['tool_url'] ?? '#',
                'icon_url' => $node['icon_url'] ?? $node['image_url'] ?? '',
                'rating_avg' => round((float)($node['rating_avg'] ?? 0), 2),
                'rating_count' => (int)($node['rating_count'] ?? 0),
                'views_count' => (int)($node['views_count'] ?? 0),
            ];
            $tools[] = $tool;
        }
        usort($tools, fn($a, $b) => [$b['views_count'], $b['rating_avg']] <=> [$a['views_count'], $a['rating_avg']]);
    }

    // Fetch courses from Firebase
    $rawCourses = app('firebase.database')->getReference('courses')->getValue();
    $courses = [];
    if (is_array($rawCourses)) {
        foreach ($rawCourses as $key => $node) {
            if (!is_array($node)) continue;
            $courses[] = [
                'id' => (string)($node['id'] ?? $key),
                'title' => $node['title'] ?? 'Untitled Course',
                'description' => $node['description'] ?? '',
                'video_url' => $node['video_url'] ?? '',
                'price' => $node['price'] ?? 0,
                'image_url' => $node['image_url'] ?? '',
            ];
        }
    }

    // Fetch news from Firebase
    $rawNews = app('firebase.database')->getReference('news')->getValue();
    $news = [];
    if (is_array($rawNews)) {
        foreach ($rawNews as $key => $node) {
            if (!is_array($node)) continue;
            $news[] = [
                'id' => (string)($node['id'] ?? $key),
                'title' => $node['title'][$locale] ?? $node['title']['en'] ?? $node['title'] ?? 'News',
                'slug' => $node['slug'] ?? Str::slug($node['title'][$locale] ?? $node['title']['en'] ?? 'news'),
                'excerpt' => $node['excerpt'][$locale] ?? $node['excerpt']['en'] ?? $node['excerpt'] ?? '',
                'image_url' => $node['image_url'] ?? '',
                'source' => $node['source'] ?? 'ALPHA/AI',
                'published_at' => $node['published_at'] ?? now()->toIso8601String(),
            ];
        }
        usort($news, fn($a, $b) => strtotime($b['published_at']) <=> strtotime($a['published_at']));
    }

    return view('home', compact('faqs', 'tools', 'courses', 'news'));
});

// پەڕەکانی چوونەژوورەوە و پڕۆفایل
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::get('/profile', function () {
    return view('profile');
})->middleware('admin')->name('profile');


// ==========================================
// ڕێنمای ئامرازەکانی زیرەکیا دەستکرد (AI Tools Directory)
// ==========================================
Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
Route::post('/tools/submit', [ToolController::class, 'submit'])
    ->middleware('throttle:10,1')
    ->name('tools.submit');
Route::post('/tools/{id}/rate', [ToolController::class, 'upvote'])
    ->middleware('throttle:30,1')
    ->name('tools.rate');
Route::post('/tools/{id}/view', [ToolController::class, 'view'])
    ->middleware('throttle:120,1')
    ->name('tools.view');


// ==========================================
// بەشی بینینی گشتی (Public read-only pages)
// ==========================================
Route::get('/courses', [AdminController::class, 'showCourses']);
Route::get('/ai-tools', [AdminController::class, 'showAiTools']);
Route::get('/academic-guide', [AdminController::class, 'showAcademicGuide']);


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
    if (array_key_exists($lang, config('alphaai.locales', []))) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
})->name('lang.switch');
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
