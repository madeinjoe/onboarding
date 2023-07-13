$j = jQuery.noConflict()
$j(function ($) {
  $('.tab-nav').on('click', function (e) {
    console.log(e.target)
    $(this).next().removeClass('active');
    $(this).prev().removeClass('active');
    $(this).addClass('active');

    const setContent = $(this).attr('data-target');
    $(setContent).next().removeClass('active');
    $(setContent).prev().removeClass('active');
    $(setContent).addClass('active');
  })

  $("#form-add-to-cart").on("submit", function (e) {
    e.preventDefault()

    let post_data = {
      'id' : 1,
      'action' : atcData.action,
      'length' : parseInt($('input[name="length"]').val()),
      'piece' : parseInt($('input[name="piece"]').val())
    }

    console.log(post_data)

    // $.ajax({
    //   url: atcData.url,
    //   method: 'POST',
    //   // headers: { 'Content-type': 'application/x-www-form-urlencoded' },
    //   data: $(this).serialize(),
    // })
  })
})