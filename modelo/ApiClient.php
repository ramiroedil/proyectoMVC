<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../helpers/Session.php');

class ApiClient
{
    private $base_url;
    private $token;
    private $timeout;

    public function __construct()
    {
        Session::start();
        
        $this->base_url = API_BASE_URL;
        $this->timeout = API_TIMEOUT ?? 30;
        $this->token = Session::get('token');
    }

    /**
     * Realizar petición GET
     */
    public function get($endpoint, $params = [])
    {
        $url = $this->base_url . $endpoint;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }

    /**
     * Realizar petición POST
     */
    public function post($endpoint, $data = [], $files = [], $autoRedirect = true)
    {
        $ch = curl_init($this->base_url . $endpoint);

        if (!empty($files)) {
            $postData = $data;
            foreach ($files as $key => $file) {
                if (isset($file['tmp_name']) && file_exists($file['tmp_name'])) {
                    $postData[$key] = new CURLFile(
                        $file['tmp_name'],
                        $file['type'],
                        $file['name']
                    );
                }
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error, $autoRedirect);
    }

    /**
     * Realizar petición PUT
     */
    public function put($endpoint, $data = [])
    {
        $ch = curl_init($this->base_url . $endpoint);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }

    /**
     * Realizar petición PATCH
     */
    public function patch($endpoint, $data = [])
    {
        $ch = curl_init($this->base_url . $endpoint);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }

    /**
     * Realizar petición DELETE
     */
    public function delete($endpoint)
    {
        $ch = curl_init($this->base_url . $endpoint);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }

    /**
     * Obtener headers para la petición
     */
    private function getHeaders()
    {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: Juvenil-App/1.0'
        ];

        if (!empty($this->token)) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        return $headers;
    }

    /**
     * Manejar la respuesta de la API
     */
    private function handleResponse($response, $http_code, $error, $autoRedirect = true)
    {
        // Error de conexión
        if ($error) {
            return [
                'success' => false,
                'error' => 'Error de conexión: ' . $error,
                'http_code' => 0,
                'data' => null
            ];
        }

        // Intentar decodificar JSON
        $data = null;
        if (!empty($response)) {
            $data = json_decode($response, true);
        }

        // Success (2xx)
        if ($http_code >= 200 && $http_code < 300) {
            return [
                'success' => true,
                'data' => $data,
                'error' => null,
                'http_code' => $http_code
            ];
        }

        // Unauthorized (401) - redirigir a login
        if ($http_code == 401 && $this->token && $autoRedirect) {
            Session::destroy();
            header('Location: ' . BASE_URL . '/index.php?sw=2');
            exit();
        }

        // Extraer mensaje de error
        $errorMessage = $this->extractErrorMessage($data, $http_code);

        return [
            'success' => false,
            'error' => $errorMessage,
            'http_code' => $http_code,
            'data' => null
        ];
    }

    /**
     * Extraer mensaje de error de la respuesta
     */
    private function extractErrorMessage($data, $http_code)
    {
        // Si data es array
        if (is_array($data)) {
            // Intentar obtener mensaje
            if (isset($data['message'])) {
                $msg = $data['message'];
                // Si es array, unir con comas
                if (is_array($msg)) {
                    return implode(', ', array_filter((array)$msg));
                }
                return $msg;
            }

            // Intentar obtener error
            if (isset($data['error'])) {
                return $data['error'];
            }

            // Intentar obtener status
            if (isset($data['status'])) {
                return $data['status'];
            }
        }

        // Mensaje por código HTTP
        $mensajesPorCodigo = [
            400 => 'Solicitud inválida. Verifique los datos enviados.',
            401 => 'No autorizado. Debe iniciar sesión.',
            403 => 'Acceso denegado.',
            404 => 'El recurso solicitado no fue encontrado.',
            409 => 'Conflicto en la solicitud.',
            422 => 'Error de validación en los datos.',
            429 => 'Demasiadas solicitudes. Intente más tarde.',
            500 => 'Error interno del servidor.',
            502 => 'Puerta de enlace incorrecta. Intente más tarde.',
            503 => 'Servicio no disponible. Intente más tarde.',
        ];

        return $mensajesPorCodigo[$http_code] ?? 'Error desconocido (HTTP ' . $http_code . ')';
    }

    /**
     * Obtener el código de error actual
     */
    public function getLastErrorCode()
    {
        return $this->lastErrorCode ?? 0;
    }
}