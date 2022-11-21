/**
 * Codice JavaScript per new-product.php.
 * @author Michele Lorenzo
 */

$(function () {
  $("form[name='newProduct']").on("submit", function (event) { event.preventDefault() });
  $("#upload").click(upload);
  $("div.alert-danger").hide();
  $("div.alert-success").hide();

  // query Ajax per controllare se l'utente è un venditore.
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/NewProductController.php",
    { comand: 'check is seller' },
    redirect,
    "json"
  );

  // controlli per il form
  $("form[name='newProduct']").validate({
    rules: {
      name: "required",
      model: "required",
      yearOfProduction: {
        required: true,
        number: true,
        maxlength: 4,
        minlength: 4
      },
      ram: {
        required: true,
        number: true
      },
      memory: {
        required: true,
        number: true
      },
      euro: {
        required: true,
        number: true
      },
      cent: {
        required: true,
        number: true,
        minlength: 2,
        maxlength: 2
      }
    },
    errorClass: "text-danger",
    submitHandler: form => {
      if (checkData())
        addProduct();
    }
  });
})

/**
 * Altri controlli per il form.
 * @returns true se il form è valido.
 */
function checkData() {
  let valid = true;

  $(".removable").remove();

  if (!$("#img").val()) {
    valid = false;

    $("#imgDiv").append("<div class='text-danger removable2 removable'>Please select an image.</div>");
  }

  if (!$("#termsOfUse")[0].checked) {
    valid = false;

    $("#termsDiv").append(
      "<div class='text-danger removable'>Please accept the Terms & Condition before submitting.</div>"
    );
  }

  return valid;
}

/**
 * Query Ajax per aggiungere un prodotto da vendere.
 */
function addProduct() {
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/NewProductController.php",
    {
      comand: "add product",
      brand: $("#brand").val(),
      name: $("#name").val(),
      model: $("#model").val(),
      yearOfProduction: $("#yearOfProduction").val(),
      img: $("#img").val(),
      size: $("#ram").val() + "/" + $("#memory").val(),
      condition: $("#condition").val(),
      price: $("#euro").val() + "." + $("#cent").val()
    },
    printResponse,
    "json"
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();

    $("div.alert-danger").append("<span class='cleanable'> Fatal error: "
      + errorThrown
      + ": "
      + textStatus
      + "</span>"
    );

    $("div.alert-success").hide()
    $("div.alert-danger").show();
  });
}

/**
 * Query Ajax per caricare l'immagine del prodotto.
 */
function upload() {
  let fd = new FormData();
  let file = $("#img")[0].files;

  if (file.length > 0) {
    fd.append('file', file[0]);

    $.ajax({
      url: "http://localhost/TWeb/GitLab2/tweb/project/controllers/NewProductController.php",
      type: "post",
      data: fd,
      contentType: false,
      processData: false,
      success: printResponse
    });
  } else {
    $(".removable2").remove();
    $("#imgDiv").append("<div class='text-danger removable2 removable'>Please select an image.</div>");
  }
}

/**
 * Stampa se il caricamento dell'immagine/prodotto è andata a buon fine.
 * @param {any} data risposta Ajax.
 */
function printResponse(data) {
  try {
    data = jQuery.parseJSON(data);
  } catch (e) { }

  if (data.success) {
    $(".cleanable").remove();
    $("div.alert-success").append("<span class='cleanable'>" + data.success + "</span>");
    $("div.alert-danger").hide();
    $("div.alert-success").show();
  } else {
    $(".cleanable").remove();
    $("div.alert-danger").append("<span class='cleanable'>" + data.error + "</span>");
    $("div.alert-success").hide()
    $("div.alert-danger").show();
  }
}

/**
 * Carica la nuova pagina.
 * @param {any} data risposta Ajax.
 */
function redirect(data) {
  if (data.location)
    $(window.location).attr("href", data.location);
  else if (data.error) {
    $(".cleanable").remove();
    $("div.alert").append("<span class='cleanable'> " + data.error + "</span>");
    $("div.alert").show();
  }
}