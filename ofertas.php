<?php
include("assets/componentes/header.php");
?>

<style>
/* Color principal y destacado para ofertas */
.oferta-title {
  color: #2d4263;
  letter-spacing: 1px;
}
.card-oferta {
  border: 2px solid #17a2b8 !important;
  transition: box-shadow .2s, border-color .2s;
}
.card-oferta:hover {
  box-shadow: 0 4px 20px rgba(23,162,184,0.15);
  border-color: #f39c12 !important;
}
.btn-oferta {
  background: #f39c12;
  color: #fff;
  font-weight: bold;
  border: none;
  transition: background .2s;
  letter-spacing: .5px;
}
.btn-oferta:hover, .btn-oferta:focus {
  background: #17a2b8;
  color: #fff;
}
</style>

<main class="container py-5">
  <h1 class="text-center mb-4 oferta-title"><i class="fas fa-tags"></i> Ofertas Especiales</h1>
  <div class="alert alert-success text-center mb-4" role="alert" style="font-size:1.15rem;">
    <strong>¡No dejes pasar estas increíbles promociones por tiempo limitado!</strong>
  </div>
  <div class="row g-4 justify-content-center">
    
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card h-100 shadow-sm card-oferta">
        <img src="assets/imagenes/dino1.jpg" class="card-img-top" alt="Jurassic World Dino">
        <div class="card-body text-center d-flex flex-column">
          <h6 class="card-title fw-bold oferta-title">Jurassic World Dino</h6>
          <p class="text-decoration-line-through text-muted mb-0">45,00 Bs</p>
          <p class="fw-bold text-success mb-2" style="font-size:1.15rem;">35,00 Bs</p>
          <a href="#" class="btn btn-oferta btn-sm mt-auto">Comprar oferta</a>
        </div>
      </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card h-100 shadow-sm card-oferta">
        <img src="assets/imagenes/funko3.jpg" class="card-img-top" alt="Funko Pop Mario Bros">
        <div class="card-body text-center d-flex flex-column">
          <h6 class="card-title fw-bold oferta-title">Funko Pop Mario Bros</h6>
          <p class="text-decoration-line-through text-muted mb-0">22,00 Bs</p>
          <p class="fw-bold text-success mb-2" style="font-size:1.15rem;">17,99 Bs</p>
          <a href="#" class="btn btn-oferta btn-sm mt-auto">Comprar oferta</a>
        </div>
      </div>
    </div>
    <!-- Puedes duplicar este bloque para más ofertas -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card h-100 shadow-sm card-oferta">
        <img src="assets/imagenes/lego1.jpg" class="card-img-top" alt="Lego Classic 1000pzs">
        <div class="card-body text-center d-flex flex-column">
          <h6 class="card-title fw-bold oferta-title">Lego Classic 1000pzs</h6>
          <p class="text-decoration-line-through text-muted mb-0">50,00 Bs</p>
          <p class="fw-bold text-success mb-2" style="font-size:1.15rem;">39,99 Bs</p>
          <a href="#" class="btn btn-oferta btn-sm mt-auto">Comprar oferta</a>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card h-100 shadow-sm card-oferta">
        <img src="assets/imagenes/peluche1.jpg" class="card-img-top" alt="Oso Gigante">
        <div class="card-body text-center d-flex flex-column">
          <h6 class="card-title fw-bold oferta-title">Oso Gigante</h6>
          <p class="text-decoration-line-through text-muted mb-0">75,00 Bs</p>
          <p class="fw-bold text-success mb-2" style="font-size:1.15rem;">59,99 Bs</p>
          <a href="#" class="btn btn-oferta btn-sm mt-auto">Comprar oferta</a>
        </div>
      </div>
    </div>
    <!-- ... más ofertas ... -->
  </div>
</main>

<?php
include("assets/componentes/footer.php");
?>