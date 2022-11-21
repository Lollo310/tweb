/**
 * Codice JavaScript per banner.html.
 * @author Michele Lorenzo
 */

const ROOT = "http://localhost/TWeb/GitLab2/tweb/project/";

$(function () {
  $("#addNewProduct").click(() => bRedirect("views/new-product.php"));
  $("#listProducts").click(() => bRedirect("views/added-products-list.php"));
  $("#shoppingCart").click(() => bRedirect("views/shopping-cart.php"));
  $("#orders").click(() => bRedirect('views/orders.php'));
  $("#logout").click(logout);

  // Query Ajax per controllare il login 
  $.post(
    ROOT + "controllers/BannerController.php",
    { comand: "check login" },
    checkLogin,
    "json"
  ).fail(() => bRedirect("views/login.php"));
})

/**
 * Logout.
 */
function logout() {
  $.post(
    ROOT + "controllers/BannerController.php",
    { comand: "logout" },
    () => bRedirect("views/home-page.php"),
    "json"
  );
}

/**
 * Carica una nuova pagina.
 * @param {string} location percorso della pagina da caricare
 */
function bRedirect(location) {
  $(window.location).attr("href", ROOT + location);
}

/**
 * Controlla il login dopo la Query Ajax.
 * @param {any} data risposta Ajax.
 */
function checkLogin(data) {
  if (!(data.firstName))
    bRedirect("views/login.php");
  else { 
    $("#userName").html(data.firstName);

    if (data.isSeller == "0") {
      $("#addNewProduct").hide();
      $("#listProducts").hide();
    }
  }
}

