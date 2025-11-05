<?php
include("assets/componentes/verify.php");
include("assets/componentes/header.php");
?>
<?php if (isset($_SESSION['usuario'])): ?>
  <div class="container mt-4">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>¡Bienvenid@!</strong> 
      Usuario: <b><?php echo htmlspecialchars($_SESSION['usuario']); ?></b>
      <?php if (isset($_SESSION['tipo'])): ?>
        | Rol: <b><?php echo htmlspecialchars($_SESSION['tipo']); ?></b>
      <?php endif; ?>
      <?php if (isset($_SESSION['email'])): ?>
        | Email: <b><?php echo htmlspecialchars($_SESSION['email']); ?></b>
      <?php endif; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  </div>
<?php endif; ?>
<main>
  
  <!-- Carrusel de imágenes principal -->
  <div id="heroCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/imagenes/toyStory1.jpg" class="d-block w-100" alt="Juguetes Toy Story" style="max-height:430px; object-fit:cover;">
        <div class="carousel-caption d-flex flex-column justify-content-center align-items-center" style="bottom: 20%;">
          <h1 class="display-5 fw-bold text-shadow">Juguetería en línea con los mejores juguetes</h1>
          <p class="lead text-shadow">Descubre nuestro catálogo con miles de juguetes y disfraces de las mejores marcas para todas las edades.</p>
          <a class="btn btn-lg btn-primary mt-2" href="#" aria-label="Descubre nuestros juguetes">Explorar productos</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/imagenes/marioFondo.jpg" class="d-block w-100" alt="Muñecos y juegos" style="max-height:430px; object-fit:cover;">
        <div class="carousel-caption d-flex flex-column justify-content-center align-items-center" style="bottom: 20%;">
          <h1 class="display-5 fw-bold text-shadow">¡Nuevos ingresos!</h1>
          <p class="lead text-shadow">Muñecos, peluches y sets de construcción para todas las edades.</p>
          <a class="btn btn-lg btn-success mt-2" href="#" aria-label="Ver novedades">Ver novedades</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/imagenes/Jurasic10.jpg" class="d-block w-100" alt="Juegos didácticos" style="max-height:430px; object-fit:cover;">
        <div class="carousel-caption d-flex flex-column justify-content-center align-items-center" style="bottom: 20%;">
          <h1 class="display-5 fw-bold text-shadow">Diversión y Aprendizaje</h1>
          <p class="lead text-shadow">Encuentra juguetes didácticos y educativos para estimular su creatividad.</p>
          <a class="btn btn-lg btn-warning mt-2" href="#" aria-label="Ver juguetes educativos">Ver juguetes educativos</a>
        </div>
      </div>
    </div>
    <!-- Controles de navegación -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
    <!-- Indicadores -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
  </div>

  <!-- Carrusel horizontal tipo barra/fila, rotativo infinito -->
  <div class="container py-4">
    <h2 class="mb-4 text-center" style="color:#e85d04;">Nuestras Marcas</h2>
    <div class="d-flex justify-content-center align-items-center position-relative">
      <button id="btnMarcasPrev" class="btn btn-outline-warning me-2" type="button">
        <i class="fas fa-chevron-left"></i>
      </button>
      <div class="overflow-hidden w-100" style="max-width:1000px;">
        <div id="marcasSlider" class="d-flex flex-row align-items-center gap-3 slider-transition" style="transition: transform 0.5s;">
          <?php
            $marcas = [
              'assets/imagenes/logoCarro.jpg',
              'assets/imagenes/logoDisney.jpg',
              'assets/imagenes/logoFunko.jpg',
              'assets/imagenes/logoJurasic.jpg',
              'assets/imagenes/logoPrice.jpg',
              'assets/imagenes/logoNenuco.jpg',
              'assets/imagenes/logoLego.jpg',
              'assets/imagenes/logoPlay.jpg',
              'assets/imagenes/logoBarbie.jpg',
              'assets/imagenes/logoNancy.jpg'
            ];
            foreach ($marcas as $img) {
              echo "<div class='p-2 flex-shrink-0'><img src='$img' class='rounded-circle border border-warning' width='90' height='90' alt='Marca'></div>";
            }
          ?>
        </div>
      </div>
      <button id="btnMarcasNext" class="btn btn-outline-warning ms-2" type="button">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
  </div>

  <style>
    /* Suaviza la animación horizontal */
    .slider-transition {
      transition: transform 0.45s cubic-bezier(.4,1.2,.5,1);
      will-change: transform;
    }
  </style>
  <script>
    // --- CONFIGURACIÓN ---
    const VISIBLE = 9; // Cuántos logos se ven a la vez (ajusta si quieres)

    document.addEventListener("DOMContentLoaded", function () {
      const slider = document.getElementById('marcasSlider');
      let items = Array.from(slider.children);

      // Asegura que solo se vean VISIBLE logos
      function updateVisibility() {
        items.forEach((item, idx) => {
          if (idx < VISIBLE) item.style.display = '';
          else item.style.display = 'none';
        });
      }

      // Animar hacia la izquierda (botón derecha)
      function shiftLeft() {
        // Desplaza visualmente a la izquierda
        slider.style.transform = 'translateX(-100px)';
        setTimeout(() => {
          // Luego de la animación, mueve el primer logo al final y resetea
          slider.appendChild(items[0]);
          items.push(items.shift());
          slider.style.transition = 'none';
          slider.style.transform = 'none';
          setTimeout(() => {
            slider.style.transition = '';
          }, 20);
          updateVisibility();
        }, 450);
      }

      // Animar hacia la derecha (botón izquierda)
      function shiftRight() {
        // Mueve el último logo al principio, pero invisible
        slider.insertBefore(items[items.length - 1], items[0]);
        items.unshift(items.pop());
        slider.style.transition = 'none';
        slider.style.transform = 'translateX(-100px)';
        setTimeout(() => {
          slider.style.transition = '';
          slider.style.transform = 'none';
        }, 20);
        updateVisibility();
      }

      document.getElementById('btnMarcasNext').addEventListener('click', shiftLeft);
      document.getElementById('btnMarcasPrev').addEventListener('click', shiftRight);

      // Responsive: actualiza items si cambias el DOM
      window.addEventListener('resize', () => { items = Array.from(slider.children); });

      // Inicializa visibilidad
      updateVisibility();
    });
  </script>


