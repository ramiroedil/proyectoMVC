<?php
include("assets/componentes/header.php");


$categorias = [
  "Para Niños", "Para Niñas", "Para bebés", "Figuras de acción",
  "Juegos de mesa", "Vehículos", "Muñecas y accesorios", "Peluches",
  "Juegos al aire libre", "Artes y manualidades", "Educativos", "Bloques y legos"
];


$menuColor = "#343a40"; 
$menuHover = "#17a2b8"; 
$menuActive = "#17a2b8"; 
$menuActiveText = "#fff"; 
$menuInactiveText = "#343a40"; 

$btnDetalles = "#f39c12"; 
$btnDetallesHover = "#17a2b8"; 
$btnDetallesText = "#fff"; 


$productos = [
    "Para Niños" => [
        ["nombre" => "Camión de Bomberos", "img" => "assets/imagenes/niño1.jpg", "precio" => 45, "desc" => "Con luces y sonidos."],
        ["nombre" => "Dinosaurios Armables", "img" => "assets/imagenes/niño2.jpg", "precio" => 38.5, "desc" => "Set de construcción."],
        ["nombre" => "Pistola de Agua", "img" => "assets/imagenes/niño3.jpg", "precio" => 22, "desc" => "Gran alcance y fácil de llenar."],
        ["nombre" => "Set de Bolas Saltarinas", "img" => "assets/imagenes/niño4.jpg", "precio" => 18, "desc" => "Colores brillantes y rebote increíble."],
        ["nombre" => "Autopista de Carreras", "img" => "assets/imagenes/niño5.jpg", "precio" => 55, "desc" => "Incluye dos autos y looping."],
        ["nombre" => "Robot Interactivo", "img" => "assets/imagenes/niño6.jpg", "precio" => 65, "desc" => "Camina, baila y habla frases divertidas."],
        ["nombre" => "Set Explorador", "img" => "assets/imagenes/niño7.jpg", "precio" => 29.5, "desc" => "Brújula, linterna y binoculares de juguete."],
        ["nombre" => "Canasta de Básquet Portátil", "img" => "assets/imagenes/niño8.jpg", "precio" => 40, "desc" => "Fácil de armar y altura ajustable."],
        ["nombre" => "Puzzle de Animales", "img" => "assets/imagenes/niño9.jpg", "precio" => 15, "desc" => "Piezas grandes para manos pequeñas."],
        ["nombre" => "Trompo Eléctrico", "img" => "assets/imagenes/niño10.jpg", "precio" => 12, "desc" => "Luces LED y giros rápidos."],
        ["nombre" => "Set de Superhéroes", "img" => "assets/imagenes/niño11.jpg", "precio" => 35, "desc" => "Incluye máscaras y capas."],
        ["nombre" => "Juego de Pesca Magnético", "img" => "assets/imagenes/niño12.jpg", "precio" => 20, "desc" => "Peces y caña con imán para pescar."],
    ],
    "Para Niñas" => [
        ["nombre" => "Casa de Muñecas", "img" => "assets/imagenes/niña1.jpg", "precio" => 65, "desc" => "Con accesorios."],
        ["nombre" => "Set de Belleza Infantil", "img" => "assets/imagenes/niña2.jpg", "precio" => 22, "desc" => "Incluye peine, espejo y maquillaje no tóxico."],
        ["nombre" => "Cocina Rosa", "img" => "assets/imagenes/niña3.jpg", "precio" => 48.5, "desc" => "Cocina con luces, sonidos y utensilios."],
        ["nombre" => "Muñeca Cantante", "img" => "assets/imagenes/niña4.jpg", "precio" => 36, "desc" => "Canta canciones y mueve los brazos."],
        ["nombre" => "Set de Manualidades", "img" => "assets/imagenes/niña5.jpg", "precio" => 19, "desc" => "Incluye cuentas, hilos y pegatinas."],
        ["nombre" => "Carrito de Compras", "img" => "assets/imagenes/niña6.jpg", "precio" => 32, "desc" => "Con frutas y verduras de juguete."],
        ["nombre" => "Unicornio de Peluche", "img" => "assets/imagenes/niña7.jpg", "precio" => 27, "desc" => "Suave, brillante y colorido."],
        ["nombre" => "Set de Té", "img" => "assets/imagenes/niña8.jpg", "precio" => 15.5, "desc" => "Vajilla de juguete para 4 personas."],
        ["nombre" => "Muñeca Bailarina", "img" => "assets/imagenes/niña9.jpg", "precio" => 29, "desc" => "Vestido de tul y zapatillas de ballet."],
        ["nombre" => "Peluche Sirena", "img" => "assets/imagenes/niña10.jpg", "precio" => 23.5, "desc" => "De tela suave y cabello largo."],
        ["nombre" => "Set de Princesa", "img" => "assets/imagenes/niña11.jpg", "precio" => 34, "desc" => "Corona, varita y vestido incluido."],
        ["nombre" => "Puzzle de Hadas", "img" => "assets/imagenes/niña12.jpg", "precio" => 13.5, "desc" => "Rompecabezas de 100 piezas de hadas."]
    ],
    "Para bebés" => [
        ["nombre" => "Gimnasio Musical", "img" => "assets/imagenes/bebe1.jpg", "precio" => 55, "desc" => "Colchoneta con luces y sonidos."],
        ["nombre" => "Sonajero Animalitos", "img" => "assets/imagenes/bebe2.jpg", "precio" => 8.5, "desc" => "Sonidos suaves y colores vivos."],
        ["nombre" => "Pelota Texturizada", "img" => "assets/imagenes/bebe3.jpg", "precio" => 10, "desc" => "Fácil de agarrar y morder."],
        ["nombre" => "Cubo de Actividades", "img" => "assets/imagenes/bebe4.jpg", "precio" => 26, "desc" => "Con cuentas, espejos y engranajes."],
        ["nombre" => "Mordedor Refrigerante", "img" => "assets/imagenes/bebe5.jpg", "precio" => 7, "desc" => "Alivia las encías de tu bebé."],
        ["nombre" => "Peluche Musical", "img" => "assets/imagenes/bebe6.jpg", "precio" => 18.5, "desc" => "Toca melodías suaves para dormir."],
        ["nombre" => "Libro de Tela", "img" => "assets/imagenes/bebe7.jpg", "precio" => 12, "desc" => "Lavable y con texturas diferentes."],
        ["nombre" => "Patito de Baño", "img" => "assets/imagenes/bebe8.jpg", "precio" => 6.5, "desc" => "Flota y chirría en el agua."],
        ["nombre" => "Móvil para Cuna", "img" => "assets/imagenes/bebe9.jpg", "precio" => 32, "desc" => "Con figuras giratorias y música."],
        ["nombre" => "Tren de Arrastre", "img" => "assets/imagenes/bebe10.jpg", "precio" => 20, "desc" => "Ayuda a dar los primeros pasos."],
        ["nombre" => "Bloques Suaves", "img" => "assets/imagenes/bebe11.jpg", "precio" => 17.5, "desc" => "De goma, seguros y coloridos."],
        ["nombre" => "Alfombra de Juegos", "img" => "assets/imagenes/bebe12.jpg", "precio" => 25, "desc" => "Con colores y dibujos llamativos."]
    ],
    "Figuras de acción" => [
        ["nombre" => "Figura Spider-Man", "img" => "assets/imagenes/herue1.jpg", "precio" => 25.9, "desc" => "Superhéroe articulado."],
        ["nombre" => "Figura Batman", "img" => "assets/imagenes/herue2.jpg", "precio" => 28, "desc" => "Incluye capa y batarang."],
        ["nombre" => "Capitán América", "img" => "assets/imagenes/herue3.jpg", "precio" => 27.5, "desc" => "Con escudo removible."],
        ["nombre" => "Iron Man", "img" => "assets/imagenes/herue4.jpg", "precio" => 30, "desc" => "Luz LED en el pecho."],
        ["nombre" => "Hulk", "img" => "assets/imagenes/herue5.jpg", "precio" => 26, "desc" => "Figura grande y resistente."],
        ["nombre" => "Thor", "img" => "assets/imagenes/herue6.jpg", "precio" => 29, "desc" => "Con martillo Mjolnir."],
        ["nombre" => "Black Panther", "img" => "assets/imagenes/herue7.jpg", "precio" => 26.5, "desc" => "Vestimenta detallada."],
        ["nombre" => "Flash", "img" => "assets/imagenes/herue8.jpg", "precio" => 24, "desc" => "Incluye base para correr."],
        ["nombre" => "Superman", "img" => "assets/imagenes/herue9.jpg", "precio" => 27, "desc" => "Con capa roja y base."],
        ["nombre" => "Wonder Woman", "img" => "assets/imagenes/herue10.jpg", "precio" => 28.5, "desc" => "Con lazo y diadema."],
        ["nombre" => "Ant-Man", "img" => "assets/imagenes/herue11.jpg", "precio" => 22, "desc" => "Figura pequeña y casco removible."],
        ["nombre" => "Aquaman", "img" => "assets/imagenes/herue12.jpg", "precio" => 26, "desc" => "Con tridente dorado."]
    ],
    "Juegos de mesa" => [
        ["nombre" => "Adivina Quién", "img" => "assets/imagenes/mesa1.jpg", "precio" => 35, "desc" => "El clásico familiar."],
        ["nombre" => "Monopoly", "img" => "assets/imagenes/mesa2.jpg", "precio" => 40, "desc" => "Juego de finanzas y estrategia."],
        ["nombre" => "UNO", "img" => "assets/imagenes/mesa3.jpg", "precio" => 20, "desc" => "Cartas para toda la familia."],
        ["nombre" => "Scrabble", "img" => "assets/imagenes/mesa4.jpg", "precio" => 38, "desc" => "Forma palabras y gana puntos."],
        ["nombre" => "Jenga", "img" => "assets/imagenes/mesa5.jpg", "precio" => 28, "desc" => "Bloques de madera apilables."],
        ["nombre" => "Twister", "img" => "assets/imagenes/mesa6.jpg", "precio" => 25, "desc" => "Diversión de equilibrio y color."],
        ["nombre" => "Ludo", "img" => "assets/imagenes/mesa7.jpg", "precio" => 18, "desc" => "Juego clásico de tablero."],
        ["nombre" => "Damas Chinas", "img" => "assets/imagenes/mesa8.jpg", "precio" => 19, "desc" => "Hasta 6 jugadores."],
        ["nombre" => "Rummikub", "img" => "assets/imagenes/mesa9.jpg", "precio" => 34, "desc" => "Fichas y números."],
        ["nombre" => "Trivial Pursuit", "img" => "assets/imagenes/mesa10.jpg", "precio" => 42, "desc" => "Preguntas y respuestas."],
        ["nombre" => "Pictionary", "img" => "assets/imagenes/mesa11.jpg", "precio" => 33, "desc" => "Dibuja y adivina."],
        ["nombre" => "Bingo", "img" => "assets/imagenes/mesa12.jpg", "precio" => 15, "desc" => "Juego clásico de azar."]
    ],
    "Vehículos" => [
        ["nombre" => "Hot Wheels Mega Pack", "img" => "assets/imagenes/camion1.jpg", "precio" => 32, "desc" => "Pack de 10 autos."],
        ["nombre" => "Camioneta Pickup", "img" => "assets/imagenes/camion2.jpg", "precio" => 25, "desc" => "Resistente y colorida."],
        ["nombre" => "Motocicleta Cross", "img" => "assets/imagenes/camion3.jpg", "precio" => 22, "desc" => "Con suspensión real."],
        ["nombre" => "Tractor de Granja", "img" => "assets/imagenes/camion4.jpg", "precio" => 30, "desc" => "Incluye remolque."],
        ["nombre" => "Avión de Juguete", "img" => "assets/imagenes/camion5.jpg", "precio" => 28, "desc" => "A hélice, fácil de lanzar."],
        ["nombre" => "Helicóptero Rescate", "img" => "assets/imagenes/camion6.jpg", "precio" => 35, "desc" => "Con gancho y hélices móviles."],
        ["nombre" => "Auto de Policía", "img" => "assets/imagenes/camion7.jpg", "precio" => 27, "desc" => "Con luces y sirena."],
        ["nombre" => "Barco Pirata", "img" => "assets/imagenes/camion8.jpg", "precio" => 40, "desc" => "Flota en el agua."],
        ["nombre" => "Tren Eléctrico", "img" => "assets/imagenes/camion9.jpg", "precio" => 50, "desc" => "Pistas y vagones incluidos."],
        ["nombre" => "Auto de Carreras RC", "img" => "assets/imagenes/camion10.jpg", "precio" => 60, "desc" => "Control remoto, gran velocidad."],
        ["nombre" => "Bulldozer", "img" => "assets/imagenes/camion11.jpg", "precio" => 32, "desc" => "Pala frontal móvil."],
        ["nombre" => "Ambulancia", "img" => "assets/imagenes/camion12.jpg", "precio" => 28, "desc" => "Con puertas que se abren."]
    ],
    "Muñecas y accesorios" => [
        ["nombre" => "Barbie Aventuras", "img" => "assets/imagenes/barbie1.jpg", "precio" => 29.99, "desc" => "Muñeca con accesorios."],
        ["nombre" => "Muñeca Fashion", "img" => "assets/imagenes/barbie2.jpg", "precio" => 28.5, "desc" => "Vestidos intercambiables."],
        ["nombre" => "Set de Ropa para Muñeca", "img" => "assets/imagenes/barbie3.jpg", "precio" => 18, "desc" => "Incluye 6 conjuntos."],
        ["nombre" => "Cochecito de Muñecas", "img" => "assets/imagenes/barbie4.jpg", "precio" => 32, "desc" => "Plegable y ligero."],
        ["nombre" => "Casa de Muñecas", "img" => "assets/imagenes/barbie5.jpg", "precio" => 65, "desc" => "Con mobiliario completo."],
        ["nombre" => "Set de Maquillaje para Muñeca", "img" => "assets/imagenes/barbie6.jpg", "precio" => 20, "desc" => "No tóxico y lavable."],
        ["nombre" => "Muñeca Sirena", "img" => "assets/imagenes/barbie7.jpg", "precio" => 24, "desc" => "Con cola brillante."],
        ["nombre" => "Muñeca Bailarina", "img" => "assets/imagenes/barbie8.jpg", "precio" => 23, "desc" => "Con tutú y zapatillas."],
        ["nombre" => "Set Picnic para Muñeca", "img" => "assets/imagenes/barbie9.jpg", "precio" => 17, "desc" => "Incluye manta y accesorios."],
        ["nombre" => "Muñeca Bebé", "img" => "assets/imagenes/barbie10.jpg", "precio" => 19, "desc" => "Con biberón y chupete."],
        ["nombre" => "Silla Alta para Muñeca", "img" => "assets/imagenes/barbie11.jpg", "precio" => 14, "desc" => "Fácil de armar."],
        ["nombre" => "Muñeca Princesa", "img" => "assets/imagenes/barbie12.jpg", "precio" => 26, "desc" => "Con vestido largo y corona."]
    ],
    "Peluches" => [
        ["nombre" => "Oso Gigante", "img" => "assets/imagenes/peluche1.jpg", "precio" => 60, "desc" => "Suave y abrazable."],
        ["nombre" => "Conejo de Peluche", "img" => "assets/imagenes/peluche2.jpg", "precio" => 28, "desc" => "Orejas largas y tierno."],
        ["nombre" => "Peluche Unicornio", "img" => "assets/imagenes/peluche3.jpg", "precio" => 32, "desc" => "Cola y crin de colores."],
        ["nombre" => "Panda Pequeño", "img" => "assets/imagenes/peluche4.jpg", "precio" => 19, "desc" => "Tamaño mini y suave."],
        ["nombre" => "León Bebé", "img" => "assets/imagenes/peluche5.jpg", "precio" => 24, "desc" => "Melena dorada y suave."],
        ["nombre" => "Jirafita", "img" => "assets/imagenes/peluche6.jpg", "precio" => 21, "desc" => "Cuello largo, ideal para abrazar."],
        ["nombre" => "Tigre Rayado", "img" => "assets/imagenes/peluche7.jpg", "precio" => 27, "desc" => "Colores realistas y textura suave."],
        ["nombre" => "Elefante Gris", "img" => "assets/imagenes/peluche8.jpg", "precio" => 25, "desc" => "Orejas grandes y blanditas."],
        ["nombre" => "Pulpo de Peluche", "img" => "assets/imagenes/peluche9.jpg", "precio" => 22, "desc" => "Con tentáculos y carita feliz."],
        ["nombre" => "Perrito Dormilón", "img" => "assets/imagenes/peluche10.jpg", "precio" => 31, "desc" => "Posición tumbado, ideal para siestas."],
        ["nombre" => "Ratón Gris", "img" => "assets/imagenes/peluche11.jpg", "precio" => 17, "desc" => "Pequeño y simpático."],
        ["nombre" => "Koala", "img" => "assets/imagenes/peluche12.jpg", "precio" => 29, "desc" => "Nariz negra y suave."]
    ],
    "Juegos al aire libre" => [
        ["nombre" => "Cuerda de saltar LED", "img" => "assets/imagenes/cuerda1.jpg", "precio" => 12.5, "desc" => "Con luces para más diversión."],
        ["nombre" => "Frisbee Volador", "img" => "assets/imagenes/cuerda2.jpg", "precio" => 8, "desc" => "Ligero y colorido."],
        ["nombre" => "Pelota Saltarina", "img" => "assets/imagenes/cuerda3.jpg", "precio" => 13, "desc" => "Brinca alto y es resistente."],
        ["nombre" => "Set de Raquetas", "img" => "assets/imagenes/cuerda4.jpg", "precio" => 18, "desc" => "Incluye pelota blanda."],
        ["nombre" => "Casa de Campaña Infantil", "img" => "assets/imagenes/cuerda5.jpg", "precio" => 40, "desc" => "Fácil de armar y transportar."],
        ["nombre" => "Pistola de Agua", "img" => "assets/imagenes/cuerda6.jpg", "precio" => 15, "desc" => "Alcance de hasta 8 metros."],
        ["nombre" => "Carpa de Bolas", "img" => "assets/imagenes/cuerda7.jpg", "precio" => 33, "desc" => "Incluye 50 pelotas."],
        ["nombre" => "Cometa de Colores", "img" => "assets/imagenes/cuerda8.jpg", "precio" => 14, "desc" => "Fácil de volar."],
        ["nombre" => "Set de Bowling", "img" => "assets/imagenes/cuerda9.jpg", "precio" => 20, "desc" => "10 pinos y 2 bolas."],
        ["nombre" => "Pistola Lanzabolas", "img" => "assets/imagenes/cuerda10.jpg", "precio" => 19, "desc" => "Incluye 6 bolas suaves."],
        ["nombre" => "Hula Hoop", "img" => "assets/imagenes/cuerda11.jpg", "precio" => 10, "desc" => "Flexible y ligero."],
        ["nombre" => "Balón de Fútbol", "img" => "assets/imagenes/cuerda12.jpg", "precio" => 18, "desc" => "Tamaño infantil."]
    ],
    "Artes y manualidades" => [
        ["nombre" => "Set de plastilina", "img" => "assets/imagenes/arte1.jpg", "precio" => 16, "desc" => "12 colores y moldes."],
        ["nombre" => "Kit de pintura", "img" => "assets/imagenes/arte2.jpg", "precio" => 22, "desc" => "Incluye pinceles y acuarelas."],
        ["nombre" => "Cuentas para collares", "img" => "assets/imagenes/arte3.jpg", "precio" => 13, "desc" => "Colores variados y cordón."],
        ["nombre" => "Cartulina de colores", "img" => "assets/imagenes/arte4.jpg", "precio" => 6, "desc" => "Paquete de 20 hojas."],
        ["nombre" => "Tijeras de formas", "img" => "assets/imagenes/arte5.jpg", "precio" => 9, "desc" => "Para recortes decorativos."],
        ["nombre" => "Pegamento en barra", "img" => "assets/imagenes/arte6.jpg", "precio" => 4, "desc" => "No tóxico y lavable."],
        ["nombre" => "Sellos de goma", "img" => "assets/imagenes/arte7.jpg", "precio" => 11, "desc" => "Diferentes figuras divertidas."],
        ["nombre" => "Rotuladores lavables", "img" => "assets/imagenes/arte8.jpg", "precio" => 15, "desc" => "12 colores vivos."],
        ["nombre" => "Láminas para raspar", "img" => "assets/imagenes/arte9.jpg", "precio" => 8, "desc" => "Dibujos que aparecen al raspar."],
        ["nombre" => "Papel crepé", "img" => "assets/imagenes/arte10.jpg", "precio" => 7, "desc" => "Varias texturas y colores."],
        ["nombre" => "Kit de origami", "img" => "assets/imagenes/arte11.jpg", "precio" => 12, "desc" => "Incluye instrucciones y papel."],
        ["nombre" => "Pintura con dedos", "img" => "assets/imagenes/arte12.jpg", "precio" => 10, "desc" => "No tóxica y fácil de limpiar."]
    ],
    "Educativos" => [
        ["nombre" => "Piano Infantil", "img" => "assets/imagenes/piano1.jpg", "precio" => 28.8, "desc" => "Con luces y sonidos."],
        ["nombre" => "Abaco de madera", "img" => "assets/imagenes/piano2.jpg", "precio" => 19, "desc" => "Ayuda a aprender a contar."],
        ["nombre" => "Puzzle numérico", "img" => "assets/imagenes/piano3.jpg", "precio" => 15, "desc" => "Piezas grandes y coloridas."],
        ["nombre" => "Juego de memoria", "img" => "assets/imagenes/piano4.jpg", "precio" => 14, "desc" => "Cartas ilustradas."],
        ["nombre" => "Libro interactivo", "img" => "assets/imagenes/piano5.jpg", "precio" => 23, "desc" => "Con botones de sonido."],
        ["nombre" => "Tablero magnético", "img" => "assets/imagenes/piano6.jpg", "precio" => 20, "desc" => "Para escribir y dibujar."],
        ["nombre" => "Reloj didáctico", "img" => "assets/imagenes/piano7.jpg", "precio" => 13, "desc" => "Aprende las horas jugando."],
        ["nombre" => "Set de letras imantadas", "img" => "assets/imagenes/piano8.jpg", "precio" => 18, "desc" => "Para aprender el abecedario."],
        ["nombre" => "Cubo lógico", "img" => "assets/imagenes/piano9.jpg", "precio" => 16, "desc" => "Formas y colores."],
        ["nombre" => "Juego de ciencia", "img" => "assets/imagenes/piano10.jpg", "precio" => 35, "desc" => "Experimentos sencillos."],
        ["nombre" => "Mapa infantil", "img" => "assets/imagenes/piano11.jpg", "precio" => 21, "desc" => "Mapa del mundo para colorear."],
        ["nombre" => "Lupa de explorador", "img" => "assets/imagenes/piano12.jpg", "precio" => 9, "desc" => "Para investigar la naturaleza."]
    ],
    "Bloques y legos" => [
        ["nombre" => "Set Lego Classic 1000pzs", "img" => "assets/imagenes/lego1.jpg", "precio" => 39.5, "desc" => "Cientos de piezas para crear."],
        ["nombre" => "Bloques grandes", "img" => "assets/imagenes/lego2.jpg", "precio" => 24, "desc" => "Para los más pequeños."],
        ["nombre" => "Lego City Policía", "img" => "assets/imagenes/lego3.jpg", "precio" => 49, "desc" => "Incluye patrulla y figuras."],
        ["nombre" => "Bloques magnéticos", "img" => "assets/imagenes/lego4.jpg", "precio" => 33, "desc" => "Para construcciones seguras."],
        ["nombre" => "Set de castillo", "img" => "assets/imagenes/lego5.jpg", "precio" => 45, "desc" => "Con torres y caballeros."],
        ["nombre" => "Lego Friends", "img" => "assets/imagenes/lego6.jpg", "precio" => 39, "desc" => "Para construir una ciudad."],
        ["nombre" => "Bloques con números", "img" => "assets/imagenes/lego7.jpg", "precio" => 18, "desc" => "Para aprender contando."],
        ["nombre" => "Lego Star Wars", "img" => "assets/imagenes/lego8.jpg", "precio" => 56, "desc" => "Naves y personajes de la saga."],
        ["nombre" => "Bloques de madera", "img" => "assets/imagenes/lego9.jpg", "precio" => 22, "desc" => "Clásicos y resistentes."],
        ["nombre" => "Lego Technic", "img" => "assets/imagenes/lego10.jpg", "precio" => 60, "desc" => "Construcciones avanzadas."],
        ["nombre" => "Bloques encajables", "img" => "assets/imagenes/lego11.jpg", "precio" => 17, "desc" => "Fáciles de unir y separar."],
        ["nombre" => "Lego Ninjago", "img" => "assets/imagenes/lego12.jpg", "precio" => 48, "desc" => "Dragones y ninjas para armar."]
    ],
];

