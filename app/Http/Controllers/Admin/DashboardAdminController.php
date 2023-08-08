<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\TestOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardAdminController extends Controller
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
        $this->middleware(['auth', 'role:admin']);
        $this->chart = $chart;
    }

    public function index()
    {
        return view('painel.admin.home', [
            'totalLojistas' => User::where('profile', 'lojista')->doesntHave('test_order')->count(),
            'totalCliente' => User::where('profile', 'cliente')->count(),
            'totalProdutos' => Product::count(),
            'totalVendas' => Order::where('order_status_id', 7)->withTrashed()->count(),
            'listaLojistas' => User::where('profile', 'lojista')->doesntHave('test_order')->latest()->limit(5)->get(),
            'chartVendas' => $this->chartVendas7dias(),
            'chartUsuarios' => $this->chartUsuarios(),
            'chartVendasMes' => $this->chartVendasUltimoMes(),
            'chartPedidosMes' =>  $this->chartPedidosMes(),
            'chartCliente12meses' => $this->chartCliente12meses()
        ]);
    }

    public function chartUsuarios()
    {
        $chartUsuarios =  $this->chart->pieChart()
            ->setTitle('Usuários')
            ->setToolbar(true)
            ->setDataset([
                User::where('profile', 'lojista')->doesntHave('test_order')->count(),
                User::where('profile', 'cliente')->count()
            ])
            ->setLabels(['Lojistas', 'Clientes'])
            ->setColors(['#feb019', '#00a9f4'])
            ->setSparkline()
            ->setHeight(245);

        return $chartUsuarios;
    }

    public function chartCliente12meses()
    {
        $data = ['meses' => [], 'valores' => []];

        for ($i = 0; $i <= 11; $i++) {
            $yearCurrent = date('Y', strtotime(date('Y-m-15') . " - $i months"));
            $monthCurrent = date('m', strtotime(date('Y-m-15') . " - $i months"));

            $data['meses'][] = date('M/Y', strtotime(date('Y-m-15') . " - $i months"));
            $data['valores'][] = User::where('profile', 'cliente')
                ->whereYear('created_at', $yearCurrent)
                ->whereMonth('created_at', $monthCurrent)
                ->count();
        }

        $chartCliente12meses = $this->chart->areaChart()
            ->setTitle('Clientes cadastrado nos últimos 12 meses')
            ->setToolbar(true)
            ->setDataLabels(true)
            ->setXAxis(array_reverse($data['meses']))
            ->setDataset([
                [
                    'name'  =>  'Lojistas',
                    'data'  =>  array_reverse($data['valores'])
                ]
            ])
            ->setColors(['#feb019'])
            ->setHeight(250)
            ->setGrid();

        return $chartCliente12meses;
    }

    public function chartVendas7dias()
    {
        $diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        $data = ['dia' => [], 'valores' => []];

        for ($i = 0; $i <= 6; $i++) {

            $dia = date('w', strtotime(" - $i days"));
            array_unshift($data['dia'], $diasSemana[$dia]);

            $valor = Order::where('order_status_id', 7)
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
            ->setColors(['#775dd0', '#ff6384'])
            ->setHeight(315);

        return $chartVendas;
    }

    public function chartVendasUltimoMes()
    {
        $meses = $this->months;

        $year = date('Y', strtotime(date('Y-m-15') . " - 1 months"));
        $monthPrevious = date('m', strtotime(date('Y-m-15') . " - 1 months"));
        $daysTotalMonth = date('t', strtotime(date('Y-m-15') . " - 1 months"));

        $data = ['dias' => [], 'valores' => []];

        for ($i = 1; $i <= $daysTotalMonth; $i++) {

            $day = $i < 10 ? "0$i" : $i;
            $date = "$year-$monthPrevious-$day";

            array_push($data['dias'], $day . '/' . $meses[$monthPrevious]);

            $valor = Order::where('order_status_id', 7)
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
            ->setColors(['#775dd0', '#ff6384'])
            ->setHeight(315);

        return $chartVendasMes;
    }

    public function chartPedidosMes()
    {
        $meses = $this->months;

        $year = date('Y', strtotime(date('Y-m-15') . " - 1 months"));
        $monthPrevious = date('m', strtotime(date('Y-m-15') . " - 1 months"));
        $daysTotalMonth = date('t', strtotime(date('Y-m-15') . " - 1 months"));

        $data = [
            'dias' => [],
            'total' => [],
        ];

        for ($i = 1; $i <= $daysTotalMonth; $i++) {

            $day = $i < 10 ? "0$i" : $i;
            $date = "$year-$monthPrevious-$day";

            array_push($data['dias'], $day . '/' . $meses[$monthPrevious]);
            $total = TestOrder::whereDate('created_at', $date)->withTrashed()->count();
            array_push($data['total'], $total);
        }

        $chartPedidosMes = $this->chart->barChart()
            ->setTitle('Solicitações para teste no último mês')
            ->setToolbar(true)
            ->setXAxis($data['dias'])
            ->setDataset([[
                'name'  =>  'Total',
                'data'  =>  $data['total']
            ]])
            ->setDataLabels(true)
            ->setColors(['#008FFB', '#00E396', '#ff6384'])
            ->setHeight(315);

        return $chartPedidosMes;
    }
}
