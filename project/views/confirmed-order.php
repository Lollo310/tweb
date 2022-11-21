<!--
  Codice HTML per la pagina dell'avvenuta conferma dell'ordine.
  author: Michele Lorenzo
-->

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/header.html");
?>

<script src="http://localhost/TWeb/GitLab2/tweb/project/js/ConfirmedOrder.js"></script>

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/banner.html");
?>

<div class="h-100 h-custom bg-custom-1">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="rounded-container card">
          <div class="card-body p-4 text-center">
            <div class="text-success font-size-custom-1">
              <i class="bi bi-check-circle"></i>
            </div>
            
            <div>
              <p class="fs-1 fw-bolder">
                Thank You!
              </p>

              <p class="fs-5">
                Your payment was successful and your order was completed. <br>
                Expect it: <span class="fw-bolder" id="shippingDate"></span>
              </p>
              <button class="btn btn-secondary btn-lg" id="ordersBtn"> Go to orders <i class="bi bi-arrow-right-circle"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/footer.html");
?>