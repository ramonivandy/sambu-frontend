<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <nav class="bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-xl font-bold">CompanyBrand</div>
                <div class="space-x-4">
                    <a href="{{url('/products')}}" class="text-gray-600 hover:text-gray-900">Product</a>
                    @if(Session::has('access_token'))
                    <a href="{{ url('/logout') }}" class="text-gray-600 hover:text-gray-900">Log out</a>
                    @else
                    <a href="{{ url('/login') }}" class="text-gray-600 hover:text-gray-900">Sign In</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>
    <footer>

    </footer>
</body>

<script>

</script>

</html>