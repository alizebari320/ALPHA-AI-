<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class AdminController extends Controller
{
    /**
     * دەستگەیشتن بە داتابەیسی فایەربەیس (Realtime Database)
     */
    protected function db(): Database
    {
        return app('firebase.database');
    }

    // ==========================================
    // بەشی سەرەکی و لۆگین
    // ==========================================
    public function index()
    {
        return view('home');
    }

    public function showLogin()
    {
        return view('auth.login');
    }


    // ==========================================
    // بەشی کۆرسەکان (Courses)
    // ==========================================
    public function showCourses()
    {
        $courses = $this->db()->getReference('courses')->getValue();
        return view('courses_list', compact('courses'));
    }

    public function storeCourse(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:5000'],
            'video_url' => ['nullable', 'url:http,https', 'max:2048'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:1000000'],
            'image_url' => ['nullable', 'url:http,https', 'max:2048'],
        ]);
        $this->db()->getReference('courses')->push($data);
        return redirect()->back()->with('success', 'کۆرسەکە بە سەرکەوتوویی زیادکرا!');
    }

    public function destroyCourse($id)
    {
        $this->db()->getReference('courses/' . $id)->remove();
        return redirect()->back()->with('success', 'کۆرسەکە بە سەرکەوتوویی سڕایەوە!');
    }

    // --- بەشی دەستکاری کۆرسەکان ---
    public function editCourse($id)
    {
        $data = $this->db()->getReference('courses/' . $id)->getValue();
        return view('edit', ['data' => $data, 'id' => $id, 'type' => 'course']);
    }

    public function updateCourse(Request $request, $id)
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:5000'],
            'video_url' => ['nullable', 'url:http,https', 'max:2048'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:1000000'],
            'image_url' => ['nullable', 'url:http,https', 'max:2048'],
        ]);
        $this->db()->getReference('courses/' . $id)->update($data);
        return redirect('/courses')->with('success', 'کۆرسەکە بە سەرکەوتوویی نوێکرایەوە!');
    }

    // --- بەشی دەستکاری ئامرازەکانی AI ---
    public function editAiTool($id)
    {
        $data = $this->db()->getReference('ai_tools/' . $id)->getValue();
        return view('edit', ['data' => $data, 'id' => $id, 'type' => 'ai_tool']);
    }

    public function updateAiTool(Request $request, $id)
    {
        $data = $request->validate($this->toolRules(false));
        $this->db()->getReference('ai_tools/' . $id)->update($data);
        return redirect('/ai-tools')->with('success', 'ئامرازەکە بە سەرکەوتوویی نوێکرایەوە!');
    }

    // --- بەشی دەستکاری ڕێنیشاندەر ---
    public function editAcademicGuide($id)
    {
        $data = $this->db()->getReference('academic_guide/' . $id)->getValue();
        return view('edit', ['data' => $data, 'id' => $id, 'type' => 'academic_guide']);
    }

    public function updateAcademicGuide(Request $request, $id)
    {
        $data = $request->validate([
            'question' => ['sometimes', 'required', 'string', 'max:500'],
            'answer' => ['sometimes', 'required', 'string', 'max:5000'],
            'category' => ['nullable', 'string', 'max:60'],
        ]);
        $this->db()->getReference('academic_guide/' . $id)->update($data);
        return redirect('/academic-guide')->with('success', 'پرسیارەکە بە سەرکەوتوویی نوێکرایەوە!');
    }


    // ==========================================
    // بەشی ئامرازەکانی ژیری دەستکرد (AI Tools)
    // ==========================================
    public function showAiTools()
    {
        $aiTools = $this->db()->getReference('ai_tools')->getValue();
        return view('ai_tools', compact('aiTools'));
    }

    public function storeAiTool(Request $request)
    {
        $data = $request->validate($this->toolRules(true));
        $this->db()->getReference('ai_tools')->push($data);
        return redirect()->back()->with('success', 'ئامرازەکە بە سەرکەوتوویی زیادکرا!');
    }

    public function destroyAiTool($id)
    {
        $this->db()->getReference('ai_tools/' . $id)->remove();
        return redirect()->back()->with('success', 'ئامرازەکە بە سەرکەوتوویی سڕایەوە!');
    }


    // ==========================================
    // بەشی ڕێنیشاندەری ئەکادیمی (Academic Guide)
    // ==========================================
    public function showAcademicGuide()
    {
        $faqs = $this->db()->getReference('academic_guide')->getValue();
        return view('academic_guide', compact('faqs'));
    }

    public function storeAcademicGuide(Request $request)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string', 'max:5000'],
            'category' => ['nullable', 'string', 'max:60'],
        ]);
        $this->db()->getReference('academic_guide')->push($data);
        return redirect()->back()->with('success', 'پرسیارەکە بە سەرکەوتوویی زیادکرا!');
    }

    public function destroyAcademicGuide($id)
    {
        $this->db()->getReference('academic_guide/' . $id)->remove();
        return redirect()->back()->with('success', 'پرسیارەکە بە سەرکەوتوویی سڕایەوە!');
    }


    // ==========================================
    // بەشی فێرگە (Ferga - Learning Platform)
    // ==========================================
    public function destroyFergaLesson($id)
    {
        $this->db()->getReference('ferga_lessons/' . $id)->remove();
        return redirect()->back()->with('success', 'وانەکە بە سەرکەوتوویی سڕایەوە!');
    }

    private function toolRules(bool $creating): array
    {
        $required = $creating ? 'required' : 'sometimes';

        return [
            'name' => [$required, 'string', 'max:160'],
            'tagline' => ['nullable', 'string', 'max:240'],
            'description' => ['nullable', 'string', 'max:5000'],
            'website_url' => ['nullable', 'url:http,https', 'max:2048'],
            'icon_url' => ['nullable', 'url:http,https', 'max:2048'],
            'category' => ['nullable', 'string', 'max:60'],
            'pricing_type' => ['nullable', 'string', 'max:30'],
            'status' => ['nullable', 'in:approved,pending'],
        ];
    }
}
