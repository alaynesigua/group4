<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        input[type="file"] {
            border: none;
        }

        img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit Product</h1>
    @if(session()->has('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('inventory.update', ['inventory' => $inventory->id]) }}" method="post" enctype="multipart/form-data">



        @csrf
        @method('PUT') 
        <label for="product">Product:</label>
        <input type="text" id="product" name="product" value="{{ $inventory->product }}" required>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="{{ $inventory->description }}" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" value="{{ $inventory->price }}" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="{{ $inventory->stock }}" required>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <p>Current Image:</p>
        @if($inventory->image)
            <img src="{{ asset('storage/' . $inventory->image) }}" alt="Current Product Image">
        @else
            <p>No Image Available</p>
        @endif

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
