<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    protected $client;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiBaseUrl = "http://localhost:8001/api";
    }

    protected function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . Session::get('access_token'),
            'Accept' => 'application/json',
        ];
    }

    public function index()
    {
        try {
            $perPage = request()->get('per_page', 1);
            $page = request()->get('page', 1);

            $response = $this->client->get("{$this->apiBaseUrl}/products", [
                'headers' => $this->getHeaders(),
                'query' => ['page' => $page, 'perPage' => $perPage]
            ]);

            $products = json_decode($response->getBody(), true);

            // Get the products and pagination metadata
            $productsArray = $products['data'];
            $total = $products['meta']['total'];
            $currentPage = $products['meta']['current_page'];
            $lastPage = $products['meta']['last_page'];
            $perPage = $products['meta']['per_page'];

            // Create a LengthAwarePaginator instance
            $products = new LengthAwarePaginator($productsArray, $total, $perPage, $currentPage, [
                'path' => url('/products'),
                'query' => request()->query(),
            ]);
            return view('products.index', compact('products'));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return back()->withError('Failed to fetch products.');
        }
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        try {
            $response = $this->client->post("{$this->apiBaseUrl}/products", [
                'headers' => $this->getHeaders(),
                'json' => $request->all()
            ]);

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return back()->withInput()->withError('Failed to create product.');
        }
    }

    public function show($id)
    {
        try {
            $response = $this->client->get("{$this->apiBaseUrl}/products/{$id}", [
                'headers' => $this->getHeaders()
            ]);

            $product = json_decode($response->getBody(), true);
            $product = $product['data'];

            return view('products.show', compact('product'));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return back()->withError('Failed to fetch product details.');
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->client->get("{$this->apiBaseUrl}/products/{$id}", [
                'headers' => $this->getHeaders()
            ]);

            $product = json_decode($response->getBody(), true);

            return view('products.edit', compact('product'));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return back()->withError('Failed to fetch product for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        try {
            $response = $this->client->put("{$this->apiBaseUrl}/products/{$id}", [
                'headers' => $this->getHeaders(),
                'json' => $request->all()
            ]);

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return back()->withInput()->withError('Failed to update product.');
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->client->delete("{$this->apiBaseUrl}/products/{$id}", [
                'headers' => $this->getHeaders()
            ]);

            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return back()->withError('Failed to delete product.');
        }
    }
}