<div class="container py-4">
  <h2 class="mb-4 text-center" style="color:#e85d04;">Productos Destacados</h2>
  <div class="d-flex justify-content-center align-items-center position-relative">
    <!-- Botón Izquierda -->
    <button id="btnPrev" class="btn btn-outline-warning me-2 shadow-sm" aria-label="Anterior">
      <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Carrusel de Cards -->
    <div class="overflow-hidden w-100" style="max-width: 1000px;">
      <div id="cardSlider" class="d-flex gap-4 slider-transition py-2">
        <!-- CARD 1 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/barbie2.jpg" class="card-img-top" alt="Producto 1">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Muñeca Barbie Fashion</h6>
            <p class="fw-bold text-success mb-0">29,99 Bs</p>
          </div>
        </div>
        <!-- CARD 2 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/lego1.jpg" class="card-img-top" alt="Producto 2">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Set Lego Classic 1000pzs</h6>
            <p class="fw-bold text-success mb-0">39,50 Bs</p>
          </div>
        </div>
        <!-- CARD 3 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/carro5.jpg" class="card-img-top" alt="Producto 3">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Hot Wheels Pack 5 Autos</h6>
            <p class="fw-bold text-success mb-0">15,00 Bs</p>
          </div>
        </div>
        <!-- CARD 4 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/pelota1.jpg" class="card-img-top" alt="Producto 4">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Pelota Didáctica Fisher</h6>
            <p class="fw-bold text-success mb-0">18,75 Bs</p>
          </div>
        </div>
        <!-- CARD 5 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/funko3.jpg" class="card-img-top" alt="Producto 5">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Funko Pop Mario Bros</h6>
            <p class="fw-bold text-success mb-0">22,00 Bs</p>
          </div>
        </div>
        <!-- CARD 6 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/play1.jpg" class="card-img-top" alt="Producto 6">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Playmobil Policía</h6>
            <p class="fw-bold text-success mb-0">27,80 Bs</p>
          </div>
        </div>
        <!-- CARD 7 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/nancy1.jpg" class="card-img-top" alt="Producto 7">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Nancy Vestidos Mágicos</h6>
            <p class="fw-bold text-success mb-0">33,99 Bs</p>
          </div>
        </div>
        <!-- CARD 8 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/dino1.jpg" class="card-img-top" alt="Producto 8">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Jurassic World Dino</h6>
            <p class="fw-bold text-success mb-0">45,00 Bs</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Botón Derecha -->
    <button id="btnNext" class="btn btn-outline-warning ms-2 shadow-sm" aria-label="Siguiente">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>
