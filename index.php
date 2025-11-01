<?php
if(isset($_GET['sw'])){
$sw=$_GET['sw'];
}else{
    $sw=0;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Sign In | PlainAdmin Demo</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="vendor/fontawesome-free-5.15.4-web/css/all.css">
  </head>
  <body>

    <div id="preloader">
      <div class="spinner"></div>
    </div>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
      
      <!-- ========== signin-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title">
                  <h2>Login</h2>
                </div>
              </div>
              <!-- end col -->
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row g-0 auth-row">
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    <h1 class="text-primary mb-10">Bienvenido de nuevo</h1>
                    <p class="text-medium">
                      ingresa a tu cuenta para poder continuar
                    </p>
                  </div>
                  <div class="cover-image">
                    <img src="assets/images/auth/signin-image.svg" alt="" />
                  </div>
                  <div class="shape-image">
                    <img src="assets/images/auth/shape.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signin-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Ingresa llenando el formulario</h6>
                  <?php
                                if($sw==1){
                            ?>
                            <div class="alert alert-danger">
                                error en credenciales, vuelva a intentar!
                            </div>
                            <?php
                                }
                            ?>
                            <?php
                                        if($sw==2){
                                    ?>
                                        <div class="alert alert-warning">
                                            Usuario o passeword incorrecto
                                        </div>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if($sw==3){
                                    ?>
                                        <div class="alert alert-success">
                                            Sessión cerrada con exito!
                                        </div>
                                    <?php
                                        }
                                    ?>
                                    
                                    <?php
                                        if($sw==4){
                                    ?>
                                        <div class="alert alert-success">
                                          Debe ingresar un usuario o password valido
                                        </div>
                                    <?php
                                        }
                                    ?>
                  <form action="componentes/login.php" method="post">
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Usuario</label>
                          <input type="text" name="user" placeholder="Usuario" />
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Password</label>
                          <input type="password" name="pasw"  id="password" placeholder="Password"/>
                        </div>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye" id="icono"></i></button>
                      </div>
                      <!-- end col -->
                      <!-- <div class="col-xxl-6 col-lg-12 col-md-6">
                        <div class="form-check checkbox-style mb-30">
                          <input class="form-check-input" type="checkbox" value="" id="checkbox-remember" />
                          <label class="form-check-label" for="checkbox-remember">
                            Recordar</label>
                        </div>
                      </div>
                      end col -->
                      <!-- <div class="col-xxl-6 col-lg-12 col-md-6">
                        <div class="text-start text-md-end text-lg-start text-xxl-end mb-30">
                          <a href="reset-password.html" class="hover-underline">
                            Olvidaste tu Password?
                          </a>
                        </div>
                      </div> -->
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                          <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                            Ingresar
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                  <!-- <div class="singin-option pt-40">
                    <div class="button-group pt-40 pb-40 d-flex justify-content-center flex-wrap">
                      <button class="main-btn primary-btn-outline m-2">
                        <i class="lni lni-facebook-fill mr-10"></i>
                        Facebook
                      </button>
                      <button class="main-btn danger-btn-outline m-2">
                        <i class="lni lni-google mr-10"></i>
                        Google
                      </button>
                    </div>
                    <p class="text-sm text-medium text-dark text-center">
                      No tienes cuenta
                      <a href="signup.html">Crear cuenta</a>
                    </p>
                  </div>
                </div> -->
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signin-section end ========== -->

      <!-- ========== footer start =========== -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">
                  Designed and Developed by
                  <a href="https://plainadmin.com" rel="nofollow" target="_blank">
                    PlainAdmin
                  </a>
                </p>
              </div>
            </div>
            <!-- end col-->
            <div class="col-md-6">
              <div class="terms d-flex justify-content-center justify-content-md-end">
                <a href="#0" class="text-sm">Term & Conditions</a>
                <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </footer>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const icon = document.getElementById('icono');
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>
    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/dynamic-pie-chart.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/fullcalendar.js"></script>
    <script src="assets/js/jvectormap.min.js"></script>
    <script src="assets/js/world-merc.js"></script>
    <script src="assets/js/polyfill.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
