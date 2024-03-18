<?php

namespace App\Contracts;

class DeleteQuestionCommand {
    public string $question_id;
    public string $user_id;

    public function __construct(string $question_id, string $user_id) {
        $this->question_id = $question_id;
        $this->user_id = $user_id;
    }
}