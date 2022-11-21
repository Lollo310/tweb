<!--
  Codice HTML per la pagina della lista dei prodotti aggiunti.
  author: Michele Lorenzo
-->

<?php
require_once ("http://localhost/TWeb/GitLab2/tweb/project/views/html/header.html");
?>
 
<script src="http://localhost/TWeb/GitLab2/tweb/project/js/AddedProductsList.js"></script>
 
<?php
require_once ("http://localhost/TWeb/GitLab2/tweb/project/views/html/banner.html");
?>

<div class="h-100 h-custom bg-custom-1">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="rounded-container card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col" id="addedProductsList">
                <h5 class="mb-3">Added products</h5>

                <hr>

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