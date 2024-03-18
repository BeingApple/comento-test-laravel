<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'list' => $this->collection->map(function ($item, $index) {
                return [
                    'row' => $this->getRowNumber($index),
                    'id' => $item->id,
                    'title' => $item->title,
                    'question' => mb_substr($item->question, 0, 30),
                    'breed' => $item->user->breed,
                    'created_at' => $item->created_at,
                ];
            }),
            'total' => $this->total(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
        ];
    }

    protected function getRowNumber(int $index): int {
        return ($this->currentPage() - 1) * $this->perPage() + $index + 1;
    }
}
