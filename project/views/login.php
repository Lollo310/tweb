<!--
  Codice HTML per la pagina di login.
  author: Michele Lorenzo
-->

<?php
require("html\header.html");
?>

<script src="http://localhost/TWeb/GitLab2/tweb/project/js/Login.js"></script>
</head>

<body class="vh-100 bg-dark">
  <div class="container">
    <div class="row justify-content-center py-5">
      <div class="col-xl-5">
        <div class="card rounded-container">
          <div class="card-title text-center mt-5 mb-0">
            <h2>Login</h2>
          </div>

          <div class="card-body p-5">
            <div class="alert alert-danger py-2">
              <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <form name="login">
              <div class="form-outline mb-4">
                <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email">
              </div>

              <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password">
              </div>

              <select class="form-select form-select-lg mb-4" id="userType">
                <option value="notAChoice" disabled>Choose user type</option>
                <option value="0">Buyer</option>
                <option value="1">Seller</option>
              </select>

              <div class="form-check d-flex mb-4">
                <input class="form-check-input me-2" type="checkbox" id="rememberMe">
                <label class="form-check-label" for="rememberMe"> Remember me </label>
              </div>

              <div class="d-grid  text-center">
                <button class="btn btn-warning btn-lg" type="submit" id="submit">Login</button>
                <hr>
                <p class="fs-5">or</p>
                <a class="btn btn-secondary btn-lg" id="signUp">Sign up</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>