@extends('layouts.app')

@section('content')
<div>
    <div class="flex items-center mb-4">
        <div class="w-1 h-6 bg-blue-600 mr-2"></div>
        <span class="text-sm font-semibold">Our Products</span>
    </div>

    <!-- Items Per Page Selector -->
    <div class="w-1/12 border-solid border-2">
        <form method="GET" action="{{ url('/products') }}" class="mb-6">
            <label for="per_page" class="block text-sm font-medium text-gray-700">Items per page:</label>
            <select name="per_page" id="per_page" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                <option value="1" {{ $products->perPage() == "1" ? 'selected' : '' }}>1</option>
                <option value="5" {{ $products->perPage() == "5" ? 'selected' : '' }}>5</option>
                <option value="10" {{ $products->perPage() == "10" ? 'selected' : '' }}>10</option>
                <option value="20" {{ $products->perPage() == "20" ? 'selected' : '' }}>20</option>
            </select>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $val)
        <a href="{{ url('/products/' . $val['id']) }}" class="block">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    <img src="{{ $val['image'] }}" alt="Product" class="w-full h-48 object-cover">
                    <button class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold mb-2">Product Name {{ $val['name'] }}</h3>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-red-600 font-bold">Rp{{ $val['price'] }}</span>
                        <div class="flex items-center">
                            <span class="text-yellow-400">★★★★☆</span>
                            <span class="text-gray-500 text-sm ml-1">({{ $val['review_count'] }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection