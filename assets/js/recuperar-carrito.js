/* ========================================
   RECUPERACIÓN DE CARRITO POST-LOGIN
   ======================================== */

/**
 * Recuperar carrito almacenado antes del login
 * Se ejecuta cuando el usuario vuelve del login
 */
function recuperarCarritoPostLogin() {
    const carritoBackup = sessionStorage.getItem('carrito_backup');
    
    if (carritoBackup) {
        try {
            const carrito = JSON.parse(carritoBackup);
            console.log('🔄 Recuperando carrito post-login:', carrito);
            
            // Reconstruir carrito en sesión del servidor
            carrito.forEach(item => {
                agregarAlCarritoPostLogin(
                    item.id,
                    item.nombre,
                    item.precio,
                    item.cantidad
                );
            });
            
            // Limpiar sessionStorage
            sessionStorage.removeItem('carrito_backup');
            
            mostrarNotificacion('success', '✅ Carrito recuperado correctamente');
        } catch (error) {
            console.error('❌ Error recuperando carrito:', error);
        }
    }
}

/**
 * Agregar producto al carrito con cantidad específica
 * @param {number} productoId - ID del producto
 * @param {string} nombre - Nombre del producto
 * @param {number} precio - Precio del producto
 * @param {number} cantidad - Cantidad a agregar
 */
function agregarAlCarritoPostLogin(productoId, nombre, precio, cantidad) {
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=agregar_carrito&producto_id=${productoId}&cantidad=${cantidad}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(`✅ ${nombre} recuperado al carrito`);
        }
    })
    .catch(error => console.error('❌ Error:', error));
}

// Ejecutar cuando el DOM carga
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔍 Verificando carrito post-login...');
    recuperarCarritoPostLogin();
});

console.log('✅ Script de recuperación de carrito cargado');