</div>

<style>
  .slider-transition {
    transition: transform 0.5s cubic-bezier(.4,1.1,.5,1);
    will-change: transform;
  }
  .card {
    border-width: 2px;
    border-style: solid;
    border-color: #ffe066;
    background: #fffbe6;
  }
  .card-img-top {
    object-fit: contain;
    height: 140px;
    background: #fff9e6;
    border-bottom: 1px solid #ffe066;
  }
</style>

<script>
  // Slider tipo fila para tarjetas de productos destacados, animado y rotativo infinito
  document.addEventListener("DOMContentLoaded", function () {
    const slider = document.getElementById('cardSlider');
    let items = Array.from(slider.children);

    function shiftLeft() {
      slider.style.transform = 'translateX(-230px)';
      setTimeout(() => {
        slider.appendChild(items[0]);
        items.push(items.shift());
        slider.style.transition = 'none';
        slider.style.transform = 'none';
        setTimeout(() => {
          slider.style.transition = 'transform 0.5s cubic-bezier(.4,1.1,.5,1)';
        }, 20);
      }, 500);
    }

    function shiftRight() {
      slider.insertBefore(items[items.length - 1], items[0]);
      items.unshift(items.pop());
      slider.style.transition = 'none';
      slider.style.transform = 'translateX(-230px)';
      setTimeout(() => {
        slider.style.transition = 'transform 0.5s cubic-bezier(.4,1.1,.5,1)';
        slider.style.transform = 'none';
      }, 20);
    }

    document.getElementById('btnNext').addEventListener('click', shiftLeft);
    document.getElementById('btnPrev').addEventListener('click', shiftRight);
  });
</script>

<div class="container py-4">
  <h2 class="mb-4 text-center" style="color:#e85d04;">¡Nuevos Productos!</h2>
  <div class="d-flex justify-content-center align-items-center position-relative">
    <!-- Botón Izquierda -->
    <button id="btnPrev2" class="btn btn-outline-warning me-2 shadow-sm" aria-label="Anterior">
      <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Carrusel de Cards 2-->
    <div class="overflow-hidden w-100" style="max-width: 1000px;">
      <div id="cardSlider2" class="d-flex gap-4 slider-transition py-2">
        <!-- CARD 1 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/jurasic1.jpg" class="card-img-top" alt="Producto 1">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Set de Jurasic Park</h6>
            <p class="fw-bold text-success mb-0">35,99 Bs</p>
          </div>
        </div>
        <!-- CARD 2 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/mario1.jpg" class="card-img-top" alt="Producto 2">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Set Mario Colleccionable</h6>
            <p class="fw-bold text-success mb-0">55,50 Bs</p>
          </div>
        </div>
        <!-- CARD 3 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/price1.jpg" class="card-img-top" alt="Producto 3">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Musica Little Peoply</h6>
            <p class="fw-bold text-success mb-0">10,00 Bs</p>
          </div>
        </div>
        <!-- CARD 4 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/price2.jpg" class="card-img-top" alt="Producto 4">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Laptop Infantil</h6>
            <p class="fw-bold text-success mb-0">18,85 Bs</p>
          </div>
        </div>
        <!-- CARD 5 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/puertaJurasic.jpg" class="card-img-top" alt="Producto 5">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Puerta Jurasica</h6>
            <p class="fw-bold text-success mb-0">21,00 Bs</p>
          </div>
        </div>
        <!-- CARD 6 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/price3.jpg" class="card-img-top" alt="Producto 6">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Piano Infantil</h6>
            <p class="fw-bold text-success mb-0">28,80 Bs</p>
          </div>
        </div>
        <!-- CARD 7 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/carro4.jpg" class="card-img-top" alt="Producto 7">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Camion Hotwhels</h6>
            <p class="fw-bold text-success mb-0">33,99 Bs</p>
          </div>
        </div>
        <!-- CARD 8 -->
        <div class="card shadow-sm border-warning" style="min-width: 220px;">
          <img src="assets/imagenes/capitanAmerica.jpg" class="card-img-top" alt="Producto 8">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold" style="color:#e85d04;">Figura de Capitan America</h6>
            <p class="fw-bold text-success mb-0">70,00 Bs</p>
          </div>
        </div>
      </div>
    </div>
     <!-- Botón Derecha -->
     <button id="btnNext2" class="btn btn-outline-warning ms-2 shadow-sm" aria-label="Siguiente">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>
