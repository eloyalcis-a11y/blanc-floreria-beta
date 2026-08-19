<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyAuthController extends Controller
{
    public function install(Request $request)
    {
        $shop = env('SHOPIFY_SHOP_DOMAIN');
        $clientId = env('SHOPIFY_CLIENT_ID');
        $scopes = 'read_products';
        $redirectUri = urlencode(route('shopify.callback'));
        
        // Random state for security
        $state = bin2hex(random_bytes(16));
        session(['shopify_state' => $state]);

        // Eliminamos redirectUri para forzar que Shopify use el dominio por defecto (example.com)
        $installUrl = "https://{$shop}/admin/oauth/authorize?client_id={$clientId}&scope={$scopes}&state={$state}";

        return redirect($installUrl);
    }

    public function callback(Request $request)
    {
        $shop = env('SHOPIFY_SHOP_DOMAIN');
        $clientId = env('SHOPIFY_CLIENT_ID');
        $clientSecret = env('SHOPIFY_CLIENT_SECRET');

        $code = $request->query('code');
        $state = $request->query('state');

        // Verify state
        if ($state !== session('shopify_state')) {
            return response('Invalid state parameter', 403);
        }

        // Request permanent access token
        $response = Http::post("https://{$shop}/admin/oauth/access_token", [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];

            Log::info('Shopify Access Token Obtenido Correctamente: ' . substr($accessToken, 0, 10) . '...');
            
            // Update .env with the new access token
            $envPath = base_path('.env');
            $envContent = file_get_contents($envPath);
            if (strpos($envContent, 'SHOPIFY_ACCESS_TOKEN=') !== false) {
                $envContent = preg_replace('/SHOPIFY_ACCESS_TOKEN=.*/', 'SHOPIFY_ACCESS_TOKEN="' . $accessToken . '"', $envContent);
            } else {
                $envContent .= "\nSHOPIFY_ACCESS_TOKEN=\"{$accessToken}\"\n";
            }
            file_put_contents($envPath, $envContent);

            return "¡Éxito! Aplicación instalada y token de acceso guardado en .env. Ya puedes regresar a tu panel de Blanc Florería y cerrar esta ventana.";
        }

        Log::error('Shopify OAuth Error', ['response' => $response->body()]);
        return response('Error obtaining access token: ' . $response->body(), 500);
    }
}
