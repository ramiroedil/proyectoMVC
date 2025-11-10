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
        $this->base_url = API_BASE_URL;
        $this->timeout = API_TIMEOUT;
        $this->token = Session::get('token');
    }

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

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }
public function post($endpoint, $data = [], $files = [])
    {
        $ch = curl_init($this->base_url . $endpoint);

        if (!empty($files)) {
            $postData = $data;
            foreach ($files as $key => $file) {
                if (isset($file['tmp_name']) && file_exists($file['tmp_name'])) {
                    $postData[$key] = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
                }
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->token
            ]);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }

    /**
     * PUT request
     */
    public function put($endpoint, $data = [])
    {
        $ch = curl_init($this->base_url . $endpoint);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }

    /**
     * PATCH request
     */
    public function patch($endpoint, $data = [])
    {
        $ch = curl_init($this->base_url . $endpoint);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }

    /**
     * DELETE request
     */
    public function delete($endpoint)
    {
        $ch = curl_init($this->base_url . $endpoint);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
    }

    /**
     * Headers por defecto
     */
    private function getHeaders()
    {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        if ($this->token) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        return $headers;
    }

    /**
     * Manejar respuesta de API
     */
    private function handleResponse($response, $http_code, $error)
    {
        if ($error) {
            return [
                'success' => false,
                'error' => 'Error de conexión: ' . $error,
                'data' => null
            ];
        }

        $data = json_decode($response, true);

        // Success (2xx)
        if ($http_code >= 200 && $http_code < 300) {
            return [
                'success' => true,
                'data' => $data,
                'error' => null
            ];
        }

        // Unauthorized (401)
        if ($http_code == 401) {
            Session::destroy();
            header('Location: ../inicio_sesion.php?sw=2');
            exit();
        }

        // Other errors
        $errorMessage = 'Error desconocido';
        if (isset($data['message'])) {
            $errorMessage = is_array($data['message']) ? implode(', ', $data['message']) : $data['message'];
        }

        return [
            'success' => false,
            'error' => $errorMessage,
            'data' => null
        ];
    }
}
