<!-- 
  Codice HTML per la pagina principale.
  author: Michele Lorenzo
 -->

<?php

require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/header.html");

?>

<script src="http://localhost/TWeb/GitLab2/tweb/project/js/HomePage.js"></script>

<?php

require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/banner.html");

?>

<div class="position-relative overflow-hidden p-3 my-3 mx-auto w-75 bg-light">
  <img src="http://localhost/TWeb/GitLab2/tweb/project/images/black_logo_strach.png" class="img-fluid" alt="logo">
</div>
<div class="text-center col-md-5 p-3 mx-auto my-0">
  <h1 class="display-4 fw-normal">Welcome to Rebuy store</h1>
  <p class="lead fw-normal">On our site you can sell and buy used phones.</p>
</div>

<div class="row container-min-45">
  <div class="col-3 ms-4 container-min-20">
    <div class="bg-custom-1 rounded-container p-3">
      <form name="filters">
        <h5 class="mt-4 fw-bolder"><i class="bi bi-search me-2"></i> PRODUCT SEARCH</h5>
  
        <hr>
  
        <div class="form-outline form-white my-4">
          <label class="form-label" for="brand">Brand</label>
          <select class="form-select form-select-lg" id="brand" name="brand">
            <option value="notAChoice" disabled>Choose brand</option>
            <option value="" label=" "></option>
            <option value="Apple">Apple</option>
            <option value="Huawei">Huawei</option>
            <option value="Huawei">Honor</option>
            <option value="OnePlus">OnePlus</option>
            <option value="Oppo">Oppo</option>
            <option value="Realme">Realme</option>
            <option value="Samsung">Samsung</option>
            <option value="Xiaomi">Xiaomi</option>
          </select>
        </div>
  
        <div class="form-outline form-white mb-4">
          <label class="form-label" for="condition">Condition</label>
          <select class="form-select form-select-lg" id="condition" name="condition">
            <option value="notAChoice" disabled>Set phone condition</option>
            <option value="" label=" "></option>
            <option value="Like New">Like New</option>
            <option value="Very Good">Very Good</option>
            <option value="Good">Good</option>
            <option value="Acceptable">Acceptable</option>
          </select>
        </div>
  
        <div class="form-outline form-white mb-4">
          <label class="form-label" for="name">Model Name</label>
          <input type="text" id="name" name="name" class="form-control form-control-lg">
        </div>
  
        <div class="row mb-4">
          <div class="col form-outline form-white">
            <label class="form-label" for="priceMin">Min</label>
            <input type="text" id="priceMin" name="priceMin" placeholder="€" class="form-control form-control-lg">
          </div>
  
          <div class="col form-outline form-white">
            <label class="form-label" for="priceMax">Max</label>
            <input type="text" id="priceMax" name="priceMax" placeholder="€" class="form-control form-control-lg">
          </div>
        </div>

        <div class="alert alert-danger py-2" id="alertErr">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <div class="d-grid  text-center">
          <button class="btn btn-warning mb-4" type="submit" id="submit"><i class="bi bi-funnel-fill"></i> Apply Filters</button>
          <button class="btn btn-secondary mb-4" type="reset" id="reset"><i class="bi bi-eraser-fill"></i> Clear all</button>
        </div>
      </form>
    </div>
  </div>

  <div class=" col" id="productContainer">
    <nav aria-label="Page navigation">
      <ul class="pagination" id="productPages">
      </ul>
    </nav>
  </div>
</div>

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/footer.html");
?>