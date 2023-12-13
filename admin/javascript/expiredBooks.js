var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

toggleButton.onclick = function () {
  el.classList.toggle("toggled");
};

$(document).ready(function () {
  $("#tbl-return-request").DataTable({});

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
const sendMessage = async (student_number, id, title) => {
  const data = {
    student_number: student_number,
    id: id,
    title: title,
  };
  try {
    const response = await fetch("expiredBooksAction/sendWarning.php", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify(data),
    });

    if (!response.ok) {
      throw new Error("Network response was not ok.");
    }
    swal({
      title: "Success",
      text: "Message has sent",
      icon: "success",
      buttons: "Ok",
      dangerMode: false,
    });
  } catch (error) {
    console.error("Error:", error.message);
  }
};

const Suspend = async (id, student_number) => {
  const confirmed = await swal({
    title: "Confirmation",
    text: "Click Yes to Suspend the user",
    icon: "info",
    buttons: ["No, cancel", "Yes"],
    dangerMode: true,
  });
  if (confirmed) {
    const studentNumber = {
      id: id,
      student_number: student_number,
    };
    try {
      const response = await fetch("expiredBooksAction/suspension.php", {
        method: "POST",
        headers: {
          "Content-type": "application/json",
        },
        body: JSON.stringify(studentNumber),
      });

      if (!response.ok) {
        throw new Error("Network response was not ok.");
      }
      swal({
        title: "Success",
        text: "Suspended Success",
        icon: "success",
        buttons: "Ok",
        dangerMode: false,
      });
      const data = await response.json();
      console.log(data);
    } catch (error) {
      console.error(error);
    }
  }
};

const Blockuser = async (id, student_number) => {
  const confirmed = await swal({
    title: "Confirmation",
    text: "Are you sure you want to block this user?\nBlocked users cannot log in.",
    icon: "info",
    buttons: ["No, Cancel", "Yes"],
    dangerMode: true,
  });
  if (confirmed) {
    try {
      const dataToSend = {
        id: id,
        student_number: student_number,
      };
      const response = await fetch("expiredBooksAction/blacklist.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(dataToSend),
      });
      if (!response.ok) {
        return new Error("Network response was not ok.");
      }
      swal({
        title: "Blocked",
        text: "Blocked User",
        icon: "success",
      });
      setTimeout(() => {
        location.reload();
      }, 1500);
    } catch (error) {
      console.error(error);
      swal({
        title: "Error",
        text: "Failed to block the user. Please try again later.",
        icon: "error",
      });
    }
  } else {
    return;
  }
};
