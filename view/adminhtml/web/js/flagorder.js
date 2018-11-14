require(
  [
    'jquery',
    'mage/translate',
  ],
  function ($) {
    $(document).ready(function () {
      window.ajaxOrderFlag = function (button) {
        var ajaxRequest = $.ajax(
          {
            showLoader: true,
            url: $(button).data('ajax'),
            data: {form_key: window.FORM_KEY},
          })
          .done(function (data, textStatus, jqXHR) {
            $(button).removeClass('error');
            $(button).toggleClass('flagged');
            $(button).html(data.message);
          })
          .fail(function () {
            $(button).addClass('error');
            $(button).html(data.message);
          });
      };
    });
  }
);