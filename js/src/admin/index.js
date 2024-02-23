import app from 'flarum/admin/app';
import extendCreateUser from './extendCreateUser';

app.initializers.add('gtdxyz-hcaptcha', () => {
  app.hcaptchaLoaded = false;
  app.extensionData
    .for('gtdxyz-hcaptcha')
    .registerSetting({
      label: app.translator.trans('gtdxyz-hcaptcha.admin.settings.help_text', {
        a: <a href="https://dashboard.hcaptcha.com/settings" target="_blank" rel="noopener" />,
      }),
      type: 'hidden',
    })
    .registerSetting({
      setting: 'gtdxyz-hcaptcha.type',
      label: app.translator.trans('gtdxyz-hcaptcha.admin.settings.type_label'),
      options: {
        checkbox: 'Checkbox',
        invisible: 'Invisible',
      },
      required: true,
      default: 'checkbox',
      type: 'select',
    })
    .registerSetting({
      setting: 'gtdxyz-hcaptcha.credentials.site',
      label: app.translator.trans('gtdxyz-hcaptcha.admin.settings.site_key_label'),
      type: 'text',
      required: true,
    })
    .registerSetting({
      setting: 'gtdxyz-hcaptcha.credentials.secret',
      label: app.translator.trans('gtdxyz-hcaptcha.admin.settings.secret_key_label'),
      type: 'password',
      required: true,
    })
    .registerPermission(
      {
        permission: 'gtdxyz-hcaptcha.postWithoutHCaptcha',
        label: app.translator.trans('gtdxyz-hcaptcha.admin.permissions.post_without_hcaptcha'),
        icon: 'fas fa-robot',
      },
      'reply'
    );

    extendCreateUser();
});
