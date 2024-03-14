<?php

namespace App\Listeners;

use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Zoho\ZohoExtendSocialite;
use SocialiteProviders\Kakao\KakaoExtendSocialite;

class SocialiteEventListener
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
        $socialite = new ZohoExtendSocialite();
        $socialite->handle($event);
    }
}