</div>

<script>
  // Slider para Productos Destacados 2
  document.addEventListener("DOMContentLoaded", function () {
    const slider2 = document.getElementById('cardSlider2');
    let items2 = Array.from(slider2.children);

    function shiftLeft2() {
      slider2.style.transform = 'translateX(-230px)';
      setTimeout(() => {
        slider2.appendChild(items2[0]);
        items2.push(items2.shift());
        slider2.style.transition = 'none';
        slider2.style.transform = 'none';
        setTimeout(() => {
          slider2.style.transition = 'transform 0.5s cubic-bezier(.4,1.1,.5,1)';
        }, 20);
      }, 500);
    }

    function shiftRight2() {
      slider2.insertBefore(items2[items2.length - 1], items2[0]);
      items2.unshift(items2.pop());
      slider2.style.transition = 'none';
      slider2.style.transform = 'translateX(-230px)';
      setTimeout(() => {
        slider2.style.transition = 'transform 0.5s cubic-bezier(.4,1.1,.5,1)';
        slider2.style.transform = 'none';
      }, 20);
    }

    document.getElementById('btnNext2').addEventListener('click', shiftLeft2);
    document.getElementById('btnPrev2').addEventListener('click', shiftRight2);
  });
</script>

<section class="features my-5" role="region" aria-label="Características destacadas">
  <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
    <!-- Card 1 -->
    <div class="col d-flex align-items-stretch">
      <article class="card feature-card w-100 text-center border-0 shadow-sm">
        <div class="feature-icon mx-auto mb-3 bg-warning bg-gradient">
          <i class="fas fa-cube fa-2x text-white"></i>
        </div>
        <div class="card-body">
          <h5 class="card-title fw-bold" style="color:#e85d04;">Gran Variedad</h5>
          <p class="card-text">Encuentra juguetes para todas las edades y gustos en un solo lugar.</p>
        </div>
      </article>
    </div>
    <!-- Card 2 -->
    <div class="col d-flex align-items-stretch">
      <article class="card feature-card w-100 text-center border-0 shadow-sm">
        <div class="feature-icon mx-auto mb-3 bg-success bg-gradient">
          <i class="fas fa-shipping-fast fa-2x text-white"></i>
        </div>
        <div class="card-body">
          <h5 class="card-title fw-bold" style="color:#f48c06;">Envío rápido</h5>
          <p class="card-text">Recibe tus pedidos en tiempo récord con nuestro servicio de entrega exprés.</p>
        </div>
      </article>
    </div>
    <!-- Card 3 -->
    <div class="col d-flex align-items-stretch">
      <article class="card feature-card w-100 text-center border-0 shadow-sm">
        <div class="feature-icon mx-auto mb-3 bg-primary bg-gradient">
          <i class="fas fa-star fa-2x text-white"></i>
        </div>
        <div class="card-body">
          <h5 class="card-title fw-bold" style="color:#ffd166;">Marcas reconocidas</h5>
          <p class="card-text">Solo trabajamos con las mejores marcas para garantizar calidad y diversión.</p>
        </div>
      </article>
    </div>
  </div>
</section>


<style>
.feature-card {
  border-radius: 1rem;
  background: #fffbe6;
  transition: transform 0.18s, box-shadow 0.18s;
}
.feature-card:hover {
  transform: translateY(-6px) scale(1.03);
  box-shadow: 0 8px 24px #ffd16655;
}
.feature-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 8px #e85d0440;
  transition: box-shadow 0.18s, background 0.18s;
}
.feature-card:hover .feature-icon {
  box-shadow: 0 4px 16px #e85d0444;
  filter: brightness(1.08);
}
</style>
<!-- Sombra del texto para el carrusel principal -->
<style>
.text-shadow {
  text-shadow: 0 2px 8px rgba(0,0,0,0.55), 0 1px 1px rgba(0,0,0,0.2);
  color: #fff !important;
}
.carousel-caption h1, .carousel-caption p {
  text-align: center;
}
</style>
<?php
include("assets/componentes/footer.php");
?>