<?php

namespace App\Services;

use App\Contracts\AnswerCommand;
use App\Contracts\ChooseAnswerCommand;
use App\Contracts\QuestionCommand;
use App\Contracts\Services\QuestionServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Models\Answer;
use App\Models\Question;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $question = $this->findQuestion($command->question_id);
        // 작성자 본인은 답변할 수 없습니다.
        if ($question->user_id === $command->user_id) {
            throw new BadRequestException("작성자 본인은 답변할 수 없습니다.");
        }

        // 질문에 답변 갯수를 확인합니다.
        if ($question->isFulllAnswer()) {
            throw new BadRequestException("답변이 3개 이상 등록된 질문엔 더 이상 답변할 수 없습니다.");
        }

        // 답변을 생성합니다.
        $answer = $command->toModel();

        return $answer->save();
    }

    public function chooseAnswer(ChooseAnswerCommand $command): bool {
        $question = $this->findQuestion($command->question_id);
        // 질문과 답변 아이디가 일치하지 않는 경우 ModelNotFoundException 가 발생합니다.
        $answer = $question->answers()->where('id', $command->answer_id)->firstOrFail();

        // 질문 작성자만 답변을 채택할 수 있습니다.
        if ($question->user_id !== $command->user_id) {
            throw new NotFoundHttpException("질문 작성자만 답변만 채택할 수 있습니다.");
        }

        // 이미 채택된 답변이 있으면 다른 답변을 채택할 수 없습니다.
        if ($question->isChooseAnswer()) {
            throw new BadRequestException("이미 채택된 답변이 있습니다.");
        }

        // 답변을 채택합니다.
        $answer->is_select = true;

        return $answer->save();
    }
}