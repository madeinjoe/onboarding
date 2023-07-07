$j = jQuery.noConflict()
$j(function ($) {
  /** Jquery */
  /** Select by id */
  console.log('select by id prd-div-1: ')
  console.log($('#prd-div-1')[0])
  console.log('------------------------')
  /** Select by class */
  console.log('select by class class-prd-div: ')
  console.log($('.class-prd-div'))
  console.log('------------------------')
  /** Select by attribute */
  console.log('select by data-extra: ')
  console.log($('[data-extra=prd-extra-1]')[0])
  console.log('------------------------')
  /** Manipulate Value */
  console.log('change value select element to prd-div: ')
  console.log($('#select-dom').val('prd-div'))
  console.log('------------------------')
  /** Manipulate HTML */
  console.log('change text element product no 2 title into "New Product 2 title" : ')
  console.log($('#prd-title-2').html('New Product 2 title'))
  console.log('------------------------')
  /** Manipulate Attribute value */
  console.log('change text element product no 2 attribute data-extra from "prd-extra-2" into "new-prd-extra-2" : ')
  console.log('before : ' + $('#prd-div-html-2').attr('data-extra'))
  console.log($('#prd-div-html-2').attr('data-extra', 'new-prd-extra-2'))
  console.log('after : ' + $('#prd-div-html-2').attr('data-extra'))
  console.log('------------------------')
  /** Custom Event */
  $("#launch-event-clicked").on("click", function (e) {
    console.log('custom event "custom-event-jquery" will show alert and log after launch event button is clicked ')
    $('#second-event-trigger').trigger("custom-event-jquery")
    console.log('this is trigger by click launch')
    console.log('------------------------')
  })
  $("#second-event-trigger").on("custom-event-jquery", function (e) {
    alert('this is called after trigger')
    console.log('this is trigger by custom-event-jquery')
    console.log('------------------------')
  })
  /** Event listen to change */
  $("select[name=n-select-by]").on("change", function (e) {
    console.log('Selected By Value : ' + $(this).val())
    console.log('------------------------')
  })
  /** Event listen to Click */
  $("#launch2-event-clicked").on("click", function (e) {
    console.log('Click will show alert and log after launch2 event button is clicked')
    console.log('this is trigger by click launch2')
    console.log('------------------------')
  })
  /** Event listen to Input */
  $("#change-dom-html").on("input", function (e) {
    console.log('Click will show alert and log after change-dom-html input value is change')
    console.log($(this).val())
    console.log('------------------------')
  })
  /** Set Localstorage */
  $("#set-local-storage").on('click', function (e) {
    console.log($("#store-ls").val())
    localStorage.setItem("ls-x-fortask", $("#store-ls").val());
  })
  /** Get Localstorage */
  $("#get-local-storage").on('click', function (e) {
    const val = localStorage.getItem("ls-x-fortask", $("#store-ls").val());
    console.log('the value of localStorage with name ls-x-fortask : ' + val)
    $("#store-ls").val('val')
  })
  /** Set Cookie */
  $("#set-cookie").on('click', function (e) {
    console.log($("#store-cookie").val())
    document.cookie = "x-fortask-c=" + $("#store-cookie").val() + ';path=/'
    $.cookie("x-fortask-c", $("#store-cookie").val());
  })

  $("select[name=n-select-prd]").find('option[value=all]').hide()

  $("#btn-get-dom").on("click", function (e) {
    if ($("select[name=n-select-dom]").val() === '' || $("select[name=n-select-prd]").val() === '') {
      alert('Please select element and product to get')
    } else {
      const selectorVal = setSelector()
      let el = []

      if (selectorVal.selectBy === 'by-id') {
        el = $('#' + selectorVal.selectEl + (selectorVal.selectPrd !== 'all' ? '-' + selectorVal.selectPrd : ''))[0]
      } else {
        el = $('.class-' + selectorVal.selectEl + (selectorVal.selectPrd !== 'all' ? '-' + selectorVal.selectPrd : ''))
      }
      console.log(el)
    }
  })

  $("#btn-change-html").on("click", function (e) {
    if ($("select[name=n-select-dom]").val() === '' || $("select[name=n-select-prd]").val() === '') {
      alert('Please select element and product to change')
    } else {
      const selectorVal = setSelector()
      let el = []

      if (selectorVal.selectBy === 'by-id') {
        $('#' + selectorVal.selectEl + (selectorVal.selectPrd !== 'all' ? '-' + selectorVal.selectPrd : '')).innerHTML = $('input[name=n-change-dom-html]').val()
      } else {
        $('.class-' + selectorVal.selectEl + (selectorVal.selectPrd !== 'all' ? '-' + selectorVal.selectPrd : '')).innerHTML = $('input[name=n-change-dom-html]').val()
      }
      console.log(el)
    }
  })

  $("#btn-add-html").on("click", function (e) {
    console.log('btn-add-html')
  })

  $("#btn-add-class").on("click", function (e) {
    console.log('btn-add-class')
  })

  $("#btn-add-attr-name").on("click", function (e) {
    console.log('btn-add-attr-name')
  })

  $("#btn-add-attr-value").on("click", function (e) {
    console.log('btn-add-attr-value')
  })

  $("select[name=n-select-by]").on("change", function (e) {
    if ($(this).val() === 'by-class') {
      $("select[name=n-select-prd]").val('all')
      $("select[name=n-select-prd]").prop('disabled', true)
    } else {
      $("select[name=n-select-prd]").val('')
      $("select[name=n-select-prd]").prop('disabled', false)
      $("select[name=n-select-prd]").find('option[value=all]').hide()
    }
  })

  function setSelector() {
    let v = {};
    v.selectBy = $("select[name=n-select-by]").val()
    v.selectEl = $("select[name=n-select-dom]").val()
    v.selectPrd = $("select[name=n-select-prd]").val()
    v.selectAttr = $("select[name=n-select-attr]").val()

    return v
  }

})