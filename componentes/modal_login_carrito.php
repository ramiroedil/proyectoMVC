<?php
// Modal de Login para Carrito
?>

<!-- Modal Login para Comprar -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(90deg, #e85d04, #f48c06); color: white; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión para Comprar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Por favor inicia sesión</strong> para completar tu compra. Tus productos se guardarán automáticamente.
                </div>

                <form id="formLogin">
                    <div class="mb-3">
                        <label for="loginUsername" class="form-label">
                            <i class="fas fa-user"></i> Usuario
                        </label>
                        <input type="text" class="form-control" id="loginUsername" 
                               placeholder="Ingresa tu usuario" required>
                    </div>

                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">
                            <i class="fas fa-lock"></i> Contraseña
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="loginPassword" 
                                   placeholder="Ingresa tu contraseña" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div id="loginError" class="alert alert-danger d-none" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <span id="loginErrorText"></span>
                    </div>

                    <button type="submit" class="btn btn-login-compra w-100 mb-2">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </button>
                </form>

                <div class="text-center">
                    <p class="text-muted mb-0">
                        ¿No tienes cuenta? 
                        <a href="#" data-bs-dismiss="modal" onclick="alert('Contacta al administrador para crear una cuenta')">
                            Solicitar registro
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Success After Login -->
<div class="modal fade" id="loginSuccessModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(90deg, #28a745, #20c997); color: white; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle"></i> ¡Sesión Iniciada!
                </h5>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-thumbs-up" style="font-size: 3rem; color: #28a745; margin: 1rem 0;"></i>
                <h5>¡Bienvenido de nuevo!</h5>
                <p>Tu carrito ha sido transferido correctamente. Serás redirigido al proceso de compra...</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle para ver/ocultar contraseña en modal login
    document.getElementById('toggleLoginPassword').addEventListener('click', function() {
        const input = document.getElementById('loginPassword');
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.add('fa-eye');
            icon.classList.remove('fa-eye-slash');
        }
    });

    // Manejo del formulario de login
    document.getElementById('formLogin').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const username = document.getElementById('loginUsername').value;
        const password = document.getElementById('loginPassword').value;
        const carrito = <?php echo json_encode($_SESSION['carrito_publico'] ?? []); ?>;
        
        // Obtener carrito actual del DOM
        const carritoActual = await obtenerCarritoActual();
        
        const btn = this.querySelector('button[type="submit"]');
        const btnOriginal = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Validando...';
        btn.disabled = true;

        try {
            const response = await fetch('ajax/carrito_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=validar_y_transferir&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&carrito=${encodeURIComponent(JSON.stringify(carritoActual))}`
            });

            const data = await response.json();

            if (data.success) {
                // Mostrar modal de éxito
                document.getElementById('loginError').classList.add('d-none');
                
                const successModal = new bootstrap.Modal(document.getElementById('loginSuccessModal'));
                successModal.show();

                // Redirigir después de 2 segundos
                setTimeout(() => {
                    if (data.tipo_usuario === 'empleado') {
                        window.location.href = 'controlador/controladorVenta.php';
                    } else {
                        window.location.href = data.redirect || 'inicio1.php';
                    }
                }, 2000);
            } else {
                // Mostrar error
                const errorDiv = document.getElementById('loginError');
                document.getElementById('loginErrorText').textContent = data.message;
                errorDiv.classList.remove('d-none');
                btn.innerHTML = btnOriginal;
                btn.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            const errorDiv = document.getElementById('loginError');
            document.getElementById('loginErrorText').textContent = 'Error de conexión. Intenta de nuevo.';
            errorDiv.classList.remove('d-none');
            btn.innerHTML = btnOriginal;
            btn.disabled = false;
        }
    });

    // Función auxiliar para obtener carrito
    function obtenerCarritoActual() {
        return new Promise((resolve) => {
            fetch('portal_publico.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=obtener_carrito'
            })
            .then(response => response.json())
            .then(data => {
                resolve(data.carrito || []);
            })
            .catch(() => resolve([]));
        });
    }

    // Botón "Proceder a Comprar" en el modal del carrito
    document.addEventListener('DOMContentLoaded', function() {
        const btnComprar = document.getElementById('btn-comprar');
        if (btnComprar) {
            btnComprar.addEventListener('click', function(e) {
                const carrito = <?php echo json_encode($_SESSION['carrito_publico'] ?? []); ?>;
                
                if (carrito.length === 0) {
                    alert('Tu carrito está vacío');
                    e.preventDefault();
                    return;
                }
                
                // Mostrar modal de login
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                e.preventDefault();
            });
        }
    });
</script>