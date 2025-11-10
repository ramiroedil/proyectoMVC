/* ========================================
   CONFIGURACIÓN GLOBAL
   ======================================== */

const API_BASE_URL = document.querySelector('meta[data-api-url]')?.content || 'http://localhost:3000';
const IMAGE_URL = document.querySelector('meta[data-image-url]')?.content || 'http://localhost:3000/uploads/';

console.log('🛍️ Portal público iniciado');
console.log('IMAGE_URL:', IMAGE_URL);
console.log('API_BASE_URL:', API_BASE_URL);

/* ========================================
   FUNCIONES DE CARRITO
   ======================================== */

/**
 * Agregar producto al carrito
 * @param {number} productoId - ID del producto
 * @param {string} nombre - Nombre del producto
 * @param {number} precio - Precio del producto
 */
function agregarAlCarrito(productoId, nombre, precio) {
    console.log(`➕ Agregando: ${nombre} (ID: ${productoId})`);
    
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=agregar_carrito&producto_id=${productoId}&cantidad=1`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarNotificacion('success', `"${nombre}" agregado al carrito`);
            actualizarCarrito();
        } else {
            mostrarNotificacion('error', data.message || 'Error al agregar el producto');
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        mostrarNotificacion('error', 'Error de conexión');
    });
}

/**
 * Actualizar estado del carrito
 */
function actualizarCarrito() {
    console.log('🔄 Actualizando carrito...');
    
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=obtener_carrito'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('carrito-count');
            if (badge) {
                badge.textContent = data.count;
            }
            renderizarCarrito(data.carrito);
        }
    })
    .catch(error => console.error('❌ Error actualizando carrito:', error));
}

/**
 * Renderizar carrito en el modal
 * @param {Array} carrito - Array con items del carrito
 */
function renderizarCarrito(carrito) {
    const listaCarrito = document.getElementById('lista-carrito');
    const totalCarrito = document.getElementById('total-carrito');
    
    if (!listaCarrito) return;
    
    if (carrito.length === 0) {
        listaCarrito.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-shopping-cart fa-3x" style="color: #ddd;"></i>
                <p class="mt-3 text-muted">Tu carrito está vacío</p>
            </div>
        `;
        if (totalCarrito) {
            totalCarrito.innerHTML = '';
        }
        return;
    }

    let html = '';
    let total = 0;

    carrito.forEach(item => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        
        // Construir URL de imagen correctamente
        const imagenUrl = IMAGE_URL + item.imagen;
        
        html += `
            <div class="item-carrito-modal">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <img src="${imagenUrl}" 
                             alt="${item.nombre}" 
                             class="img-fluid rounded" 
                             style="max-height: 60px; object-fit: cover;"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22%3E%3Crect fill=%22%23ddd%22 width=%2260%22 height=%2260%22/%3E%3C/svg%3E'">
                    </div>
                    <div class="col-md-4">
                        <strong>${item.nombre}</strong>
                        <p class="mb-0 text-muted small">Bs ${parseFloat(item.precio).toFixed(2)}</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <span class="badge bg-primary">${item.cantidad}</span>
                    </div>
                    <div class="col-md-2">
                        <strong style="color: #e85d04;">Bs ${subtotal.toFixed(2)}</strong>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-sm btn-danger" onclick="eliminarDelCarrito(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });

    listaCarrito.innerHTML = html;
    
    if (totalCarrito) {
        totalCarrito.innerHTML = `
            <div class="alert alert-warning mb-0">
                <strong style="font-size: 1.2rem;">Total: Bs ${total.toFixed(2)}</strong>
            </div>
        `;
    }
}

/**
 * Eliminar producto del carrito
 * @param {number} productoId - ID del producto a eliminar
 */
function eliminarDelCarrito(productoId) {
    if (confirm('¿Deseas eliminar este producto del carrito?')) {
        console.log(`🗑️ Eliminando producto ID: ${productoId}`);
        
        fetch('index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=eliminar_carrito&producto_id=${productoId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('success', data.message);
                actualizarCarrito();
            }
        })
        .catch(error => console.error('❌ Error:', error));
    }
}

/* ========================================
   NOTIFICACIONES
   ======================================== */

/**
 * Mostrar notificación al usuario
 * @param {string} tipo - 'success' o 'error'
 * @param {string} mensaje - Mensaje a mostrar
 */
function mostrarNotificacion(tipo, mensaje) {
    const notificacion = document.createElement('div');
    notificacion.className = `alert alert-${tipo === 'success' ? 'success' : 'danger'} position-fixed notificacion`;
    notificacion.style.cssText = 'top: 20px; right: 20px; z-index: 9999; width: auto; min-width: 300px;';
    notificacion.innerHTML = `
        <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        ${mensaje}
    `;
    
    document.body.appendChild(notificacion);
    
    setTimeout(() => {
        notificacion.remove();
    }, 3000);
}

/* ========================================
   INICIALIZACIÓN
   ======================================== */

/**
 * Manejar click en botón "Proceder a Comprar"
 */
function procederAComprar() {
    const carrito = document.getElementById('carrito-count');
    const cantidadProductos = parseInt(carrito?.textContent || 0);
    
    if (cantidadProductos === 0) {
        mostrarNotificacion('error', 'Tu carrito está vacío');
        return;
    }
    
    console.log('🛒 Redirigiendo a login con carrito de', cantidadProductos, 'producto(s)');
    
    // Guardar carrito en sessionStorage para recuperarlo después de login
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=obtener_carrito'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Guardar en sessionStorage (se borra al cerrar navegador)
            sessionStorage.setItem('carrito_backup', JSON.stringify(data.carrito));
            mostrarNotificacion('success', 'Redirigiendo al inicio de sesión...');
            
            // Redirigir después de 1 segundo
            setTimeout(() => {
                window.location.href = 'inicio_sesion.php';
            }, 1000);
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        mostrarNotificacion('error', 'Error al procesar');
    });
}

/**
 * Inicializar la página cuando carga el DOM
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM cargado');
    actualizarCarrito();
    
    // ✅ Agregar evento al botón de compra
    const btnComprar = document.getElementById('btn-comprar');
    if (btnComprar) {
        btnComprar.addEventListener('click', procederAComprar);
    }
    
    // Scroll suave en navbar
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});

/* ========================================
   UTILIDADES
   ======================================== */

/**
 * Formatear número a moneda
 * @param {number} numero - Número a formatear
 * @returns {string} - Número formateado
 */
function formatoMoneda(numero) {
    return parseFloat(numero).toLocaleString('es-BO', {
        style: 'currency',
        currency: 'BOB'
    });
}

/**
 * Obtener parámetro de URL
 * @param {string} param - Nombre del parámetro
 * @returns {string|null} - Valor del parámetro
 */
function obtenerParametroURL(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

console.log('✅ Scripts cargados correctamente');