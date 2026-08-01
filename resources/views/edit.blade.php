@extends('layouts.app')

@section('title', 'دەستکاری — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'courses'])
<div id="page-shell" style="display:none">


    

    <div class="tech-glow w-96 h-96 bg-gold/20 -top-32 left-1/2"></div>

    <div class="max-w-2xl mx-auto py-16 px-4 relative z-10">
        <div class="card p-8 md:p-10">

            <div class="flex items-center justify-between mb-8 border-b border-slate-200/70 dark:border-white/10 pb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-amber-500/10 text-amber-500 rounded-xl flex items-center justify-center border border-amber-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <h2 class="text-2xl font-black font-display text-slate-900 dark:text-white">دەستکاریکردنی زانیاری</h2>
                </div>
                <a href="javascript:history.back()" class="btn btn-outline text-sm !py-2.5 !px-5">گەڕانەوە</a>
            </div>

            @if($type == 'course')
                <form action="{{ route('update.course', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="tech-label">ناونیشانی کۆرس</label>
                        <input type="text" name="title" value="{{ $data['title'] ?? '' }}" class="tech-input" required>
                    </div>
                    <div class="mb-5">
                        <label class="tech-label">بەستەری ڤیدیۆ</label>
                        <input type="url" name="video_url" value="{{ $data['video_url'] ?? '' }}" class="tech-input" dir="ltr" required>
                    </div>
                    <div class="mb-8">
                        <label class="tech-label">نرخ ($)</label>
                        <input type="number" name="price" value="{{ $data['price'] ?? 0 }}" class="tech-input" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-full !py-3.5 !text-lg">نوێکردنەوە و پاشەکەوتکردن</button>
                </form>

            @elseif($type == 'ai_tool')
                <form action="{{ route('update.ai_tool', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="tech-label">ناوی تووڵ</label>
                        <input type="text" name="name" value="{{ $data['name'] ?? '' }}" class="tech-input" required>
                    </div>
                    <div class="mb-5">
                        <label class="tech-label">جۆری بەکارهێنان</label>
                        <input type="text" name="category" value="{{ $data['category'] ?? '' }}" class="tech-input" required>
                    </div>
                    <div class="mb-5">
                        <label class="tech-label">وەسفێکی کورت</label>
                        <textarea name="description" class="tech-textarea" rows="3" required>{{ $data['description'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-8">
                        <label class="tech-label">بەستەر (URL)</label>
                        <input type="url" name="link" value="{{ $data['link'] ?? '' }}" class="tech-input" dir="ltr" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-full !py-3.5 !text-lg">نوێکردنەوە و پاشەکەوتکردن</button>
                </form>

            @elseif($type == 'academic_guide')
                <form action="{{ route('update.academic_guide', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="tech-label">پرسیار</label>
                        <input type="text" name="question" value="{{ $data['question'] ?? '' }}" class="tech-input" required>
                    </div>
                    <div class="mb-8">
                        <label class="tech-label">وەڵام</label>
                        <textarea name="answer" class="tech-textarea" rows="6" required>{{ $data['answer'] ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full !py-3.5 !text-lg">نوێکردنەوە و پاشەکەوتکردن</button>
                </form>
            @endif

        </div>
    </div>

    @include('partials.footer')

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c", storageBucket: "alphaai-d4f4c.firebasestorage.app", messagingSenderId: "518050080770", appId: "1:518050080770:web:c00d17cdbbbacb8ddd1f1b" };
        const auth = getAuth(initializeApp(firebaseConfig));

        onAuthStateChanged(auth, (user) => {
            if (!user) { window.location.href = "/login"; }
            else { document.getElementById('page-shell').style.display = 'block'; }
        });
    </script>

</div>
@endsection