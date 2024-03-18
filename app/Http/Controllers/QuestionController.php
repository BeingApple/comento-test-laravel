<?php

namespace App\Http\Controllers;

use App\Contracts\AnswerCommand;
use App\Contracts\ChooseAnswerCommand;
use App\Contracts\QuestionCommand;
use App\Contracts\Services\QuestionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        return response()->base($result, "질문이 작성되었습니다.", $command);
    }

    public function answerQuestion(Request $request, string $question_id) {
        $user = Auth::user();

        if (empty($question_id)) {
            // 질문 아이디값이 이상한 경우 예외 발생
            throw new NotFoundHttpException("잘못된 질문 아이디입니다.");
        }

        $validated = $request->validate([
            'answer' => ['required', 'string'],
        ]);

        $command = new AnswerCommand($question_id, $user->id, $validated["answer"]);

        $result = $this->questionService->answerQuestion($command);
        return response()->base($result, "답변이 작성되었습니다.", $command);
    }

    public function chooseAnswer(string $question_id, string $answer_id) {
        $user = Auth::user();

        if (empty($question_id) || empty($answer_id)) {
            // 아이디값이 이상한 경우 예외 발생
            throw new NotFoundHttpException("잘못된 아이디입니다.");
        }

        $command = new ChooseAnswerCommand($question_id, $answer_id, $user->id);

        $result = $this->questionService->chooseAnswer($command);
        return response()->base($result, "답변이 채택되었습니다.", $command);
    }
}
