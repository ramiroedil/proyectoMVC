<?php
class ApiClientPublic
{
    private $base_url;
    private $timeout;

    public function __construct()
    {
        $this->base_url = API_BASE_URL;
        $this->timeout = API_TIMEOUT;
    }

    /**
     * GET request sin autenticación
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return $this->handleResponse($response, $http_code, $error);
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
?>