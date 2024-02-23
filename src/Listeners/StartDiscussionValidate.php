<?php
namespace Gtdxyz\HCaptcha\Listeners;

use Flarum\Discussion\Event\Saving;
use Gtdxyz\HCaptcha\Validators\HCaptchaValidator;
use Illuminate\Support\Arr;

class StartDiscussionValidate
{
    /**
     * @var HCaptchaValidator
     */
    protected $validator;

    /**
     * @param HCaptchaValidator $validator
     */
    public function __construct(HCaptchaValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(Saving $event)
    {
        if (!$event->discussion->exists) {
            if ($event->actor->hasPermission('gtdxyz-hcaptcha.postWithoutHCaptcha')) {
                return;
            }

            $this->validator->assertValid([
                'hcaptcha' => Arr::get($event->data, 'attributes.h-captcha-response'),
            ]);
        }
    }
}
