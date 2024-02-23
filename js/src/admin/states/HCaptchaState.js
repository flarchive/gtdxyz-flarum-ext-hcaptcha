/* global hcaptcha , app */

export default class HCaptchaState {
  constructor(callback, errorCallback = null) {
    this.callback = callback;
    this.errorCallback =
      errorCallback ||
      ((alertAttrs) => {
        // By default, the alert will just be globally
        app.alerts.show(alertAttrs);
      });
    this.widgetId = null;
  }

  render(element) {
    
    this.widgetId = hcaptcha.render(element, {
      sitekey: app.data.settings['gtdxyz-hcaptcha.credentials.site'],
      theme: app.forum.attribute('hCaptchaDarkMode') ? 'dark' : 'light',
      type: app.data.settings['gtdxyz-hcaptcha.type'],
      size: app.data.settings['gtdxyz-hcaptcha.type'] === 'invisible' ? 'invisible' : 'normal',
      callback: this.callback,
      'error-callback': () => {
        // Similarly to error.alert, we create an alert payload that can then be shown in-context depending where the code is called from
        const alertAttrs = {
          type: 'error',
          content: app.translator.trans('gtdxyz-hcaptcha.forum.error'),
        };
        this.errorCallback(alertAttrs);
      },
    });
  }

  getResponse() {
    return hcaptcha.getResponse(this.widgetId);
  }

  execute() {
    return hcaptcha.execute(this.widgetId);
  }

  reset() {
    return hcaptcha.reset(this.widgetId);
  }
}
