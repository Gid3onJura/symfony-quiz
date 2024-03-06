;(function () {
  "use strict"

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll(".needs-validation")

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add("was-validated")
      },
      false
    )
  })
})()

$(document).ready(function () {
  // show toasts
  $(document).ready(function () {
    $(".toast").toast("show")
  })

  // validate registration form
  validateForm("registrationForm")
})

function validateForm(formid) {
  const form = document.querySelector("#" + formid)
  let response = null

  form.addEventListener(
    "submit",
    function (event) {
      event.preventDefault()
      event.stopPropagation()
      if (!form.checkValidity()) {
      } else {
        // check data
        switch (formid) {
          case "registrationForm":
            const serializedFormData = $(form).serialize()
            const accessCode = $("#inputAccessCode").val()
            $.post("/ajax/checkregistration", serializedFormData).done(function (response) {
              if (response && !response.message) {
                Swal.fire({
                  title: "Hinweis!",
                  html:
                    "Bitte merk dir den Code <strong>" +
                    accessCode +
                    "</strong>. Nur damit kannst du deine Erfolge einsehen und an Gruppenspielen teilnehmen.",
                  icon: "info",
                  confirmButtonText: "Gemerkt!",
                }).then(function () {
                  // submit form
                  form.submit()
                })
              }
            })
        }
      }

      form.classList.add("was-validated")
    },
    false
  )
}