$activa = isset($_GET['cat']) && in_array($_GET['cat'], $categorias) ? $_GET['cat'] : $categorias[0];
?>


<style>
.categoria-btn {
  border: 2px solid <?= $menuColor ?>;
  color: <?= $menuInactiveText ?>;
  background: #fff;
  transition: all .2s;
  font-weight: bold;
  letter-spacing: .5px;
}
.categoria-btn:hover, .categoria-btn:focus {
  background: <?= $menuHover ?>;
  color: #fff;
  border-color: <?= $menuHover ?>;
  text-decoration: none;
}
.categoria-btn.active, .categoria-btn[aria-current="page"] {
  background: <?= $menuActive ?>;
  color: <?= $menuActiveText ?>;
  border-color: <?= $menuActive ?>;
}
.btn-detalles {
  background: <?= $btnDetalles ?>;
  color: <?= $btnDetallesText ?>;
  font-weight: bold;
  border: none;
  transition: all .2s;
  letter-spacing: .5px;
}
.btn-detalles:hover, .btn-detalles:focus {
  background: <?= $btnDetallesHover ?>;
  color: #fff;
}
</style>

<main class="container py-4">
  <h1 class="text-center mb-4" style="color:<?= $menuColor ?>;"><i class="fas fa-cubes"></i> Productos</h1>
  <div class="mb-4 d-flex flex-wrap gap-2 justify-content-center">
    <?php foreach ($categorias as $cat): ?>
      <a href="?cat=<?= urlencode($cat) ?>"
         class="btn rounded-pill categoria-btn px-3 py-2<?= $cat == $activa ? ' active' : '' ?>"
         <?= $cat == $activa ? 'aria-current="page"' : '' ?>>
        <?= $cat ?>
      </a>
    <?php endforeach; ?>
  </div>
  
  <div class="row g-4">
    <?php if (!empty($productos[$activa])): ?>
      <?php foreach ($productos[$activa] as $prod): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 shadow-sm border-0">
            <img src="<?= $prod['img'] ?>" class="card-img-top" alt="<?= $prod['nombre'] ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title fw-bold" style="color:<?= $menuColor ?>;"><?= $prod['nombre'] ?></h5>
              <p class="card-text"><?= $prod['desc'] ?></p>
              <div class="mt-auto">
                <p class="fw-bold" style="color:<?= $menuColor ?>;"><?= number_format($prod['precio'], 2) ?> Bs</p>
                <a href="#" class="btn btn-sm btn-detalles">Ver detalles</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12 text-center text-muted">
        <p>No hay productos para esta categoría.</p>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php
include("assets/componentes/footer.php");
?>