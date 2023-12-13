var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

const sendData = async (
  id,
  book_id,
  studentnumber,
  title,
  borrow_id,
  full_name
) => {
  try {
    const confirmed = await swal({
      title: "Confirmation",
      text: "Click Yes to issue the book",
      icon: "info",
      buttons: ["No, cancel", "Yes, issue it!"],
      dangerMode: false,
    });

    if (confirmed) {
      const dataToSend = {
        id: id,
        book_id: book_id,
        studentnumber: studentnumber,
        title: title,
        borrow_id: borrow_id,
        full_name: full_name,
      };
      const response = await fetch("issueBookAction/issued.php", {
        method: "POST",
        headers: {
          "Content-type": "application/json",
        },
        body: JSON.stringify(dataToSend),
      });
      swal({
        title: "Information",
        text: "Issued Book",
        icon: "success",
        buttons: "Ok",
        dangerMode: false,
      });
      setTimeout(() => {
        location.reload();
      }, 1500);
    }
  } catch (error) {
    console.error("Error:", error);
  }
};

const deleteData = async (borrow_id) => {
  swal({
    title: "Confirmation",
    text: "Click OK to deny the request",
    icon: "warning",
    buttons: ["No, cancel", "OK, deny it!"],
    dangerMode: true,
  }).then((confirmed) => {
    if (confirmed) {
      try {
        const data = {
          borrow_id: borrow_id,
        };
        fetch("issueBookAction/denied.php", {
          method: "POST",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Network response was not ok.");
            }
            return response.text();
          })
          .then((datos) => {
            location.reload();
            console.log("Request Denied!");
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      } catch (error) {
        console.error("Error:", error);
      }
    }
  });
};

toggleButton.onclick = function () {
  el.classList.toggle("toggled");
};

$(document).ready(function () {
  $("#tbl-issue-book").DataTable({});

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
