/**
 * Codice JavaScript per sign-up.php.
 * @author Michele Lorenzo
 */

$(function () {
  $("form[name='signUP']").on("submit", function (event) { event.preventDefault() });
  $("div.alert").hide();

  // controlli per il form.
  $("form[name='signUp']").validate({
    rules: {
      firstName: "required",
      lastName: "required",
      email: {
        required: true,
        email: true
      },
      birthdayDate: "required",
      phoneNumber: {
        required: true,
        number: true
      },
      password: {
        required: true,
        minlength: 8,
        maxlength: 16
      },
      passwordCheck: {
        required: true,
        equalTo: "#password"
      }
    },
    messages: {
      passwordCheck: {
        equalTo: "Please enter the same password."
      },
      termsOfUse: "Please accept the Terms & Condition before submitting."
    },
    errorClass: "text-danger",
    submitHandler: form => {
      if (checkData())
        signUp();
    }
  });
});

/**
 * Query Ajax per il sign up.
 */
function signUp() {
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/SignUpController.php",
    {
      firstName: $("#firstName").val(),
      lastName: $("#lastName").val(),
      birthday: $("input[type='date']").val(),
      gender: $("input[name='radioOptions']:checked").val(),
      email: $("#email").val(),
      phoneNumber: $("#phoneNumber").val(),
      userType: $("#userType").val(),
      password: $("#password").val()
    },
    redirect,
    "json"
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();
    $("div.alert").append("<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>");
    $("div.alert").show();
  });
}

/**
 * Carica la nuova pagina.
 * @param {any} data risposta Ajax.
 */
function redirect(data) {
  if (data.location)
    $(window.location).attr("href", data.location);
  else
    $(".cleanable").remove();
  $("div.alert").append("<span class='cleanable'> " + data.error + "</span>");
  $("div.alert").show();
}

/**
 * Altri controlli per il form.
 * @returns true se il form è valido.
 */
function checkData() {
  let valid = true;

  $(".removable").remove();

  valid = isOver18($("input[type='date']").val());

  if (!$("#termsOfUse")[0].checked) {
    valid = false;

    $("#termsDiv").append(
      "<div class='text-danger removable'>Please accept the Terms & Condition before submitting.</div>"
    );
  }

  return valid;
}

/**
 * Controlla se l'utente è maggiore di 18 anni.
 * @param {Date} birthday data di nascita.
 * @returns true se è maggiore di 18 anni.
 */
function isOver18(birthday) {
  let dateOfBirthday = new Date(birthday);
  let date18YA = new Date();

  date18YA.setFullYear(date18YA.getFullYear() - 18);

  if (dateOfBirthday > date18YA) {
    $("#birthdayDiv").append("<div class='text-danger removable'>You must be 18 years old.</div>");

    return false;
  } else
    return true;
}
