<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($products as $product)
                            <div class="border rounded-lg p-4">
                                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                <p class="text-gray-600">${{ number_format($product->price, 2) }}</p>
                                <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                                <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>