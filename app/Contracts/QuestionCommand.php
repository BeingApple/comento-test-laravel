<?php

namespace App\Contracts;

use App\Models\Question;

class QuestionCommand {
    public string $user_id;
    public string $category;
    public string $title;
    public string $question;

    public function __construct(string $user_id, string $category, string $title, string $question) {
        $this->user_id = $user_id;
        $this->category = $category;
        $this->title = $title;
        $this->question = $question;
    }

    public function toModel(): Question {
        $question = new Question();
        $question->user_id = $this->user_id;
        $question->category = $this->category;
        $question->title = $this->title;
        $question->question = $this->question;

        return $question;
    }
}