<?php

namespace Gtdxyz\HCaptcha\Listeners;

use Flarum\Foundation\AbstractValidator;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Validation\Validator;
use HCaptcha\hCaptcha;

class AddValidatorRule
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(AbstractValidator $flarumValidator, Validator $validator)
    {
        $secret = $this->settings->get('gtdxyz-hcaptcha.credentials.secret');

        $validator->addExtension(
            'hcaptcha',
            function ($attribute, $value, $parameters) use ($secret) {
                $ss= (new hCaptcha($secret))->verify($value);
                return !empty($value) && (new hCaptcha($secret))->verify($value)->isSuccess();
            }
        );
    }
}
