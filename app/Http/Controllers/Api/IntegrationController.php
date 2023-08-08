<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegrationController extends Controller
{
    /**
     * Associação de controllers e métodos para os modulos
     *
     * @var array
     */
    protected $dataForModules = [
        // o primeiro indice é o nome do módulo
        'token' => [
            'controller' => 'ApiTokenController',
            'methods' => [
                'verificarToken',
            ],
        ],
        'empresa' => [
            'controller' => 'CompanyApiController',
            'methods' => [
                'retornarEmpresa',
                'gravar'
            ],
        ],
        'formaPgto' => [
            'controller' => 'PaymentMethodApiController',
            'methods' => [
                'consultar',
                'gravar'
            ],
        ],
        'categoria' => [
            'controller' => 'CategoryApi',
            'methods' => [
                'consultar',
                'gravar'
            ],
        ],
        'pedido' => [
            'controller' => 'OrderApiController',
            'methods' => [
                'consultarPedidoInterno',
                'atualizarIntegradoPedido',
                'atualizarPedido'
            ],
        ],
        'tipoEntrega' => [
            'controller' => 'DeliveryTypeApiController',
            'methods' => [
                'consultar',
                'gravar',
                'consultarEntregaPagamento',
                'gravarEntregaPagamento',
                'consultarEntregaCep',
                'gravarEntregaCep',
                'gravarEntregaMesa',
                'consultarEntregaMesa'
            ],
        ],
        'produto' => [
            'controller' => 'ProductsApiController',
            'methods' => [
                'consultar',
                'gravar',
                'gravarProdutoAnexo',
                'excluirProdutoAnexo',
                'gravarGrupoAdicional',
                'excluirGrupoAdicional',
                'excluirProdutoAdicional',
                'gravarProdutoAdicional',
                'pesquisarProdutoAdicional'
            ],
        ],
    ];

    protected $method = null; // Método para ser executar no controller
    protected $token = null;
    protected $company = null;
    protected $module = null;
    protected $userProfile = null;

    public function run(Request $request)
    {
        $this->setDataAttributes($request);

        if (!$this->checkModuleExists())
            return response()->json(['erro' => 'O modulo informado não foi encontrado'], 400);

        if (!$this->checkMethodExists())
            return response()->json(['erro' => 'A função informada não foi encontrada'], 400);

        if (!$this->checkMethodExistsController())
            return response()->json(['erro' => 'A função informada não pertence ao modulo'], 400);

        /**
         * Executar cotroller relacionado ao modulo e executar o método que tem o mesmo nome da função 
         * passada no header 
         */
        return $this->runControllerMethod($request);
    }

    public function setDataAttributes($request)
    {
        // Adicionar atributos
        $this->token = $request->header('token');
        $this->company = $request->header('empresa');
        $this->method = lcfirst($request->header('funcao'));
        $this->module = $request->header('modulo');
        $this->userProfile = $request->header('usuario');
    }

    /**
     * Executar controller e métodos baseados nos parâmetros 'modulo' e 'função' enviados no cabeçalho/header
     *
     * @return void
     */
    public function runControllerMethod($request)
    {
        $controllerNameClass = $this->dataForModules[$this->module]['controller'];

        $controllerClass = "\\App\\Http\\Controllers\\Api\\" . $controllerNameClass;
        $controllerInstance = app($controllerClass);

        // Executar método do controller 
        $method = $this->method;

        return $controllerInstance->$method($request); // é obrigatório passar o '$request' como parâmetro
    }

    public function checkMethodExists(): bool
    {
        foreach ($this->dataForModules as $key =>  $module) {
            if ($key == $this->module) { // verifica métodos apenas no modulo informado
                // se método existe no modulo
                if (isset($module['methods']) && in_array($this->method, $module['methods']))
                    return true;
            }
        }
        return false;
    }

    public function checkModuleExists(): bool
    {
        return array_key_exists($this->module, $this->dataForModules);
    }

    /**
     * Verificar se o método ('função') informado na requisição pertence ao controller do modulo
     *
     * @return bool
     */
    public function checkMethodExistsController(): bool
    {
        $controllerNameClass = $this->dataForModules[$this->module]['controller'];
        $controllerClass = "\\App\\Http\\Controllers\\Api\\" . $controllerNameClass;
        $classe = new \ReflectionClass($controllerClass);

        if ($classe->hasMethod($this->method))
            return true;

        return false;
    }
}
