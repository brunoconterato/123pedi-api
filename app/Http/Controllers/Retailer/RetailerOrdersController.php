<?php

namespace Drinking\Http\Controllers\Retailer;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\UnregisteredOrderRepository;
use Drinking\Repositories\UserRepository;
use Drinking\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//TODO no phpStorm: importar Controller da CodeDelivery
class RetailerOrdersController extends Controller
{
    /**
     * @var UnregisteredOrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(
        UnregisteredOrderRepository $orderRepository,
        UserRepository $userRepository,
        OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        //TODO: Esta linha devera ser implementada quando usarmos OAuth2
        //$retailerId = Authorizer::getResourceOwnerId();

        //TODO: Esta linha deverá ser apagada quando usarmos OAuth2
        $retailerId = $this->userRepository->find(Auth::user()->id)->retailer->id;
        $orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use($retailerId){
            return $query->where('retailer_id','=',$retailerId);
        })->paginate();

        //return da API
        //return $orders;

        //return da view
        return view('retailer.orders.index', compact('orders'));
    }

    public function viewOrder($id){
        $order = $this->orderRepository->find($id);

        $list_status_keys = ['Pendente', 'Em manipulação', 'A caminho', 'Entregue', 'Cancelado'];
        //criando list_status com keys e values iguals: necessario pois o html imprime so as keys
        $list_status = array_combine($list_status_keys, $list_status_keys);

        return view('retailer.orders.vieworder', compact('order','list_status'));
    }
    
    public function update(Request $request, $id)
    {
        $all = $request->all();
        $this->orderRepository->update($all, $id);

        return redirect()->route('retailer.orders.index');
    }

    public function show($id)
    {
        //implementação para Api

        //TODO: Ao implementar OAuth2, esta linha:
        $idDeliveryman = $this->userRepository->find(Auth::user()->id)->client->id;
        //TODO: deverá ser substituida por
        //$idDeliveryman = Authorizer::getResourceOwnerId();

        return $this->orderRepository->getByIdAndDeliveryman($id,$idDeliveryman);


        //todo: implementação para View
    }
}
