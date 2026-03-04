<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\Customer;
use App\Models\CustomerProgress;
use App\Models\Material;
use App\Models\Service;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('service')->latest()->get();
        $services = Service::all();
        return view('quiz.index', compact('quizzes', 'services'));
    }

    public function create()
    {
        $services = Service::all();
        return view('quiz.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id'       => 'required|exists:services,id',
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'passing_score'    => 'required|integer|min:0|max:100',
            'questions'        => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.score'    => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create([
            'service_id'       => $request->service_id,
            'title'            => $request->title,
            'description'      => $request->description,
            'duration_minutes' => $request->duration_minutes,
            'passing_score'    => $request->passing_score,
            'is_active'        => true,
        ]);

        foreach ($request->questions as $i => $q) {
            QuizQuestion::create([
                'quiz_id'  => $quiz->id,
                'question' => $q['question'],
                'position' => $i + 1,
                'score'    => $q['score'],
            ]);
        }

        return redirect()->route('quiz.index')->with('success', 'Quiz berhasil dibuat!');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('questions', 'service');
        $answers = QuizAnswer::with('customer', 'question')
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->get()
            ->groupBy('customer_id');

        return view('quiz.show', compact('quiz', 'answers'));
    }

    public function edit(Quiz $quiz)
    {
        $services = Service::all();
        $quiz->load('questions');
        return view('quiz.edit', compact('quiz', 'services'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'passing_score'    => 'required|integer|min:0|max:100',
        ]);

        $quiz->update($request->only('title', 'description', 'duration_minutes', 'passing_score', 'is_active'));

        return redirect()->route('quiz.index')->with('success', 'Quiz berhasil diperbarui!');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quiz.index')->with('success', 'Quiz berhasil dihapus!');
    }

    public function gradeAnswer(Request $request, QuizAnswer $answer)
    {
        $request->validate([
            'score'    => 'required|integer|min:0',
            'feedback' => 'nullable|string',
        ]);

        $answer->update([
            'score'    => $request->score,
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }


    public function take(Quiz $quiz, Customer $customer)
    {

        $totalMaterials = Material::where('is_active', true)
            ->whereHas('service', fn($q) => $q->where('id', $quiz->service_id))
            ->count();

        $completed = CustomerProgress::where('customer_id', $customer->id)
            ->where('status', 'completed')
            ->whereHas('material', fn($q) => $q->where('service_id', $quiz->service_id))
            ->count();

        if ($totalMaterials > 0 && $completed < $totalMaterials) {
            return redirect()->back()->with('error', 'Selesaikan semua materi terlebih dahulu!');
        }

        $alreadySubmitted = QuizAnswer::where('quiz_id', $quiz->id)
            ->where('customer_id', $customer->id)
            ->exists();

        $quiz->load('questions');

        return view('quiz.take', compact('quiz', 'customer', 'alreadySubmitted'));
    }

    public function submit(Request $request, Quiz $quiz, Customer $customer)
    {
        $request->validate([
            'answers'   => 'required|array',
            'answers.*' => 'required|string',
        ]);

        QuizAnswer::where('quiz_id', $quiz->id)
            ->where('customer_id', $customer->id)
            ->delete();

        foreach ($request->answers as $questionId => $answer) {
            QuizAnswer::create([
                'quiz_id'          => $quiz->id,
                'quiz_question_id' => $questionId,
                'customer_id'      => $customer->id,
                'answer'           => $answer,
                'submitted_at'     => now(),
            ]);
        }

        return redirect()->route('quiz.result', [$quiz, $customer])
            ->with('success', 'Jawaban berhasil dikirim! Tunggu penilaian dari admin.');
    }

    public function result(Quiz $quiz, Customer $customer)
    {
        $answers = QuizAnswer::with('question')
            ->where('quiz_id', $quiz->id)
            ->where('customer_id', $customer->id)
            ->get();

        $totalScore = $answers->sum('score');
        $maxScore   = $quiz->questions->sum('score');
        $pct        = $maxScore > 0 ? round(($totalScore / $maxScore) * 100) : 0;
        $passed     = $pct >= $quiz->passing_score;

        return view('quiz.result', compact('quiz', 'customer', 'answers', 'totalScore', 'maxScore', 'pct', 'passed'));
    }
}
