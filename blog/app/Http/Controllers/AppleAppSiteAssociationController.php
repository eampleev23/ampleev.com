<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AppleAppSiteAssociationController extends Controller
{
    /**
     * Отдача файла apple-app-site-association для Universal Links
     * 
     * Файл должен быть доступен по адресу:
     * https://pointscounter.ampleev.com/.well-known/apple-app-site-association
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'applinks' => [
                'apps' => [],
                'details' => [
                    [
                        'appID' => '4XT2YYJHT5.com.ampleev.CheepCounter',
                        'paths' => ['/*']
                    ]
                ]
            ]
        ], 200, [
            'Content-Type' => 'application/json',
            'Cache-Control' => 'public, max-age=3600'
        ]);
    }
}
