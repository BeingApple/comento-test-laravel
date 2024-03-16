<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Contracts\UserAdditionalInfo;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private readonly UserServiceInterface $userService) {
    }

    // 유저의 추가 정보를 수정합니다.
    public function updateAdditionalInfo(Request $request) {
        $user = Auth::user();

        $validated = $request->validate([
            'age' => ['required', 'integer', 'between:1,15'],
            'breed' => ['required', 'string', 'max:20'],
        ]);

        $additionalInfo = new UserAdditionalInfo($validated['breed'], $validated['age']);
        $result = $this->userService->updateAdditionalInfo(
            $user->id, 
            $additionalInfo
        );

        return response()->base($result, "수정되었습니다.", $additionalInfo);
    }
}
