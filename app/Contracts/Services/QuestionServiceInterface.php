<?php

namespace App\Contracts\Services;

use App\Contracts\AnswerCommand;
use App\Contracts\QuestionCommand;
use App\Models\Question;

interface QuestionServiceInterface {
    /**
     * @param string $id
     * @return Question
     * @throws ModelNotFoundException
     */
    public function findQuestion(string $id): Question;

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
}