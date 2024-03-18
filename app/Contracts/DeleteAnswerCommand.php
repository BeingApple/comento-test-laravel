<?php

namespace App\Contracts;

class DeleteAnswerCommand {
    public string $question_id;
    public string $answer_id;
    public string $user_id;

    public function __construct(string $question_id, string $answer_id, string $user_id) {
        $this->question_id = $question_id;
        $this->answer_id = $answer_id;
        $this->user_id = $user_id;
    }
}