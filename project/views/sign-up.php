<!--
    Codice HTML per la pagina di registrazione.
    author: Michele Lorenzo.
-->

<?php
require ("html\header.html");
?>
<script src="http://localhost/TWeb/GitLab2/tweb/project/js/SignUp.js"></script>
</head>

<body class="vh-100 bg-dark">
  <div class="container">
    <div class="row justify-content-center py-5 ">
      <div class="col-xl-7">
        <div class="card rounded-container">
          <div class="card-title mt-5 mb-0 text-center">
            <h2>Sign Up</h2>
          </div>
          <div class="card-body p-md-5">
            <div class="alert alert-danger py-2">
              <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <form name="signUp">
              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <label class="form-label" for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" class="form-control form-control-lg">
                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <label class="form-label" for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" class="form-control form-control-lg">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline" id="birthdayDiv">
                    <label for="birthdayDate" class="form-label">Birthday</label>
                    <input type="date" class="form-control form-control-lg" id="birthdayDate" name="birthdayDate">
                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <h6 class="mb-2 pb-1">Gender: </h6>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radioOptions" id="femaleGender" value="F">
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radioOptions" id="maleGender" value="M">
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radioOptions" id="otherGender" value="O" checked>
                    <label class="form-check-label" for="otherGender">Other</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg">
                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <label class="form-label" for="phoneNumber">Phone Number</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control form-control-lg">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6 mb-4">
                  <label class="form-label">User type</label>
                  <select class="form-select form-select-lg" id="userType" name="userType">
                    <option value="notAChoice" disabled>Choose user type</option>
                    <option value="0">Buyer</option>
                    <option value="1">Seller</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-6 mb-4">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control form-control-lg" id="password" name="password">
                </div>

                <div class="col-6 mb-4">
                  <label for="passwordCheck" class="form-label">Confirm password</label>
                  <input type="password" class="form-control form-control-lg" id="passwordCheck" name="passwordCheck">
                </div>
              </div>

              <div class="row">
                <div class="col-10 my-4 ms-3 form-check" id="termsDiv">
                  <input type="checkbox" class="form-check-input" id="termsOfUse" name="termsOfUse">
                  <label class="form-check-label" for="termsOfUse">I've read and accept the <a href="#">Terms & Condition</a>.</label>
                </div>
              </div>

              <div class="d-grid mt-2">
                <button class="btn btn-warning btn-lg" type="submit" id="signUpSubmit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>