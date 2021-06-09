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
        return view('product');
    }

    /**
     * Product edit view method
     * @return Application|Factory|View|string
     */
    public function editView($id)
    {
        $products = $this->getJsonFileArray();
        $hasProduct = false;
        $data['product'] = [];
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                $hasProduct = true;
                $data['product']['id'] = $id;
                $data['product']['name'] = $product['name'];
                $data['product']['price'] = $product['price'];
                $data['product']['quantity'] = $product['quantity'];
            }
        }
        if ($hasProduct)
            return view('product-edit', $data);

        return redirect()->route('products');
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

        $products = $this->getJsonFileArray();

        if (is_array($products)) {
            $new_record['id'] = count($products) + 1;
            $new_record['name'] = request('name');
            $new_record['price'] = request('price');
            $new_record['quantity'] = request('quantity');

            $products[] = $new_record;
            if ($this->setJsonFileArray($products)) {
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
     * Product Edit API
     * @param $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
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

        $products = $this->getJsonFileArray();
        $updated = false;
        foreach ($products as $key => $product) {
            if ($product['id'] == $id) {
                $updated = true;
                $products[$key]['name'] = request('name');
                $products[$key]['price'] = request('price');
                $products[$key]['quantity'] = request('quantity');
            }
        }
        if ($updated)
            if ($this->setJsonFileArray($products))
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully saved.'
                ]);

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
