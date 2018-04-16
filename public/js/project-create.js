$(function () {

  function escapeHtml (string) {
    if(typeof string !== 'string') {
      return string;
    }
    return string.replace(/[&'`"<>]/g, function(match) {
      return {
        '&': '&amp;',
        "'": '&#x27;',
        '`': '&#x60;',
        '"': '&quot;',
        '<': '&lt;',
        '>': '&gt;',
      }[match]
    });
  }

  // Sync property checked with label class
  $.fn.syncLabelStateChecked = function (checkedClass) {
    return $(this).each(function () {
      if ($(this).prop('checked')) {
        $(this).parents('label').addClass(checkedClass);
      } else {
        $(this).parents('label').removeClass(checkedClass);
      }
    })
  }

  // Animation when click to # link
  $('a[href^="#"]').click(function() {
    var speed = 700;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top - 25;
    $('body,html').animate({scrollTop:position}, speed, 'swing');
    return false;
  });

  // Checkbox and radio
  $('#project-form').on('change', 'input[type=checkbox],input[type=radio]', function () {
    var checked, name, values, $allInputs, $checkedInputs, $inputAll, $output;

    // Highlight checked input
    checked = $(this).syncLabelStateChecked('on').prop('checked');
    name = $(this).attr('name');

    // Process check box select all
    if ($(this).data('checkall')) {
      name = $(this).data('checkall');
      $allInputs = $('#project-form input[name="' + name + '"]')
        .prop('checked', checked)
        .syncLabelStateChecked('on');

      $checkedInputs = $allInputs.filter(function () {
        return $(this).prop('checked') === true
      });
    } else {
      $inputAll = $('#project-form input[data-checkall="' + name + '"]');
      $allInputs = $('#project-form input[name="' + name + '"]');
      $checkedInputs = $allInputs.filter(function () {
        return $(this).prop('checked') === true
      });

      if ($inputAll.length > 0) {
        $inputAll
          .prop('checked', $allInputs.length === $checkedInputs.length)
          .syncLabelStateChecked('on');
      }
    }

    $output = $('#project-form output[data-input="' + name + '"]');
    values = $checkedInputs
      .map(function () {
        return this.value
      })
      .get();

    // Append other value for .arrangeAnything
    if (name === 'ab') {
      var other = $('#project-form input[name="' + name + '_other"]').val();
      if (other != '') {
        values.push(other);
      }
    }

    // Sync values of input and output
    $output.val(values.join(','));
  });

  // Sync values of input[type=text] and output
  $('#project-form').on('change', 'input[type=text],textarea', function () {
    var name = $(this).attr('name');
    $('#project-form output[data-input="' + name + '"]').val($(this).val());
  });

  // Handle choice a plan
  $('#request_form a').on('click', function () {
    $(this).parent('li').find('input[name=plan]').prop('checked', true).trigger('change');

    // TODO: init slider
  });

  // Alias click event of table
  $('#request_form_table th, #request_form_table td').click(function (event) {
    $($("#request_form li").get($(event.currentTarget).index()))
      .find('a').trigger('click');
  });

  // Show more another movie type
  $('#movie_type_another').on('click', function (e) {
    e.preventDefault();
    $('.bind_movie_type>li').removeClass('hidden');
    $(this).addClass('hidden');
  })
});
