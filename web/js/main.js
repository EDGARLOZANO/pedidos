
$(function () {
      $('#modalButton').click(function () {
          $('#modalClienteCreate').modal('show')
              .find('#modalContent')
              .load($(this).attr('value'));
      });
});

$(function () {
    $('.update-modal-click').click(function () {
        $('#update-modal')
            .modal('show')
            .find('#updateModalContent')
            .load($(this).attr('value'));
    });
});