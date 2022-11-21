/**
 * Codice JavaScript per confirmed-order.php.
 * @author Michele Lorenzo 
 */

$(function () {
    let date = new Date(new Date().getTime() + 3*24*60*60*1000);

    $('#shippingDate').html(date.toDateString());
    $('#ordersBtn').click(() => bRedirect('views/orders.php'))
})