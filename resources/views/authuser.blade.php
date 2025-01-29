@extends('clientlayout.base')
@section('content')



<section class="pb-4">
    <div class="border rounded-5">
      
      <section class="w-100 p-4 d-flex justify-content-center pb-4">
        <div style="width: 26rem;">
            <h2 class="fw-bold mb-2 text-uppercase text-center">Login/ Register</h2>
            <p class="text-black-50 mb-5 text-center">Please enter your Mobile No. and Password!</p>
            <form>
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="mobilenumber" class="form-control" />
                  <label class="form-label" for="mobilenumber">Mobile Number</label>
                </div>
              
                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" id="password" class="form-control" />
                  <label class="form-label" for="password">Password</label>
                </div>
              
                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                  <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                      <label class="form-check-label" for="form2Example31"> Remember me </label>
                    </div>
                  </div>
              
                  <div class="col">
                    <!-- Simple link -->
                    <a href="#!">Forgot password?</a>
                  </div>
                </div>
              
                <!-- Submit button -->
                <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign in</button>
              
                <!-- Register buttons -->
                <div class="text-center">
                  <p>Login/ Register in one place.</a></p>
                </div>
              </form>

        </div>
      </section>
    </div>
</section>
  @endsection