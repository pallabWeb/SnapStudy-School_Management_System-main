$(document).ready(function () {
  // Load Feather icons asynchronously
  feather.replace();

  // Initialize DataTable with Buttons extension
  $("#example").DataTable({
    // Disable sorting on last column
    columnDefs: [{ orderable: true, targets: -1 }],
    language: {
      // Customize pagination prev and next buttons: use arrows instead of words
      paginate: {
        previous: "<span>prev</span>",
        next: "<span>next</span>",
      },
      // Customize number of elements to be displayed
      lengthMenu:
        'Display <select class="form-control input-sm">' +
        '<option value="3">3</option>' +
        '<option value="5">5</option>' +
        '<option value="10">10</option>' +
        '<option value="20">20</option>' +
        '<option value="-1">All</option>' +
        "</select> results",
    },
  });
});