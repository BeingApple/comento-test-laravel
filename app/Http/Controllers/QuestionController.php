<?php

namespace App\Http\Controllers;

use App\Contracts\QuestionCommand;
use App\Contracts\Services\QuestionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    public function __construct(protected QuestionServiceInterface $questionService) {
    }

    public function createQuestion(Request $request) {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => ['required', 'string'],
            'question' => ['required', 'string'],
            'category' => [
                'required', 
                'string', 
                Rule::in(['집사 고민', '사료 고민', '그루밍'])
            ]
        ]);

        $command = new QuestionCommand(
            $user->id, 
            $validated['category'], 
            $validated['title'], 
            $validated['question']
        );

        $result = $this->questionService->createQuestion($command);
        return response()->base($result, "답변이 작성되었습니다.", $command);
    }
}
