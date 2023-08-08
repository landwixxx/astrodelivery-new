
/* Variáveis */
var valor_original_produto = 0;
var total_quantidade_produto_somado = 1;

/* formatar moeda */
function moeda(valor) {
    let resultado = parseFloat(valor).toLocaleString('pt-br', { minimumFractionDigits: 2 });
    return resultado;
}

/**
 * Conveter moeda em número
 * @param {*} str_valor  Ex: R$ 1.999,99
 * @returns float Ex: 1999.99
 */
function fmt_moeda_em_numero(str_valor) {
    let resultado = str_valor.replace('.', '').replace(' ', '').replace(' ', '').replace(' ', '').replace(' ', '').replace('R$', '').replace('R$', '')
        .replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace(',', '.')
    return parseFloat(resultado);
}

// Adicionar valor original do produto
if (document.querySelector('#preco-produto')) {
    let valor = document.querySelector('#preco-produto').innerText
    valor_original_produto = fmt_moeda_em_numero(valor)
}

/* Fechar modal com previa de imagem */
function fecharPreviaIMG() {
    document.getElementById('modal-exibir-img').classList.remove('d-flex')
    document.getElementById('modal-exibir-img').classList.add('d-none')
}

/* Abrir previa da img do produto para visualizar a img melhor */
function abrirPreviaIMG(el_img) {
    document.getElementById('modal-exibir-img').classList.remove('d-none')
    document.getElementById('modal-exibir-img').classList.add('d-flex')
    document.getElementById('exibir-img-modal').src = el_img.src
}

function setImg(el_img) {
    console.log(el_img)
    document.querySelector('#modal-img-produto').src = el_img.src

    let div_img = document.querySelectorAll('.mini-img-produto')
    for (let i in div_img) {
        div_img[i].className = 'border p-1 mini-img-produto'
        // div_img[i].className = ''
    }
    el_img.parentNode.className = 'border p-1 mini-img-produto border-primary'
}

// /* Adicionar dados do produto ao modal */
// function setDataProduct(dataProduct) {
//     // imagem principal
//     let url_img = null
//     if (dataProduct.image.length == 0) {
//         url_img = "/assets/img/img-prod-vazio.png";
//     } else {
//         url_img = "/storage/public/products/" + dataProduct.image[0].end_imagem
//     }
//     console.log(dataProduct)
//     // dados
//     document.querySelector('#modal-img-produto').src = url_img
//     document.querySelector('#modal-titulo-produto').innerText = dataProduct.nome
//     document.querySelector('#modal-descricao-produto').innerText = dataProduct.descricao
//     document.querySelector('#modal-id-produto').value = dataProduct.id

//     // miniatura de imagens
//     let el_imagens = document.querySelector('#imagens-produto-selecionado')
//     el_imagens.innerHTML = '';
//     let array_imgs = dataProduct.image;

//     for (let i in array_imgs) {
//         el_imagens.innerHTML += `
//             <div class="col-3 p-1">
//                 <div class="border p-1 mini-img-produto">
//                     <img src="/storage/public/products/${array_imgs[i].end_imagem}" alt="" class="w-100" 
//                         onmouseenter="setImg(this)" onclick="abrirPreviaIMG(this)" style="cursor:pointer">
//                 </div>
//             </div>
//         `
//     }

// }


/* Adicionais */
function add_adicional(id, preco, estoque = 0) {

    // preço do adicional multiplicado pela quantidade  de produto somado
    // tipo, se add a qtd de 2 produtos, o valor do adicional tbm multiplica
    preco = total_quantidade_produto_somado * preco;

    let input = '#qtd-id_' + id
    let quantidade = document.querySelector(input).value

    // limitar estoque
    if(parseInt(quantidade) >= estoque) {
        document.querySelector(input).value= estoque
        return;
    }

    let adicionar = Number(quantidade) + 1
    document.querySelector(input).value = adicionar
    let valor_produto = document.querySelector('#preco-produto').innerText
    valor_produto = fmt_moeda_em_numero(valor_produto)
    valor_atual = valor_produto + preco

    document.querySelector('#preco-produto').innerText = moeda(valor_atual)

    // 
}

function remove_adicional(id, preco) {

    // preço do adicional multiplicado pela quantidade  de produto somado
    // tipo, se add a qtd de 2 produtos, o valor do adicional tbm multiplica
    preco = total_quantidade_produto_somado * preco;

    let input = '#qtd-id_' + id
    let quantidade = document.querySelector(input).value
    if (Number(quantidade) > 0) {
        let adicionar = Number(quantidade) - 1
        document.querySelector(input).value = adicionar
        let valor_produto = document.querySelector('#preco-produto').innerText
        valor_produto = fmt_moeda_em_numero(valor_produto)
        valor_atual = valor_produto - preco

        document.querySelector('#preco-produto').innerText = moeda(valor_atual)

        //
    }
}

/* Produto */
function add_produto() {

    // limite de estoque
    let limite_estoque = document.getElementById('limit-estoque-produto').value
    limite_estoque = limite_estoque == '' ? 0 : parseFloat(limite_estoque);

    let quantidade = document.querySelector('#qtd_produto').value
    if (parseInt(quantidade) >= limite_estoque) {
        document.querySelector('#qtd_produto').value = limite_estoque
        return;
    }


    let adicionar = Number(quantidade) + 1
    document.querySelector('#qtd_produto').value = adicionar

    let valor_atual = document.querySelector('#preco-produto').innerText
    valor_atual = fmt_moeda_em_numero(valor_atual)

    let valor_somar = valor_atual / total_quantidade_produto_somado
    let novo_valor = valor_atual + valor_somar;

    document.querySelector('#preco-produto').innerText = moeda(novo_valor)

    total_quantidade_produto_somado++;
}

function rem_produto() {
    let quantidade = document.querySelector('#qtd_produto').value
    if (Number(quantidade) > 1) {


        let adicionar = Number(quantidade) - 1
        document.querySelector('#qtd_produto').value = adicionar
        let valor_produto = document.querySelector('#preco-produto').innerText
        valor_produto = fmt_moeda_em_numero(valor_produto)

        valor_subtrair = valor_produto / total_quantidade_produto_somado;

        // console.log(valor_produto, total_quantidade_produto_somado)
        // console.log(valor_subtrair)

        valor_atual = valor_produto - valor_subtrair;
        // console.log(valor_atual)

        document.querySelector('#preco-produto').innerText = moeda(valor_atual)

        // 
        total_quantidade_produto_somado--;

    }
}


function add_sabor(id) {
    let input = '#qtd-id_' + id
    let quantidade = document.querySelector(input).value
    let adicionar = Number(quantidade) + 1
    document.querySelector(input).value = adicionar
}

function remove_sabor(id) {
    let input = '#qtd-id_' + id
    let quantidade = document.querySelector(input).value
    if (Number(quantidade) > 0) {
        let adicionar = Number(quantidade) - 1
        document.querySelector(input).value = adicionar
    }
}

/**
 * Fechar modal loja fechada
 */
function setCookieLojaFechada() {
    let d = new Date();
    let min = 5
    d.setTime(d.getTime() + ((60 * 1000) * min));
    // d.setTime(d.getTime() + 0);
    let expires = "expires=" + d.toUTCString();
    document.cookie = "loja_fechada=true;" + expires + ";path=/";
}
if (document.querySelector('#fechar-modal-loja-fechada'))
    document.querySelector('#fechar-modal-loja-fechada').onclick = function () {
        setCookieLojaFechada();
    }
if (document.cookie.indexOf('loja_fechada=true') != -1)
    setCookieLojaFechada();