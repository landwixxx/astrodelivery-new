<?php

namespace App\Traits;

use App\Models\ShopkeeperToken;

trait StoreApi
{
    /**
     * Retorna dados da loja
     *
     * @param  mixed $token
     * @return null|object
     */
    public static function get($token = null): ?object
    {
        $shopkeeperToken = ShopkeeperToken::where('token', $token)->first();
        if ($shopkeeperToken != null)
            if ($shopkeeperToken->lojista->store != null)
                return $shopkeeperToken->lojista->store;

        return null;
    }
}
