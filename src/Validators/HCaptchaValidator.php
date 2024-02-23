<?php
namespace Gtdxyz\HCaptcha\Validators;

use Flarum\Foundation\AbstractValidator;

class HCaptchaValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'hcaptcha' => [
            'required',
            'hcaptcha',
        ],
    ];
}
