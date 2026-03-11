<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

class ApiClient
{
    protected string $baseUrl;
    protected ?string $token = null;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.api.url', 'http://localhost:8000/api/v1');
        $this->timeout = config('services.api.timeout', 30);
    }

    /**
     * Set authentication token
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get token from session
     */
    public function withSessionToken(): self
    {
        $this->token = session('api_token');
        return $this;
    }

    /**
     * Create HTTP request builder
     */
    protected function request(): \Illuminate\Http\Client\PendingRequest
    {
        $request = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->timeout($this->timeout);

        if ($this->token) {
            $request->withToken($this->token);
        }

        return $request;
    }

    /**
     * GET request
     */
    public function get(string $endpoint, array $params = []): array
    {
        try {
            $response = $this->request()->get($endpoint, $params);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleError($e);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * POST request
     */
    public function post(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->request()->post($endpoint, $data);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleError($e);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * PUT request
     */
    public function put(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->request()->put($endpoint, $data);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleError($e);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * PATCH request
     */
    public function patch(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->request()->patch($endpoint, $data);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleError($e);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * DELETE request
     */
    public function delete(string $endpoint): array
    {
        try {
            $response = $this->request()->delete($endpoint);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleError($e);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Handle successful response
     */
    protected function handleResponse(Response $response): array
    {
        $data = $response->json();

        if ($response->successful()) {
            return $data ?? ['success' => true];
        }

        return [
            'success' => false,
            'message' => $data['message'] ?? 'API request failed',
            'errors' => $data['errors'] ?? null,
            'status' => $response->status(),
        ];
    }

    /**
     * Handle request error
     */
    protected function handleError(\Exception $e): array
    {
        return [
            'success' => false,
            'message' => 'API connection error: ' . $e->getMessage(),
            'errors' => null,
            'status' => 500,
        ];
    }
}
