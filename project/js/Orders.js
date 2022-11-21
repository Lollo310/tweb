/**
 * Codice JavaScript per orders.php.
 * @author Michele Lorenzo
 */

$(function () {
  getOrders();
})

/**
 * Query Ajax per la lista di ordini.
 */
function getOrders() {
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/OrdersController.php",
    {
      comand: 'get orders'
    },
    printOrders,
    "json"
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();
    $("#orderList").append("<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>");
  });
}

/**
 * Stampa gli ordini.
 * @param {any} data risposta Ajax.
 */
function printOrders(data) {
  if (data.error) // se settato, stampa l'errore
    $('#orderList').append("<div>" + data.error + "</div>");
  else {
    for (let i = 0; i < data.length; i++) {
      const order = data[i];
      let dateOfPurchase = new Date(order.date_of_purchase);
      let dateOfShipping = new Date(dateOfPurchase.getTime() + 3*24*60*60*1000);
      let dateDiff = new Date() - dateOfPurchase;
  
      $('#orderList').append(orderCard(order.no, order.address, dateOfShipping.toDateString(), getStatus(dateDiff)));
      setBar(order.no, dateDiff);
      $('#orderList').append("<div  id='productList" + order.no + "'>");
      getProductsByOrder(order.no);
      $('#orderList').append("</div>");
      $("#productList" + order.no).hide();
      $("#button" + order.no).click(() => slideOrder(order.no));
    }
  }
}

/**
 * Crea la preview delle info dell'ordine.
 * @param {int} no numero dell'ordine.
 * @param {string} address indirizzo di consegna.
 * @param {Date} data data di acquisto.
 * @param {string} status stato dell'ordine.
 * @returns preview delle info dell'ordine.
 */
function orderCard(no, address, data, status) {
  return "<div class='card mb-0' id='" + no + "'>" +
    "<div class='card-body'>" +
    "<div class='d-flex justify-content-between'>" +
    "<div class='d-flex flex-row align-items-center'>" +
    "<div class='ms-3 order-info'>" +
    "<h5 class='mb-1'>Order no." + no + "</h5>" +
    "<p class='mb-0'>" + address + "</p>" +
    "<p class='mt-2'>Expect it <span class='fw-bolder'>" + data + "</span>, " +
    "status: <span class='fw-bolder'>" + status + "</span></p>" +
    "<div class='progress'>" +
    "<div role='progressbar' id='bar" + no + "'>" +
    "</div></div></div></div>" +
    "<div class='d-flex flex-row align-items-center'>" +
    "<p class='mt-2 fs-5'>Total: <span class='price'></span>€<p>" +
    "<button class='btn btn-lg mx-2 mt-2' id='button" + no + "'><i class='bi bi-chevron-down'></i></button>" +
    "</div></div></div></div>";
}

/**
 * Query Ajax per la lista dei prodotti.
 * @param {int} orderId id dell'ordine.
 */
function getProductsByOrder(orderId) {
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/OrdersController.php",
    {
      comand: 'get products',
      id: orderId
    },
    printProducts,
    "json"
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();
    $("#orderList").append("<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>");
  });
}

/**
 * Stampa i prodotti.
 * @param {any} data risposta Ajax.
 */
function printProducts(data) {
  if (data.error) // se settato, stampa l'errore
    $('#orderList').append("<div>" + data.error + "</div>");
  else {
    var subtotal = 0;

    for (let i = 0; i < data.length; i++) {
      const product = data[i];
      var no = product.order;

      $("#productList" + no).append(
        productCard(product.id, product.brand, product.name, ROOT + product.img, product.size, product.condition, product.price)
      );
      
      subtotal += Number(product.price);
    }

    $("#" + no).find('.price').html(subtotal + 5);
  }
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
  return "<div class='card' id='" + id + "'>" +
    "<div class='card-body'>" +
    "<div class='d-flex justify-content-between'>" +
    "<div class='d-flex flex-row align-items-center'><div>" +
    "<img src='" + img + "' class='img-fluid rounded-3 shopping-item' alt='Ordered item'>" +
    "</div><div class='ms-3'>" +
    "<h5>" + brand + " " + name + "</h5>" +
    "<p class='small mb-0'>" + size + ", " + condition + "</p>" +
    "</div></div>" +
    "<div class='d-flex flex-row align-items-center'>" +
    "<div><h5 class='mb-0 me-5'><span id='productPrice" + id + "'>" + price + "</span>€</h5>" +
    "</div></div></div></div></div>";
}

/**
 * Gestione icona per visualizzare la lista dei prodotti.
 * @param {int} no numero dell'ordine.
 */
function slideOrder(no) {
  let icon = $("#button" + no).children();

  if (icon.hasClass("bi-chevron-up")) {
    icon.removeClass("bi-chevron-up");
    icon.addClass("bi-chevron-down");
  } else {
    icon.removeClass("bi-chevron-down");
    icon.addClass("bi-chevron-up");
  }

  $("#productList" + no).slideToggle("slow");
}

/**
 * Calcola lo stato dell'orine.
 * @param {Date} dateDiff differenza tra la data di consegna e la data di acquisto
 * @returns stato dell'ordine.
 */
function getStatus(dateDiff) {
  const orderStatus = ["Order Placed", "Packed", "Shipped", "Delivered"];
  let days = Math.floor(dateDiff/(24*60*60*1000));
  
  days = (days > 3) ? 3 : days;

  return orderStatus[days];
}

/**
 * Imposta la barra di stato della spedizione.
 * @param {int} no numero dell'orine.
 * @param {Date} dateDiff differenza tra la data di consegna e la data di acquisto
 */
function setBar(no, dateDiff) {
  const barStatus = ["w-25","w-50","w-75","progress-bar bg-success w-100"];
  let defaultClass = "progress-bar-striped bg-warning progress-bar-animated ";
  let days = Math.floor(dateDiff/(24*60*60*1000));

  days = (days > 3) ? 3 : days;
  $("#bar" + no).addClass((days == 3) ? barStatus[days] : defaultClass + barStatus[days]);
}