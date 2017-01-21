<?php 

namespace App\Http\Controllers\Api\Common\User;

use App\Http\Controllers\Api\Common\ApiController;
use App\Models\Services\ExpService;
use Illuminate\Http\Request;

class ExpsController extends ApiController 
{

    /**
     * @var ExpService
     */
    protected $service;

    /**
     * ExpsController constructor.
     * @param ExpService $service
     */
    public function __construct(ExpService $service)
    {
        $this->service = $service;
    }
    
    public function index(Request $request, $user_id) 
    {
        
    }

    public function store(Request $request)
    {
        return $this->methodNotAllowed();
    }

    public function show($user_id, $exp_id)
    {
        return $this->methodNotAllowed();
    }

    public function update(Request $request, $id)
    {
        return $this->methodNotAllowed();
    }

    public function destroy($id)
    {
        return $this->methodNotAllowed();
    }


}