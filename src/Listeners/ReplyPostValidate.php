<?php
namespace Gtdxyz\HCaptcha\Listeners;

use Flarum\Post\Event\Saving;
use Gtdxyz\HCaptcha\Validators\HCaptchaValidator;
use Illuminate\Support\Arr;

class ReplyPostValidate
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
        if (!$event->post->exists) {
            // If it's a new discussion, the hCaptcha is already validated in discussion saving event
            // When this code runs, the discussion already exists, and the number has not been assigned to the post yet
            // So we look in the discussion number index, just like the reply permission check does in PostReplyHandler
            if ($event->post->discussion->post_number_index === 0) {
                return;
            }

            if ($event->actor->hasPermission('gtdxyz-hcaptcha.postWithoutHCaptcha')) {
                return;
            }

            $this->validator->assertValid([
                'hcaptcha' => Arr::get($event->data, 'attributes.h-captcha-response'),
            ]);
        }
    }
}
