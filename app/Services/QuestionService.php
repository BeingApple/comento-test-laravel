<?php

namespace App\Services;

use App\Contracts\AnswerCommand;
use App\Contracts\ChooseAnswerCommand;
use App\Contracts\DeleteAnswerCommand;
use App\Contracts\DeleteQuestionCommand;
use App\Contracts\QuestionCommand;
use App\Contracts\Services\QuestionServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Models\Answer;
use App\Models\Question;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionService implements QuestionServiceInterface {
    public function __construct(protected UserServiceInterface $userService) {
    }

    public function getQuestionList(int $block = 6): LengthAwarePaginator {
        // 페이지네이션 결과를 조회
        return Question::paginate($block);
    }

    public function findQuestion(string $id): Question {
        // 질문을 조회합니다.
        try {
            return Question::findOrFail($id);
        } catch (Exception $e) {
            throw new NotFoundHttpException("찾을 수 없는 질문입니다.");
        }
    }

    public function findAnswer(string $id): Answer {
        // 답변을 조회합니다.
        try {
            return Answer::findOrFail($id);
        } catch (Exception $e) {
            throw new NotFoundHttpException("찾을 수 없는 질문입니다.");
        }
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

        // 채택된 질문이 있는 지 확인합니다.
        if ($question->isChooseAnswer()) {
            throw new BadRequestException("답변을 채택한 질문엔 더 이상 답변할 수 없습니다.");
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

    public function deleteAnswer(DeleteAnswerCommand $command): bool {
        $question = $this->findQuestion($command->question_id);
        // 질문과 답변 아이디가 일치하지 않는 경우 ModelNotFoundException 가 발생합니다.
        $answer = $question->answers()->where('id', $command->answer_id)->firstOrFail();

        // 답변 작성자만 답변을 삭제할 수 있습니다.
        if ($answer->user_id !== $command->user_id) {
            throw new NotFoundHttpException("답변 작성자만 답변을 삭제할 수 있습니다.");
        }

        // 채택된 답변은 삭제할 수 없습니다.
        if ($answer->is_select == true) {
            throw new BadRequestException("채택된 답변은 삭제할 수 없습니다.");
        }

        // 답변을 삭제합니다.
        return $answer->delete();
    }

    public function deleteQuestion(DeleteQuestionCommand $command): bool {
        $question = $this->findQuestion($command->question_id);

        // 질문 작성자만 삭제할 수 있습니다.
        if ($question->user_id !== $command->user_id) {
            throw new NotFoundHttpException("질문 작성자만 삭제할 수 있습니다.");
        }

        // 답변이 없어야 삭제할 수 있습니다.
        if (!$question->isEmptyAnswer()) {
            throw new BadRequestException("답변이 있는 질문은 삭제할 수 없습니다.");
        }

        // 질문 삭제
        return $question->delete();
    }
}