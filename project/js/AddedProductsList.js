/**
 * Codice JavaScript per added-product-list.php.
 * @author Michele Lorenzo
 */

$(function () {
  getProductsByUser();
})

/**
 * Query Ajax per la lista dei prodotti in vedita dell'utente.
 */
function getProductsByUser() {
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/AddedProductsListController.php",
    {
      comand: 'get products'
    },
    printProducts,
    "json"
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();
    
    $("#addedProductsList").append(
      "<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>"
    );
  });
}

/**
 * Stampa la lista dei prodotti in vedita dell'utente.
 * @param {any} data dati inviati dal server dopo la query Ajax
 */
function printProducts(data) {
  if (data.error) // se settato, stampa l'errore
    $('#addedProductsList').append("<div>" + data.error + "</div>");
  else if (data.location)
    $(window.location).attr("href", data.location);
  else {
    for (let i = 0; i < data.length; i++) {
      const product = data[i];

      $("#addedProductsList").append(
        productCard(product.id,
          product.brand,
          product.name,
          product.model,
          ROOT + product.img,
          product.size,
          product.condition,
          product.price)
      );

      $("#button" + product.id).click(() => deleteProduct(product.id));
    }
  }

  /**
   * Crea una preview delle informazioni prodotto.
   * @param {int} id id del prodotto.
   * @param {string} brand brand del prodotto.
   * @param {string} name nome del prodotto.
   * @param {string} model modello del prodotto.
   * @param {string} img URL dell'immagine del prodotto.
   * @param {string} size RAM e memoria del prodotto.
   * @param {string} condition Condizioni del prodotto.
   * @param {number} price Prezzo di vendita del prodotto.
   * @returns Preview del prodotto.
   */
  function productCard(id, brand, name, model, img, size, condition, price) {
    return "<div class='card' id='" + id + "'>" +
      "<div class='card-body'>" +
      "<div class='d-flex justify-content-between'>" +
      "<div class='d-flex flex-row align-items-center'><div>" +
      "<img src='" + img + "' class='img-fluid rounded-3 added-item' alt='Ordered item'>" +
      "</div><div class='ms-3'>" +
      "<h5 class='mb-1'>" + brand + " " + name + "</h5>" +
      "<p class='small mb-0'>" + model + "</p>" +
      "<p class='small mb-0'>" + size + ", " + condition + "</p>" +
      "</div></div>" +
      "<div class='d-flex flex-row align-items-center'>" +
      "<div><h5 class='mb-0 me-5'>" + price + "€</h5></div>" +
      "<div><button class='btn btn-danger' id='button" + id + "'> Remove </button>" +
      "</div></div></div></div></div>";
  }

  /**
   * Query Ajax per l'eliminazione del prodotto da i prodotti venduti.
   * @param {int} productId id del prodotto.
   */
  function deleteProduct(productId) {
    $.post(
      "http://localhost/TWeb/GitLab2/tweb/project/controllers/AddedProductsListController.php",
      {
        comand: 'delete product',
        id: productId
      },
      () => removeProduct(productId),
      'json'
    ).fail((jqXHR, textStatus, errorThrown) => {
      $(".cleanable").remove();
      $("#addedProductsList").prepend("<span class='cleanable'> Fatal error: "
        + errorThrown
        + ": "
        + textStatus
        + "</span>");
    });
  }

  /**
   * Rimuove il prodotto dalla lista con animazione.
   * @param {int} id id del prodotto da eliminare.
   */
  function removeProduct(id) {
    if (data.error) // se settato, viene stampato l'errore
      $('#addedProductsList').append("<div>" + data.error + "</div>");
    else
      $("#" + id).fadeOut("slow", () => $("#" + id).remove());
  }
}