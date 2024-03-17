<?php

namespace App\Contracts;

use App\Models\Answer;

class AnswerCommand {
    public string $question_id;
    public string $user_id;
    public string $answer;

    public function __construct(string $question_id, string $user_id, string $answer) {
        $this->question_id = $question_id;
        $this->user_id = $user_id;
        $this->answer = $answer;
    }

    public function toModel(): Answer {
        $answer = new Answer();
        $answer->question_id = $this->question_id;
        $answer->user_id = $this->user_id;
        $answer->answer = $this->answer;

        return $answer;
    }
}