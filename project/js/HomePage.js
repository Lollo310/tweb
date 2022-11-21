/**
 * Codice JavaScript per home-page.php
 * @author Michele Lorenzo 
 */

$(function () {
  $("#productPages").append(
    "<li class='page-item' id='prevPage'><button class='page-link'><i class='bi bi-chevron-double-left'></i></button></li>" +
    "<li class='page-item active'><button class='page-link n-page'>1</button></li>" +
    "<li class='page-item' id='nextPage'><button class='page-link'><i class='bi bi-chevron-double-right'></i></button></li>"
  );

  $("form[name='filters']").on('submit', event => event.preventDefault());
  $("#reset").click(getProducts);
  $("div.alert").hide();
  getProducts();

  $("form[name='filters']").validate({
    rules: {
      priceMin: "number",
      priceMax: "number"
    },
    errorClass: "text-danger",
    submitHandler: filter
  });
})

/**
 * Query Ajax per la lista di prodotti.
 */
function getProducts() {
  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/HomePageController.php",
    {
      comand: 'get products'
    },
    printProductsList,
    "json"
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();
    $("#productContainer").prepend("<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>");
  });
}

/**
 * Stampa la lista di prodotti.
 * @param {any} data risposta Ajax.
 */
function printProductsList(data) {
  if (data.error) // se settato visualizza l'errore
    $("#productContainer").prepend("<div>" + data.error + "</div>");
  else {
    let products = "<div class='row'>";
    let page = $(".active").children().html() - 1;

    $(".products").remove();

    for (let i = 0 + page * 9; i < data.length && i < 9 + page * 9; i++) {
      const product = data[i];

      if (i != 0 && i % 3 == 0)
        products += "</div><div class='row'>";

      products += productCard(product.id, product.brand,
        product.name,
        product.model,
        product.year_of_production,
        ROOT + product.img,
        product.size,
        product.first_name + " " + product.last_name,
        product.condition,
        product.price
      );
    }

    products += "</div>";
    $("#productContainer").prepend(products);
    $(".addCart").click(addCart);
    setPages(page + 1, data.length);
  }
}

/**
 * Imposta la pagina.
 * @param {int} page # pagina dei prodotti.
 * @param {int} dataLength # di prodotti nella lista.
 */
function setPages(page, dataLength) {
  $(".page-item").remove();

  $("#productPages").append(
    "<li class='page-item' id='prevPage'><button class='page-link'><i class='bi bi-chevron-double-left'></i></button></li>" +
    "<li class='page-item active'><button class='page-link'>" + page + "</button></li>" +
    "<li class='page-item' id='nextPage'><button class='page-link'><i class='bi bi-chevron-double-right'></i></button></li>"
  );
  
  if (page - 1 > 0) {
    $("#prevPage").after("<li class='page-item'><button class='page-link n-page'>" + (page - 1) + "</button></li>");
    $("#prevPage").click(prevPage);
  }

  if (page + 1 <= Math.ceil(dataLength / 9)) {
    $("#nextPage").before("<li class='page-item'><button class='page-link n-page'>" + (page + 1) + "</button></li>");
    $("#nextPage").click(nextPage);
  }

  $(".n-page").click(selectedPage);
}

/**
 * Crea una preview delle info del prodotto.
 * @param {int} id id prodotto.
 * @param {string} brand brand del prodotto.
 * @param {string} name nome del prodotto.
 * @param {string} model modello del prodotto.
 * @param {string} yearOfProduction anno di produzione del prodotto.
 * @param {string} img URL dell'immagine del prodotto.
 * @param {string} size RAM e memoria del prodotto.
 * @param {int} seller id del venditore.
 * @param {string} condition condizione del prodotto.
 * @param {number} price prezzo di vendita del prodotto.
 * @returns preview delle info del prodotto.
 */
