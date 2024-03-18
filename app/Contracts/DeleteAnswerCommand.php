<?php

namespace App\Contracts;

class DeleteAnswerCommand {
    public string $answer_id;
    public string $user_id;

    public function __construct(string $answer_id, string $user_id) {
        $this->answer_id = $answer_id;
        $this->user_id = $user_id;
    }
}