const returnBook = async (book_id, borrow_id) => {
  const confirmed = await swal({
    title: "Return Book",
    text: 'Click "OK" to return the book',
    icon: "info",
    buttons: ["No, cancel", "OK"],
    dangerMode: false,
  });

  if (confirmed) {
    try {
      const sendData = { book_id, borrow_id };
      const res = await fetch("borrowedBookAction/return.php", {
        method: "POST",
        headers: { "Content-type": "application/json" },
        body: JSON.stringify(sendData),
      });

      if (!res.ok) {
        throw new Error("Network response was not ok.");
      }

      // Success Swal
      await swal({
        title: "Book Returned!",
        text: "The book has been successfully returned.",
        icon: "success",
        button: "OK",
      });

      // Reload after confirmation
      location.reload();

    } catch (error) {
      console.error("Error: " + error.message);
      swal("Error!", "There was an error processing your request.", "error");
    }
  }
};

const lostBook = async (book_id, borrow_id, id, student_number) => {
  const confirmed = await swal({
    title: "Lost Book",
    text: "Make sure that you really the book\nYou may suspend from this automatically",
    icon: "warning",
    buttons: ["No, cancel", "OK"],
    dangerMode: false,
  });
  if (confirmed) {
    try {
      const sendData = {
        book_id: book_id,
        borrow_id: borrow_id,
        id: id,
        student_number: student_number,
      };
      const res = await fetch("borrowedBookAction/lost.php", {
        method: "POST",
        headers: { "Content-type": "application/json" },
        body: JSON.stringify(sendData),
      });
      if (!res.ok) {
        return new Error("Network response was not ok.");
      } else {
        location.reload();
      }
    } catch (error) {
      console.error("Error: " + error.message);
      swal("Error!", "There was an error processing your request.", "error");
    }
  }
};
