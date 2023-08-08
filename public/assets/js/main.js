

/* Aceitar Cookies */
if (localStorage.getItem('aceitar_cookies') != null) {
    document.querySelector('#div-aceitar-cookies').style.display = 'none';
}
document.querySelector('#aceitar-cookies').onclick = function () {
    localStorage.setItem('aceitar_cookies', 1)
    document.querySelector('#div-aceitar-cookies').className = "fixed-bottom text-white opacity-0"
}

/* formatar moeda */
function moeda(valor) {
    let resultado = parseFloat(valor).toLocaleString('pt-br', { minimumFractionDigits: 2 });
    return resultado;
}