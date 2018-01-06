$(document).ready(function() {
  var $currentButton = $('.modify');
  $currentButton.click(function(e) {
    e.preventDefault();
    if ($(this).html() == '<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>') {
      $currentRow = $(this).parents('tr').find('td.possible');
      $currentRow.prop('contenteditable', true).toggleClass('canEdit');
      $(this).removeClass('btn-primary').addClass('btn-success').empty().html('<i class="fa fa-fw fa-check" aria-hidden="true"></i>');
    } else if ($(this).html() == '<i class="fa fa-fw fa-check" aria-hidden="true"></i>') {
      $currentRow.prop('contenteditable', false).removeClass('canEdit');
      $(this).removeClass('btn-success').addClass('btn-primary').empty().html('<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>');
    }
    // $.ajax({
    //   type: 'POST',
    //   url: 'save.php',
    //   data: {
    //     url: 
    //   },
    //   success: function(data) {
    //    
    //   }
    // });
  });
});
