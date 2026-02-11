<?php

namespace App\Services;

use RouterOS\Client;
use Exception;

class MikrotikService
{
    public static function createSecret($router, $user, $pass, $profile)
    {

        try {
            $client = new Client([
                'host' => $router->ip_address,
                'user' => $router->username,
                'pass' => $router->password, 
                'port' => (int) $router->port,
                'timeout' => 3, 
            ]);
        } catch (Exception $e) {
            throw new Exception("Gagal Konek ke Mikrotik: " . $e->getMessage());
        }

        $cek = $client->query('/ppp/secret/print')
            ->where('name', $user)
            ->read();

        if (!empty($cek)) {
            throw new Exception("Username PPPoE '$user' sudah ada di Mikrotik!");
        }

        $client->query('/ppp/secret/add')
            ->equal('name', $user)
            ->equal('password', $pass)
            ->equal('profile', $profile)
            ->equal('service', 'pppoe') 
            ->write();
            
        return true;
    }
}