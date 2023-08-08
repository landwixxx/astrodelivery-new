/* Limitar string */
function strLimit(str, limit = 50) {
    if (str == null)
        return '';
    if (str.length > limit)
        return str.substr(0, limit) + '...'
    return str;
}

function moeda(valor) {
    let resultado = parseFloat(valor).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
    return resultado;
}

/* Alternar loja abeta ou fechada */
if (document.querySelector('#alternar-loja-aberta')) {
    document.querySelector('#alternar-loja-aberta').onchange = function () {
        if (this.checked) {
            document.querySelector('#alternar-empresa-aberto').value = 'sim'
        } else {
            document.querySelector('#alternar-empresa-aberto').value = 'nao'
        }
        document.querySelector('#form-alternar-empresa-aberto').submit()
    }
}
