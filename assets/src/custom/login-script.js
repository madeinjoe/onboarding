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

  /** Login Form Submission */
  $("#login-form").on('submit', function (e) {
    e.preventDefault()

    $.ajax({
      url: clData.loginUrl,
      method: 'POST',
      headers: { 'Content-type': 'application/x-www-form-urlencoded' },
      data: $(this).serialize(),
      statusCode: {
        200: function (response) {
          alert(response.message)
          $('#login-form')[0].reset()
          window.location.replace(response.data.redirect)
        },
        400: function (response) {
          document.getElementById('error-msg').innerHTML = response.responseJSON.message
          $('#error-msg').removeClass('hidden')
          // alert(response.responseJSON.message)
        },
        500: function (response) {
          $('#error-msg').removeClass('hidden')
          $('#error-msg').innerHTML = response.responseJSON.message
        }
      }
    })
  })
})
