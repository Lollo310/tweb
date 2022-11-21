/**
 * Codice JavaScript per shopping-cart.php.
 * @author Michele Lorenzo
 */

$(function () {
  $("div.alert").hide();
  $("#nItems").html(0);
  $("form[name='checkout']").on("submit", event => event.preventDefault());
  $("#back").click(() => redirect({location: ROOT + "views/home-page.php"}));

  printTotal(0); 
  getProducts();

  // controlli per il form
  $("form[name='checkout']").validate({
    rules: {
      cardholderName: "required",
      cardNumber: {
        required: true,
        number: true, 
        minlength: 16,
        maxlength: 16
      },
      expMonth: {
        required: true,
        minlength: 2,
        maxlength: 2
      },
      expYear: {
        required: true,
        minlength: 4,
        maxlength: 4
      },
      cvv: {
        required: true,
        minlength: 3,
        maxlength: 3
      },
      address: "required",
      cap: {
        required: true,
        number: true,
        minlength: 5,
        maxlength: 5
      },
      city: "required"
    },
    errorClass: "text-danger",
    submitHandler: form => {
      if (checkData($("#expMonth").val(), $("#expYear").val())) 
        checkout();
    }
  });
})

/**
 * Altri controlli per il form.
 * @param {int} expMonth mese di scadenza della carta.
 * @param {int} expYear anno di scadenza della carta.
 * @returns true se il form è valido.
 */
function checkData(expMonth, expYear) { 
  let currentDate = new Date();
  let currentYear = currentDate.getFullYear();
  let currentMonth = currentDate.getMonth();
  let valid = true;

  $(".removable").remove();  

  if (expMonth > 12 || expYear < currentYear || (expYear == currentYear && expMonth < currentMonth)) {
    valid = false;
    $("#expMonth").addClass("text-danger");
    $("#expYear").addClass("text-danger");
    $("#expDiv").append("<div class='text-danger removable'>The card has expired or month is incorrect.</div>");
  }

  if (Number($('#subtotal').html()) == 0) {
    valid = false;
    $(".cleanable").remove();
    $("div.alert").append("<span class='cleanable'> The shopping cart is empty.</span>");
    $("div.alert").show();
  } 
 
  return valid;
}

/**
 * Query Ajax per il checkout dell'ordine.
 */
function checkout() {
    $.post(
      "http://localhost/TWeb/GitLab2/tweb/project/controllers/ShoppingCartController.php",
      {
        comand: "redirect",
        address: $('#address').val() + ", " + $('#cap').val() + ", " + $('#city').val(),
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
 * Query Ajax per la lista di prodotti nel carello.
 */
function getProducts() {
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/ShoppingCartController.php",
    {
      comand: "get products"
    },
    printAllProducts,
    "json"
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();
    $("div.alert").append("<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>");
    $("div.alert").show();
  });
}

/**
 * Stampa dei prodotti nel carello.
 * @param {any} data risposta Ajax.
 */
function printAllProducts(data) {
  if (data.error) // se settato, stampa l'errore
    $('#productList').append("<div>" + data.error + "</div>");
  else if (!data.message)
    for (let i = 0; i < data.length; i++) 
      printProduct(data[i]);
}

/**
 * Stampa della preview del singolo prodotto.
 * @param {any} product prodotto.
 */
function printProduct(product) {
  let n = $('#nItems').html();
  let subtotal = Number($("#subtotal").html());
  
  n++;
  $('#nItems').html(n);
  $('#productList').append(productCard(product.id, product.brand, product.name, ROOT + product.img, product.size, product.condition, product.price));
  $("#product"+ product.id).click(deleteItem);
  printTotal(subtotal + Number(product.price)); 

}

/**
 * Crea la preview delle info del prodotto.
 * @param {int} id id prodotto.
 * @param {String} brand brand del prodotto.
 * @param {String} name nome del prodotto.
 * @param {String} img URL dell'immagine del prodotto.
 * @param {String} size RAM e memoria del prodotto. 
 * @param {String} condition condizioni del prodotto.
 * @param {Number} price prezzo di vendita del prodotto.
 * @returns preview delle info del prodotto.
 */
function productCard(id, brand, name, img, size, condition, price) {
  return "<div class='card mb-3 product"+ id +"'>" +
    "<div class='card-body'>" +
    "<div class='d-flex justify-content-between'>" +
    "<div class='d-flex flex-row align-items-center'><div>" +
    "<img src='" + img + "'" +
    "class='img-fluid rounded-3 shopping-item' alt='Shopping item'></div>" +
    "<div class='ms-3'>" +
    "<h5>"+ brand + " " + name + "</h5>" +
    "<p class='small mb-0'>" + size + ", " + condition + "</p>" +
    "</div></div>" +
    "<div class='d-flex flex-row align-items-center'>" +
    "<div class='btn-delete'>" +
    "<h5 class='mb-0'><span class='price'>" + price + "</span>€</h5></div>" +
    "<button class='btn-close' id='product"+ id +"'></button>" +
    "</div></div></div></div>"
}

/**
 * Elimina un prodotto dal carello.
 */
function deleteItem() {
  let productId = $(this).attr('id');
  let n = $('#nItems').html();
  let subtotal = Number($("#subtotal").html());
  let price = Number($('.' + productId).find('.price').html());
  
  n--;
  $('#nItems').html(n);
  $('.' + productId).fadeOut('slow', () => $('.' + productId).remove());
  printTotal(subtotal - price);

  // query Ajax per eliminare il prodotto dai cookies.
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/ShoppingCartController.php",
    {
      comand: "delete product",
      id: productId.substr(7,8)
    },
    () => {}
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();
    $("div.alert").append("<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>");
    $("div.alert").show();
  });
}

/**
 * Stampa il totale.
 * @param {Number} subtotal totale parziale.
 */
function printTotal(subtotal) {
  $("#subtotal").html(Number(subtotal).toFixed(2));
  $("#total").html("€" + Number(subtotal + 5).toFixed(2));
}

function redirect(data) {
  if (data.location)     
    $(window.location).attr("href", data.location);
  else {
    $(".cleanable").remove();
    $("div.alert").append("<span class='cleanable'> " + data.error + "</span>"); 
    $("div.alert").show();
  }
}