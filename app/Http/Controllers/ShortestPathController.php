<?php

namespace App\Http\Controllers;

use App\Domain\Service\ShortestPathService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShortestPathController extends Controller
{
    public function run(Request $request)
    {
        try {
            $file  = $request->get('file', 'assets/input.csv');
            $route = $request->get('route');

            $service = new ShortestPathService($file, $route);

            $bestRoute = $service->handle();

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json($bestRoute);
    }

    public function insert(Request $request)
    {
        try {
            $file  = $request->get('file', 'assets/input.csv');
            $route = $request->get('route');

            $service = new ShortestPathService($file, $route);

            $service->insert();

        } catch (\Exception $e) {
            return response()->json([
                'error: ' => $e->getMessage(),
                'warning' => 'O campo route deve respeitar o formato: \'GRU,CDG,10\''
            ], 500);
        }

        return response()->json('Rota inserida com sucesso!');
    }
}
