<?php

namespace App\Services;

use App\Contracts\AnswerCommand;
use App\Contracts\QuestionCommand;
use App\Contracts\Services\QuestionServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Models\Question;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class QuestionService implements QuestionServiceInterface {
    public function __construct(protected UserServiceInterface $userService) {
    }

    public function findQuestion(string $id): Question {
        // 질문을 조회합니다.
        return Question::findOrFail($id);
    }

    public function createQuestion(QuestionCommand $command): bool {
        // 질문을 생성합니다.
        $question = $command->toModel();

        return $question->save();
    }

    public function answerQuestion(AnswerCommand $command): bool {
        // 유저가 멘토인지 확인합니다.
        $user = $this->userService->findUser($command->user_id);
        if (!$user->isMento()) {
            throw new BadRequestException("멘티는 답변을 등록할 수 없습니다.");
        }

        // 질문에 답변 갯수를 확인합니다.
        $question = $this->findQuestion($command->question_id);
        if ($question->isFulllAnswer()) {
            throw new BadRequestException("답변이 3개 이상 등록된 질문엔 더 이상 답변할 수 없습니다.");
        }

        // 답변을 생성합니다.
        $answer = $command->toModel();

        return $answer->save();
    }
}