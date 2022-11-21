<!--
  Codice HTML per la pagina per l'aggiunta di nuovi prodotti.
  author: Michele Lorenzo
-->

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/header.html");
?>

<script src="http://localhost/TWeb/GitLab2/tweb/project/js/NewProduct.js"></script>

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/banner.html");
?>

<div class="row justify-content-center py-5 bg-custom-1">
  <div class="col-xl-7">
    <div class="card" id="signUpContainer">
      <div class="card-title mt-5 mb-0 text-center">
        <h2>New product</h2>
      </div>
      <div class="card-body p-5">
        <div class="row mb-4" id="imgDiv">
          <div class="col">
            <label class="form-label" for="img">Phone image</label>
            <input type="file" id="img" name="img" class="form-control form-control-lg" accept=".png, .jpg">
          </div>
          <button class="btn btn-warning col-2" id="upload"><i class="bi bi-upload"></i> Upload</button>
        </div>

        <form name="newProduct">
          <div class="row">
            <div class="col-6 mb-4">
              <label class="form-label">Brand</label>
              <select class="form-select form-select-lg" id="brand" name="brand">
                <option value="notAChoice" disabled>Choose brand</option>
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

            <div class="col-6 mb-4">
              <div class="form-outline">
                <label class="form-label" for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control form-control-lg">
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-6 mb-4">
              <div class="form-outline">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control form-control-lg" id="model" name="model">
              </div>
            </div>

            <div class="col-6 mb-4">
              <div class="form-outline">
                <label for="yearOfProduction" class="form-label">Year of production</label>
                <input type="text" class="form-control form-control-lg" id="yearOfProduction" name="yearOfProduction">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6 mb-4">
              <label class="form-label">Size</label>
              <div class="row">
                <div class="form-outline col">
                  <input type="text" id="ram" name="ram" class="form-control form-control-lg" placeholder="RAM">
                </div>

                <div class="form-outline col">
                  <input type="text" id="memory" name="memory" class="form-control form-control-lg" placeholder="Memory">
                </div>

                <div class="col-2 fs-4">
                  GB
                </div>
              </div>
            </div>

            <div class="col-6 mb-4">
              <label class="form-label">Condition</label>
              <select class="form-select form-select-lg" id="condition" name="condition">
                <option value="notAChoice" disabled>Set phone condition</option>
                <option value="Like New">Like New</option>
                <option value="Very Good">Very Good</option>
                <option value="Good">Good</option>
                <option value="Acceptable">Acceptable</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-6 mb-4">
              <label class="form-label">Price</label>
              <div class="row">
                <div class="form-outline col">
                  <input type="text" id="euro" name="euro" class="form-control form-control-lg">
                </div>

                <div class="col-1 fs-1">
                  ,
                </div>

                <div class="form-outline col-3">
                  <input type="text" id="cent" name="cent" class="form-control form-control-lg">
                </div>

                <div class="col-2 fs-3">
                  €
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-10 my-4 ms-3 form-check" id="termsDiv">
              <input type="checkbox" class="form-check-input" id="termsOfUse" name="termsOfUse">
              <label class="form-check-label" for="termsOfUse">I've read and accept the <a href="#">Terms & Condition</a>.</label>
            </div>
          </div>

          <div class="alert alert-danger py-2">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <div class="alert alert-success py-2">
          <i class="bi bi-check-circle-fill"></i>
        </div>

        <div class="d-grid mt-2">
          <button class="btn btn-warning btn-lg" type="submit" id="addProduct">Add product</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<?php
require_once("http://localhost/TWeb/GitLab2/tweb/project/views/html/footer.html");
?>