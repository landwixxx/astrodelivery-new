<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardShopkeeperController extends Controller
{
    protected $chart;
    protected $months = [
        '01' => 'Jan',
        '02' => 'Fev',
        '03' => 'Mar',
        '04' => 'Abr',
        '05' => 'Mai',
        '06' => 'Jun',
        '07' => 'Jul',
        '08' => 'Ago',
        '09' => 'Set',
        '10' => 'Out',
        '11' => 'Nov',
        '12' => 'Dez'
    ];

    public function __construct(LarapexChart $chart)
    {
        $this->middleware(['auth', 'role:lojista|funcionario']);
        $this->chart = $chart;
    }

    public function index()
    {

        $store_id = null;
        if (!is_null(auth()->user()->store_has_user))
            $store_id = auth()->user()->store_has_user->store_id;

        $totalProdutos = Product::where('store_id', $store_id)
            ->where('ativo', 'S')
            ->where('tipo', '!=', 'ADICIONAL')
            ->count();

        $totalCategorias = Category::where('store_id', $store_id)
            ->where('ativo', 'S')
            ->count();

        $totalClientes = User::where('profile', 'cliente')
            ->where('status', 'ativo')
            ->whereHas('store_has_customer', function ($query) use ($store_id) {
                return $query->where('store_id', $store_id);
            })
            ->count();

        $data = [
            'totalProdutos' => $totalProdutos,
            'totalCategorias' => $totalCategorias,
            'totalClientes' => $totalClientes,
            'chartVendas' => $this->chartVendas7dias(),
            'chartVendasMes' => $this->chartVendasUltimoMes(),
            'chartVendas12meses' => $this->chartVendas12meses(),
            'totalPedidosPendentes' => Order::where('store_id', $store_id)->where('order_status_id', 1)->count(),
            'totalPedidosAceitos' => Order::where('store_id', $store_id)->whereIn('order_status_id', [2, 3, 4, 5, 7])->count(),
            'totalPedidosEntregues' => Order::where('store_id', $store_id)->whereIn('order_status_id', [5, 7])->count(),
            'totalPedidosRecusados' => Order::where('store_id', $store_id)->whereIn('order_status_id', [6])->count(),
            'valorFaturamento' => Order::where('store_id', $store_id)
                ->withTrashed()
                ->where('situacao_pgto', 'PAGO')
                ->where('order_status_id', 7)
                ->sum('total_pedido'),
            'pedidosPendentes' => Order::where('store_id', $store_id)->where('order_status_id', 1)->oldest()->limit(5)->get(),
        ];

        return view('painel.lojista.home', $data);
    }

    public function chartVendas7dias()
    {
        $diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        $data = ['dia' => [], 'valores' => []];
        $store_id = isset(auth()->user()->store_has_user->store->id) ? auth()->user()->store_has_user->store->id : 0;

        for ($i = 0; $i <= 6; $i++) {
            $dia = date('w', strtotime(" - $i days"));
            array_unshift($data['dia'], $diasSemana[$dia]);

            $valor = Order::where('order_status_id', 7)
                ->where('store_id', $store_id)
                ->whereDate('created_at', now()->subDays($i))
                ->withTrashed()->count();

            array_unshift($data['valores'], $valor);
        }

        $chartVendas = $this->chart->barChart()
            ->setTitle('Vendas em 7 dias')
            ->setToolbar(true)
            ->setXAxis($data['dia'])
            ->setDataset([[
                'name'  =>  'Vendas',
                'data'  =>  $data['valores']
            ]])
            ->setDataLabels(true)
            ->setColors(['#9155f9', '#ff6384'])
            ->setHeight(315);

        return $chartVendas;
    }

    public function chartVendasUltimoMes()
    {
        $meses = $this->months;
        $store_id = isset(auth()->user()->store_has_user->store->id) ? auth()->user()->store_has_user->store->id : 0;

        $year = date('Y', strtotime(date('Y-m-15') . " - 1 months"));
        $monthPrevious = date('m', strtotime(date('Y-m-15') . " - 1 months"));
        $daysTotalMonth = date('t', strtotime(date('Y-m-15') . " - 1 months"));

        $data = ['dias' => [], 'valores' => []];

        for ($i = 1; $i <= $daysTotalMonth; $i++) {

            $day = $i < 10 ? "0$i" : $i;
            $date = "$year-$monthPrevious-$day";

            array_push($data['dias'], $day . '/' . $meses[$monthPrevious]);

            $valor = Order::where('order_status_id', 7)
                ->where('store_id', $store_id)
                ->whereDate('created_at', $date)
                ->withTrashed()->count();

            array_push($data['valores'], $valor);
        }

        $chartVendasMes = $this->chart->barChart()
            ->setTitle('Vendas no último mês')
            ->setToolbar(true)
            ->setXAxis($data['dias'])
            ->setDataset([
                [
                    'name'  =>  'Vendas',
                    'data'  =>  $data['valores']
                ],
            ])
            ->setColors(['#9155f9', '#ff6384'])
            ->setHeight(315);

        return $chartVendasMes;
    }

    public function chartVendas12meses()
    {
        $data = ['meses' => [], 'valores' => []];
        $store_id = isset(auth()->user()->store_has_user->store->id) ? auth()->user()->store_has_user->store->id : 0;

        for ($i = 0; $i <= 11; $i++) {
            $yearCurrent = date('Y', strtotime(date('Y-m-15') . " - $i months"));
            $monthCurrent = date('m', strtotime(date('Y-m-15') . " - $i months"));

            $data['meses'][] = $this->months[$monthCurrent] . '/' . $yearCurrent;

            $data['valores'][] = Order::where('order_status_id', 7)
                ->where('store_id', $store_id)
                ->whereYear('created_at', $yearCurrent)
                ->whereMonth('created_at', $monthCurrent)
                ->withTrashed()->count();
        }

        $chartCliente12meses = $this->chart->areaChart()
            ->setTitle('Vendas nos últimos 12 meses')
            ->setToolbar(true)
            ->setDataLabels(true)
            ->setXAxis(array_reverse($data['meses']))
            ->setDataset([
                [
                    'name'  =>  'Vendas',
                    'data'  =>  array_reverse($data['valores'])
                ]
            ])
            ->setColors(['#feb019'])
            ->setHeight(250)
            ->setGrid();

        return $chartCliente12meses;
    }
}
