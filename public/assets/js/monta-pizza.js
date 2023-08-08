
/* dividir o valor do sabor pelo total de sabor selecionado */
function atualizarTextValorSaboresDividido() {

    let totalCheckboxSelecionados = 0
    let radios = document.getElementsByName('sabores_id_nao_utilizar[]');
    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            // bordasSelecionadas.push(radios[i].value)
            totalCheckboxSelecionados++
        }
    }

    if (totalCheckboxSelecionados == 0)
        return;


    for (let i = 0; i < radios.length; i++) {
        let valorDividido = parseFloat(radios[i].dataset.valor) / totalCheckboxSelecionados;

        // console.log(valorDividido + ' ---');

        valorDividido = parseFloat(valorDividido.toFixed(2));
        let porcentagem = parseInt((100 / totalCheckboxSelecionados) * 1)
        let textPorcentagem = totalCheckboxSelecionados > 1 ? ` - ${porcentagem}%` : ''
        let vFormatSabor = parseFloat(valorDividido).toLocaleString('pt-br', {
            minimumFractionDigits: 2
        });
        document.getElementById('v-sabor-' + radios[i].value).innerText = vFormatSabor + textPorcentagem;

    }
}

function setValorTotal() {
    let valor = 0
    let valorDividido = 0;
    saboresSelecionados.forEach(item => {

        /* dividir o valor do sobar pelo total de sabores selecionados */
        let totalCheckboxSelecionados = 0
        let radios = document.getElementsByName('sabores_id_nao_utilizar[]');
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                totalCheckboxSelecionados++
            }
        }
        // valorDividido = parseFloat(sabores[item].valor) / (totalCheckboxSelecionados == 0 ? 1 : totalCheckboxSelecionados);
        valorDividido = parseFloat(sabores[item].valor) / (saboresSelecionados.length == 0 ? 1 : saboresSelecionados.length);
        /*  */

        valor = valor + valorDividido

    });

    atualizarTextValorSaboresDividido()

    valor = valor + valorBordas
    valor = valor + valorTamanho
    valor = valor + valorAdicionais
    valor = parseFloat(valor).toFixed(2)
    document.getElementById('valor-total').innerHTML = parseFloat(valor).toLocaleString('pt-br', {
        minimumFractionDigits: 2
    });
}