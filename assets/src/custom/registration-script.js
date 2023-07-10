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
    // console.log(caData.registrationUrl);
    // console.log($(this).serialize());

    $.ajax({
      url: caData.registrationUrl,
      method: 'POST',
      // headers: { 'Content-type': 'application/x-www-form-urlencoded' },
      data: $(this).serialize(),
      statusCode: {
        200: function (response) {
          console.log(response)
          // alert(response.message)
          // $('#registration-form')[0].reset()
          // window.location.replace(response.data.redirect)
        },
        400: function (response) {
          console.log(response)
          console.log(response.responseJSON)
          // document.getElementById('error-msg').innerHTML = response.responseJSON.message
          // $('#error-msg').removeClass('hidden')
          // alert(response.responseJSON.message)
        },
        500: function (response) {
          console.log(response)
          console.log(response.responseJSON)
          // $('#error-msg').removeClass('hidden')
          // $('#error-msg').innerHTML = response.responseJSON.message
        }
      }
    })
  })
})
