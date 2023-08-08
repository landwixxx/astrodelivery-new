<?php

use Hamcrest\Type\IsNumeric;

/**
 * Conveter string moeda para número decimal
 *
 * @param  string $str Ex: R$ 1.999,99
 * @return float
 */
function currency_to_decimal(string $str = '0'): float
{
    $result = floatval(str_replace(['R$', '.', ',', ' '], ['', '', '.', ''], $str));
    return $result;
}

function currency_format($number): string
{
    return  'R$ ' . number_format($number, 2, ',', '.');
}

function currency($number): string
{
    return  number_format($number, 2, ',', '.');
}

/**
 * Obter quantidade de estoque de produto ou adicional contando os que estão na session do carrinho
 *
 * @param  mixed $produto_id
 * @return int total em estoque subtrarindo oque já foi add no carrinho
 */
function obterQtdEstoque($produto_id): int
{
    $produto = \App\Models\Product::find($produto_id);
    $estoque = $produto->estoque;

    if (session()->has('items_cart')) :
        $itens = session('items_cart');
        foreach ($itens as $keyItem => $item) {

            // se item estiver no carrinho vai subtrar o valor do estoque
            if ($item['product_id'] == $produto->id) {
                $estoque -= intval($item['qtd_item']);
            }

            if (isset($item['additionals'])) {
                $adicionais = $item['additionals'];
                foreach ($adicionais as $keyAd => $ad) {
                    // se adicional estiver no carrinho vai subtrar o valor do estoque
                    if ($ad['additional_id'] == $produto->id) {
                        $estoque -= intval($ad['qtd_item']);
                    }
                }
            }
        }
    endif;

    $estoque = $estoque < 0 ? 0 : $estoque;
    // dd($estoque);

    return $estoque ?? 0;
    // return  
}
