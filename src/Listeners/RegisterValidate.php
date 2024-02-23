<?php
namespace Gtdxyz\HCaptcha\Listeners;

use Flarum\User\Event\Saving;
use Gtdxyz\HCaptcha\Validators\HCaptchaValidator;
use Illuminate\Support\Arr;

class RegisterValidate
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
        if (!$event->user->exists) {
            $this->validator->assertValid([
                'hcaptcha' => Arr::get($event->data, 'attributes.h-captcha-response'),
            ]);
        }
    }
}
