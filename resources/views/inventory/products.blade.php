<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .product-card {
            width: 300px;
            border: 1px solid #ccc;
            margin: 20px;
            padding: 20px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        }

        .product-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
        }

        .product-title {
            font-size: 20px;
            margin: 10px 0;
        }

        .product-description {
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
        }

        .buy-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .buy-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Church Merchandise</h1>
    
    @foreach ($products as $product)
    <div class="product-card">
        <img class="product-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        <h2 class="product-title">{{ $product->product}}</h2>
        <p class="product-description">{{ $product->description }}</p>
        <p class="product-price"><span>&#8369;</span>{{ number_format($product->price, 2) }}</p>
        <a href="{{ route('order.user', ['id' => $product->id]) }}" class="buy-button">Buy Now</a>

    </div>
    @endforeach
</body>
</html>
