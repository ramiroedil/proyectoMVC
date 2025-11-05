<?php
if (isset($_GET['sw'])) {
  $sw = $_GET['sw'];
} else {
  $sw = 0;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login JUGUETERIA CRONCHK</title>

  <!-- ========== All CSS files linkup ========= -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/lineicons.css" />
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
  <link rel="stylesheet" href="assets/css/fullcalendar.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="vendor/fontawesome-free-5.15.4-web/css/all.css">
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      background: url('assets/imagenes/fondoIndex.jpg') no-repeat center center fixed;
      background-size: cover;
      color: var(--color-text, #374151);
      font-size: 18px;
      line-height: 1.6;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    .decor-ball {
      position: absolute;
      z-index: 0;
      border-radius: 50%;
      opacity: .17;
      pointer-events: none;
      background: radial-gradient(circle, #fcb900 60%, #fffbe6 100%);
    }

    .ball1 {
      width: 90px;
      height: 90px;
      left: -45px;
      top: 18vh;
    }

    .ball2 {
      width: 60px;
      height: 60px;
      right: -30px;
      bottom: 12vh;
    }

    .ball3 {
      width: 36px;
      height: 36px;
      left: 12vw;
      bottom: 7vh;
    }

    .ball4 {
      width: 44px;
      height: 44px;
      right: 9vw;
      top: 8vh;
    }

    .login-logo {
      width: 70px;
      height: 70px;
      object-fit: cover;
      margin: 0 auto 0.8rem auto;
      border-radius: 16px;
      border: 2px solid #ffc107;
      background: #fff6e8;
      box-shadow: 0 2px 12px rgba(255, 193, 7, 0.12);
      display: block;
    }

    .login-container {
      position: relative;
      z-index: 2;
      background: #f9fafbda;
      padding: 3rem 2rem 2rem;
      border-radius: 1.2rem;
      box-shadow: 0 6px 32px 0 rgba(0, 0, 0, 0.10);
      width: 100%;
      max-width: 400px;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
      user-select: none;
      align-items: center;
    }

    h1 {
      font-size: 2.1rem;
      font-weight: 800;
      color: #e85d04;
      margin-bottom: 0.5rem;
      text-align: center;
      user-select: text;
      text-shadow: 0 2px 8px rgba(252, 185, 0, .13);
    }

    label {
      font-weight: 600;
      color: #f48c06;
      margin-bottom: 0.25rem;
      user-select: text;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      padding: 0.75rem 1rem;
      font-size: 1rem;
      border: 1.5px solid #d1d5db;
      border-radius: 0.75rem;
      transition: border-color 0.3s, box-shadow 0.3s;
      outline-offset: 2px;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #e85d04;
      box-shadow: 0 0 8px rgba(252, 185, 0, 0.14);
      outline: none;
    }

    .login-btn-center {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      margin-top: 1rem;
    }

    .login-btn-center button {
      min-width: 140px;
      max-width: 180px;
      width: 100%;
      background: linear-gradient(90deg, #e85d04, #f48c06 85%);
      color: #ffffff;
      font-weight: 700;
      font-size: 1rem;
      border: none;
      border-radius: 0.8rem;
      cursor: pointer;
      transition: background 0.18s, transform 0.15s;
      user-select: none;
      box-shadow: 0 2px 14px rgba(252, 185, 0, .10);
      padding: 0.7rem 0;
      text-align: center;
      display: block;
    }

    .login-btn-center button:hover,
    .login-btn-center button:focus {
      background: linear-gradient(90deg, #f48c06, #e85d04 85%);
      transform: scale(1.04);
      outline: none;
    }

    .form-footer {
      text-align: center;
      font-size: 0.9rem;
      color: #6b7280;
      user-select: text;
    }

    .form-footer a {
      color: #e85d04;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
      transition: color 0.21s;
      user-select: text;
    }

    .form-footer a:hover,
    .form-footer a:focus {
      color: #ce3a00;
      outline: none;
    }

    .error-message {
      color: #d90429;
      text-align: center;
      font-weight: 600;
    }

    @media (max-width: 480px) {
      body {
        padding: 1rem;
      }

      .login-container {
        padding: 2.3rem 0.6rem 1rem;
      }

      .decor-ball {
        display: none;
      }

      .login-logo {
        width: 48px;
        height: 48px;
      }

      h1 {
        font-size: 1.3rem;
      }

      .login-btn-center button {
        min-width: 100px;
        font-size: 0.98rem;
      }
    }
  </style>
</head>

<body>
  <span class="decor-ball ball1"></span>
  <span class="decor-ball ball2"></span>
  <span class="decor-ball ball3"></span>
  <span class="decor-ball ball4"></span>
  <div class="login-container" role="main" aria-label="Formulario de inicio de sesión">
    <img src="assets/imagenes/toyStory1.jpg" alt="Logo Juguetería" class="login-logo">
    <h1>Iniciar Sesión</h1>
    <?php
    if ($sw == 1) {
    ?>
      <div class="alert alert-danger">
        error en credenciales, vuelva a intentar!
      </div>
    <?php
    }
    ?>
    <?php
    if ($sw == 2) {
    ?>
      <div class="alert alert-warning">
        Usuario o passeword incorrecto
      </div>
    <?php
    }
    ?>
    <?php
    if ($sw == 3) {
    ?>
      <div class="alert alert-success">
        Sessión cerrada con exito!
      </div>
    <?php
    }
    ?>

    <?php
    if ($sw == 4) {
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
            <input type="password" name="pasw" id="password" placeholder="Password" />
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

    <div class="form-footer">
      ¿No tienes cuenta? <a href="#">Regístrate aquí</a>
    </div>
  </div>
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