<?php

namespace App\Listeners;

use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Kakao\KakaoExtendSocialite;

class SocialiteKakaoEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SocialiteWasCalled $event): void
    {
        $kakao = new KakaoExtendSocialite();
        $kakao->handle($event);
    }
}
