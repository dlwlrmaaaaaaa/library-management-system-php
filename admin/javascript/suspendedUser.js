var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

toggleButton.onclick = function () {
  el.classList.toggle("toggled");
};

$(document).ready(function () {
  $("#tbl-borrowed-books").DataTable({});

  // Customizing the search bar
  $(".dataTables_filter input").addClass("form-control");
  $(".dataTables_filter input").attr("placeholder", "Search");
  $(".dataTables_filter label")
    .contents()
    .filter(function () {
      return this.nodeType === 3;
    })
    .remove();

  $(".dataTables_filter input").wrap('<div class="input-group"></div>');
  $(".dataTables_filter input").before(
    '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>'
  );

  $(".dataTables_filter").addClass("col-6");
});
const addCount = async (id, student_number) => {
  const confirmed = await swal({
    title: "Confirmation",
    text: 'Click "OK" to Add Suspension',
    icon: "warning",
    buttons: ["No, cancel", "OK"],
    dangerMode: true,
  });
  if (confirmed) {
    const sendData = {
      id: id,
      student_number: student_number,
    };
    try {
      const response = await fetch("suspendAction/addCount.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(sendData),
      });
      if (!response.ok) {
        throw new Error("Server response was not successful.");
      }
      swal("Success", "Applied Suspension", "success");
      setTimeout(() => {
        location.reload();
      }, 1500);
    } catch (error) {
      console.error(error);
    }
  } else {
    return;
  }
};
