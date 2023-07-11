$j = jQuery.noConflict()
$j(function ($) {
  /** Password Toggle */
  $(".password-sh-toggle").on('click', function (e) {
    $(e.target).addClass('hidden')

    if ($(e.target).hasClass('pw-s')) {
      $(e.target).siblings('.pw-h').removeClass('hidden')
      $(e.target).siblings('input').attr('type', 'text')
    } else {
      $(e.target).siblings('input').attr('type', 'password')
      $(e.target).siblings('.pw-s').removeClass('hidden')
    }
  })

  /** Registration Form Submission */
  $("#registration-form").on('submit', function (e) {
    e.preventDefault()

    $.ajax({
      url: caData.registrationUrl,
      method: 'POST',
      // headers: { 'Content-type': 'application/x-www-form-urlencoded' },
      data: $(this).serialize(),
      statusCode: {
        200: function (response) {
          alert(response.message)
          $('#registration-form')[0].reset()
          window.location.replace(response.data.redirect)
        },
        400: function (response) {
          document.getElementById('error-msg').innerHTML = response.responseJSON.message
          $('#error-msg').removeClass('hidden')
          const errors = response.responseJSON.errors

          if (errors['registration-username']) {
            $("#ft-registration-username").addClass("input-invalid");

            $("#error-msg-username").show();
            let errorMsg = ''
            errors['registration-username'].forEach(err => {
              errorMsg += err + '<br>'
            });
            $("#error-msg-username").html(errorMsg);
          } else {
            $("#registraiton-email").removeClass("input-invalid");
            $("#error-msg-username").html('');
            $("#error-msg-username").hide();
          }

          if (errors['registraiton-email']) {
            $("#ft-registraiton-email").addClass("input-invalid");

            $("#error-msg-email").show();
            let errorMsg = ''
            errors['registraiton-email'].forEach(err => {
              errorMsg += err + '<br>'
            });
            $("#error-msg-email").html(errorMsg);
          } else {
            $("#registraiton-email").removeClass("input-invalid");
            $("#error-msg-email").html('');
            $("#error-msg-email").hide();
          }

          if (errors['registration-password']) {
            $("#ft-registration-password").addClass("input-invalid");

            $("#error-msg-password").show();
            let errorMsg = ''
            errors['registration-password'].forEach(err => {
              errorMsg += err + '<br>'
            });
            $("#error-msg-password").html(errorMsg);
          } else {
            $("#registraiton-email").removeClass("input-invalid");
            $("#error-msg-password").html('');
            $("#error-msg-password").hide();
          }

          if (errors['registration-re-password']) {
            $("#ft-registration-re-password").addClass("input-invalid");

            $("#error-msg-re-password").show();
            let errorMsg = ''
            errors['registration-re-password'].forEach(err => {
              errorMsg += err + '<br>'
            });
            $("#error-msg-re-password").html(errorMsg);
          } else {
            $("#registraiton-email").removeClass("input-invalid");
            $("#error-msg-re-password").html('');
            $("#error-msg-re-password").hide();
          }

          alert(response.responseJSON.message)
        },
        500: function (response) {
          $('#error-msg').removeClass('hidden')
          $('#error-msg').innerHTML = response.responseJSON.message
        }
      }
    })
  })
})
