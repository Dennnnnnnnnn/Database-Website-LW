$(window).ready(function () {

  $(".addChild").click(function () {
    // cloning the form row
    rowClone = $(".formRowsContainer").find(".formRow:first").clone(true, true);

    // remove disabled attributes and the concealment class
    $(rowClone).find("input[type=text], select").prop('disabled', false);
    $(rowClone).removeClass('d-none');

    // clones row is included into the form row container
    rowClone.appendTo($(".formRowsContainer"));

    // concealment class is removed from the form header row
    $(".headerRow").removeClass("d-none");

    //
    return false;
  })

  $(".removeChild").click(function () {
    // remove form row which contains the pressed button
    $(this).closest(".formRow").remove();

    // if the last row is removed, hide the form header
    if ($(".formRowsContainer") && $(".formRowsContainer").find('.formRow').length == 1) {
      $(".headerRow").addClass("d-none");
    }

    //
    return false;
  })

  $('.datepicker').datetimepicker({
    format:'Y-m-d',
    timepicker:false
  });

  $('.datetimepicker').datetimepicker({
    format:'Y-m-d H:i:s'
  });

});

function showConfirmDialog(module, removeId) {
  var r = confirm("Are you sure you want to delete this?");
  if (r === true) {
    window.location.replace("index.php?module=" + module + "&action=delete&id=" + removeId);
  }
}

function showOrderedServiceConfirmDialog(module, contractId, serviceId, dateFrom) {
  var r = confirm("Are you sure you want to delete this?");
  if (r === true) {
    window.location.replace("index.php?module=" + module + "&action=service_delete&contractId=" + contractId + "&serviceId=" + serviceId + "&dateFrom=" + dateFrom);
  }
}
