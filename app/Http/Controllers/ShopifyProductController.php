<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $shop = env('SHOPIFY_SHOP_DOMAIN');
        $token = env('SHOPIFY_ACCESS_TOKEN');

        if (!$shop || !$token) {
            Log::error('Shopify API Credentials missing.');
            return response()->json(['error' => 'API no configurada'], 500);
        }

        try {
            // Obtener todos los productos y cachearlos por 1 hora para búsqueda súper rápida
            $products = cache()->remember('shopify_products', 3600, function () use ($shop, $token) {
                $response = Http::withHeaders([
                    'X-Shopify-Access-Token' => $token
                ])->get("https://{$shop}/admin/api/2024-01/products.json", [
                    'limit' => 250,
                    'fields' => 'id,title,variants,image'
                ]);

                if ($response->successful()) {
                    return collect($response->json()['products'])->map(function ($product) {
                        $variant = $product['variants'][0] ?? null;
                        return [
                            'id' => $product['id'],
                            'title' => $product['title'],
                            'sku' => $variant ? $variant['sku'] : null,
                            'image' => $product['image']['src'] ?? null,
                        ];
                    })->toArray();
                }
                
                throw new \Exception('Failed to fetch from Shopify API');
            });

            if (empty($products)) {
                return response()->json([]);
            }

            // Filtrar localmente ignorando mayúsculas y acentos
            $queryNormalized = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $query));
            
            $filtered = collect($products)->filter(function ($product) use ($queryNormalized) {
                $titleNormalized = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $product['title']));
                $skuNormalized = strtolower($product['sku'] ?? '');
                
                return str_contains($titleNormalized, $queryNormalized) || str_contains($skuNormalized, $queryNormalized);
            })->take(10)->values();

            return response()->json($filtered);

            Log::error('Shopify API Error', ['response' => $response->body()]);
            return response()->json([], 500);

        } catch (\Exception $e) {
            Log::error('Shopify API Exception', ['message' => $e->getMessage()]);
            return response()->json([], 500);
        }
    }
}
