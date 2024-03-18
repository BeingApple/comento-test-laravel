<?php

namespace App\Contracts\Services;

use App\Contracts\AnswerCommand;
use App\Contracts\ChooseAnswerCommand;
use App\Contracts\DeleteAnswerCommand;
use App\Contracts\QuestionCommand;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface QuestionServiceInterface {
    /**
     * @param string $id
     * @return Question
     * @throws ModelNotFoundException
     */
    public function findQuestion(string $id): Question;

    /**
     * @param string $id
     * @return Answer
     * @throws ModelNotFoundException
     */
    public function findAnswer(string $id): Answer;

    /**
     * @param QuestionCommand $command
     * @return bool
     */
    public function createQuestion(QuestionCommand $command): bool;

    /**
     * @param AnswerCommand $command
     * @return bool
     * @throws ModelNotFoundException
     * @throws BadRequestException
     */
    public function answerQuestion(AnswerCommand $command): bool;

    /**
     * @param ChooseAnswerCommand $command
     * @return bool
     * @throws ModelNotFoundException
     * @throws BadRequestException
     */
    public function chooseAnswer(ChooseAnswerCommand $command): bool;

    /**
     * @param DeleteAnswerCommand $command
     * @return bool
     * @throws ModelNotFoundException
     * @throws BadRequestException
     */
    public function deleteAnswer(DeleteAnswerCommand $command): bool;
}