<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $json_file_name = 'products.json';

    /**
     * Home Page view method
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('home');
    }

    public function list()
    {
        return $this->getJsonFileArray();
    }

    /**
     * Store Product
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails())
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);

        $old_data = $this->getJsonFileArray();

        if (is_array($old_data)) {
            $new_record['id'] = count($old_data) + 1;
            $new_record['name'] = request('name');
            $new_record['price'] = request('price');
            $new_record['quantity'] = request('quantity');

            $old_data[] = $new_record;
            if ($this->setJsonFileArray($old_data)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully saved.'
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'There was an error please try after sometime.'
        ]);
    }

    /**
     * Get Array from json file
     * @return array|false
     */
    private function getJsonFileArray()
    {
        if (Storage::exists($this->json_file_name)) {
            return (array)json_decode(Storage::get($this->json_file_name), true);
        } else {
            if (Storage::put($this->json_file_name, '[]')) {
                return [];
            } else {
                return false;
            }
        }
    }

    /**
     * Save Json file
     * @param array $data
     * @return bool
     */
    private function setJsonFileArray(array $data): bool
    {
        return Storage::put($this->json_file_name, json_encode($data));
    }
}
