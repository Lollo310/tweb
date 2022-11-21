<!--
  Codice HTML per il carello della spesa.
  author: Michele Lorenzo
-->

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/header.html");
?>

<script src="http://localhost/TWeb/GitLab2/tweb/project/js/ShoppingCart.js"></script>

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/banner.html");
?>

<div class="h-100 h-custom bg-custom-1">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="rounded-container card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-lg-7" id="productList">
                <h5 class="mb-3">
                  <a href="#" class="text-body" id="back">
                    <i class="bi bi-arrow-left-circle"></i> Continue shopping
                  </a>
                </h5>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <p class="mb-1">Shopping cart</p>
                    <p class="mb-0">You have <span id="nItems"></span> items in your cart</p>
                  </div>
                </div>
              </div>

              <div class="col-lg-5">
                <div class="card bg-custom-2 rounded-container">
                  <div class="card-body">
                    <h4 class="mb-4">Card details</h4>
                    <p class="small mb-2">Card type</p>
                    <img src="http://localhost/TWeb/GitLab2/tweb/project/images/mastercard_icon.png" 
                      class="img-fluid shopping-item"
                      alt="mastercard logo"
                    >
                    <img src="http://localhost/TWeb/GitLab2/tweb/project/images/visa_icon.png" 
                      class="img-fluid shopping-item"
                      alt="visa logo"
                    >
                    <img src="http://localhost/TWeb/GitLab2/tweb/project/images/amex_icon.png"  
                      class="img-fluid shopping-item"
                      alt="amex logo"
                    >
                    <form class="mt-4" name="checkout">
                      <div class="form-outline form-white mb-4">
                        <label class="form-label" for="cardholderName">Cardholder's Name</label>
                        <input type="text" 
                          id="cardholderName" 
                          name="cardholderName"
                          class="form-control form-control-lg" 
                          size="20" 
                        />
                      </div>

                      <div class="form-outline form-white mb-4">
                        <label class="form-label" for="cardNumber">Card Number</label>
                        <input type="text" 
                          id="cardNumber" 
                          name="cardNumber"
                          class="form-control form-control-lg" 
                          size="16" 
                          minlength="16" 
                          maxlength="16" 
                        />
                      </div>

                      <div class="row mb-4">
                        <div class="col-md-3">
                          <div class="form-outline form-white" id="expDiv">
                            <label class="form-label" for="expMonth">Expiration</label>
                            <input type="text" 
                              id="expMonth" 
                              name="expMonth"
                              class="form-control form-control-lg" 
                              placeholder="MM" 
                              size="2"  
                              minlength="2" 
                              maxlength="2" 
                            />
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-outline form-white">
                            <label class="form-label" for="expYear">&nbsp;</label>
                            <input type="text" 
                              id="expYear" 
                              name="expYear"
                              class="form-control form-control-lg" 
                              placeholder="YYYY" 
                              size="4"  
                              minlength="4" 
                              maxlength="4" 
                            />
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-outline form-white">
                            <label class="form-label" for="cvv">Cvv</label>
                            <input type="text" 
                              id="cvv" 
                              name="cvv"
                              class="form-control form-control-lg" 
                              size="3" 
                              minlength="3" 
                              maxlength="3" 
                            />
                          </div>
                        </div>
                      </div>

                      <hr class="my-4">
                      
                      <h4 class="mb-4">Address details</h4>

                      <div class="form-outline form-white mb-4">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" 
                          id="address" 
                          name="address"
                          class="form-control form-control-lg" 
                          size="64" 
                        />
                      </div>

                      <div class="row mb-4">
                        <div class="col-md-6">
                          <div class="form-outline form-white">
                            <label class="form-label" for="cap">CAP</label>
                            <input type="text" 
                              id="cap" 
                              name="cap"
                              class="form-control form-control-lg" 
                              size="5"  
                              minlength="5" 
                              maxlength="5" 
                            />
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-outline form-white">
                            <label class="form-label" for="city">City</label>
                            <input type="text" 
                              id="city" 
                              name="city"
                              class="form-control form-control-lg" 
                              size="16" 
                            />
                          </div>
                        </div>
                      </div>

                      <hr class="my-4">
                      
                      <div class="alert alert-danger py-2" id="alertErr">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                      </div>

                      <div class="d-flex justify-content-between">
                        <p class="mb-2">Subtotal</p>
                        <p class="mb-2">€<span id="subtotal"></span></p>
                      </div>

                      <div class="d-flex justify-content-between">
                        <p class="mb-2">Shipping</p>
                        <p class="mb-2">€5.00</p>
                      </div>

                      <div class="d-flex justify-content-between mb-4">
                        <p class="mb-2 fs-4">Total(Incl. taxes)</p>
                        <p class="mb-2 fs-4" id="total"></p>
                      </div>

                      <div class="d-grid">
                        <button type="submit" class="btn btn-warning btn-block btn-lg">
                          Checkout<i class="bi bi-arrow-right-circle ms-2"></i>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
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