function productCard(id, brand, name, model, yearOfProduction, img, size, seller, condition, price) {
  return "<div class='col-3 card ms-4 mb-4 products " + id + "'>"
    + "<img src='" + img + "' class='card-img-top home-item' alt='product img'>"
    + "<div class='card-body'>"
    + "<h5 class='card-title'>" + brand + " " + name + "</h5>"
    + "<div class='card-body'>"
    + "<ul class='list-group list-group-flush'>"
    + "<li class='list-group-item'><span class='fw-bolder'>model:</span> " + model + "</li>"
    + "<li class='list-group-item'><span class='fw-bolder'>Year of production:</span> " + yearOfProduction + "</li>"
    + "<li class='list-group-item'><span class='fw-bolder'>size:</span> " + size + " GB</li>"
    + "<li class='list-group-item'><span class='fw-bolder'>seller:</span> " + seller + "</li>"
    + "<li class='list-group-item'><span class='fw-bolder'>condition:</span> " + condition + "</li>"
    + "</ul></div>"
    + "<p class='card-text text-center fw-bold fs-2'>" + price + "€</p>"
    + "<div class='row'>"
    + "<button class='col btn btn-secondary addCart' id='" + id + "'><i class='bi bi-cart-plus-fill'></i> Add to cart</button>"
    + "</div></div></div>";
}

/**
 * Query Ajax pe raggiungere il prodotto al carello
 */
function addCart() {
  $("." + $(this).attr('id')).animate({opacity: '0.5'}, 
    "fast",   
    () => {
      $("#" + $(this).attr('id')).html("<i class='bi bi-cart-check-fill'></i> Added to cart");
      $("#" + $(this).attr('id')).removeClass('btn-secondary');
      $("#" + $(this).attr('id')).addClass('btn-success');
      $("." + $(this).attr('id')).animate({opacity: '1'}, "fast");
    }
  );

  $.post(
    "http://localhost/TWeb/GitLab2/tweb/project/controllers/HomePageController.php",
    {
      comand: 'add cart',
      id: $(this).attr('id')
    }
  ).fail((jqXHR, textStatus, errorThrown) => {
    $(".cleanable").remove();
    $("#productContainer").append("<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>");
  });
}

function nextPage() {
  changePage(parseInt($(".active").children().html()) + 1);
}

function prevPage() {
  changePage(parseInt($(".active").children().html()) - 1);
}

function selectedPage() {
  changePage(parseInt($(this).html()));
}

/**
 * Cambia pagina della lista dei prodotti.
 * @param {int} page # della pagina.
 */
function changePage(page) {
  $(".page-item").remove();

  $("#productPages").append(
    "<li class='page-item' id='prevPage'><button class='page-link'><i class='bi bi-chevron-double-left'></i></button></li>" +
    "<li class='page-item active'><button class='page-link'>" + page + "</button></li>" +
    "<li class='page-item' id='nextPage'><button class='page-link'><i class='bi bi-chevron-double-right'></i></button></li>"
  );
  
  $('html, body').animate({ scrollTop: 0 }, 'fast');
  getProducts();
}

/**
 * Query Ajax per la lista di prodotti filtrata.
 * @param {any} form dati del form per la ricerca dei prodotti tramite filtri
 */
function filter(form) {
  if ($('#priceMin').val() != "" 
    && $('#priceMax').val() != "" 
    && Number($('#priceMin').val()) > Number($('#priceMax').val())
  ) { // in caso di input non valido stampa l'errore
    $(".removable").remove();
    $("#priceMin").addClass("text-danger");
    $("#priceMax").addClass("text-danger");
    $("div.alert").append("<span class='cleanable'> Min cannot be greater than Max</span>");
    $("div.alert").show();
  } else {
    $("div.alert").hide();
    $(".active").children().html(1);

    $.post(
      "http://localhost/TWeb/GitLab2/tweb/project/controllers/HomePageController.php",
      {
        comand: 'filter',
        brand: $('#brand').val(),
        condition: $('#condition').val(),
        name: $('#name').val(),
        priceMin: $('#priceMin').val(),
        priceMax: $('#priceMax').val()
      },
      printProductsList,
      "json"
    ).fail((jqXHR, textStatus, errorThrown) => {
      $(".cleanable").remove();
      $("div.alert").append("<span class='cleanable'> Fatal error: " + errorThrown + ": " + textStatus + "</span>");
      $("div.alert").show();
    });
  }
}