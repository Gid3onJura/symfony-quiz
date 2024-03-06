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
            $.post("/ajax/checkregistration", serializedFormData).done(function (response) {
              if (response && !response.message) {
                // submit form
                $.post("/ajax/register", serializedFormData).done(function (response) {
                  if (response && response.accessCode && response.nickname) {
                    Swal.fire({
                      title: "Registrierung erfolgreich!",
                      html:
                        "Mit folgendem Code <strong>" +
                        response.accessCode +
                        "</strong> kannst du dich einloggen! Merk ihn dir, sonst kannst du dich nicht einloggen oder an Gruppenspielen teilnehmen.",
                      icon: "success",
                      confirmButtonText: "Ok",
                    }).then(function () {
                      // switch to login tab
                      const loginTab = $("#nav-login-tab")
                      loginTab.trigger("click")

                      // set access code and nickname
                      $("#login_code").val(response.accessCode)
                      $("#login_nickname").val(response.nickname)
                    })
                  } else if (response.message) {
                    Swal.fire({
                      title: "Schade!",
                      html: response.message,
                      icon: "error",
                      confirmButtonText: "Ok",
                    })
                  }
                })
              } else if (response.message) {
                Swal.fire({
                  title: "Schade!",
                  html: response.message,
                  icon: "error",
                  confirmButtonText: "Ok",
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
