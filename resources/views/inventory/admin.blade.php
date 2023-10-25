<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
        }

        .edit-btn, .delete-btn {
            margin-right: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .alert.alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
.alert.alert-error {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }

    .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            width: 200px;
            margin-right: 10px;
        }

        .filter-select {
            width: 150px;
        }
    </style>
</head>
<body>
    <h1>Manage Inventory</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="newProduct"> 
        <button id="addProductBtn">Add New Product</button>
    </a>

    <div class="search-container">
        <form action="{{ route('inventory.admin') }}" method="GET">
            <input type="text" class="search-input" name="search" placeholder="Search by product name" value="{{ request('search') }}">
            <select class="filter-select" name="filter">
                <option value="" selected>Filter by</option>
                <option value="price_low_high" {{ request('filter') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high_low" {{ request('filter') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="stock_low_high" {{ request('filter') == 'stock_low_high' ? 'selected' : '' }}>Stock: Low to High</option>
                <option value="stock_high_low" {{ request('filter') == 'stock_high_low' ? 'selected' : '' }}>Stock: High to Low</option>
            </select>
            <button type="submit">Apply Filter</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventory as $item)
            <tr>
                <td>{{ $item->product }}</td>
                <td>{{ $item->description }}</td>
                <td><span>&#8369;</span>{{ number_format($item->price, 2) }}</td>
                <td>{{ $item->stock }}</td>
                <td>
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Product Image">
                    @else
                        <img src="placeholder.jpg" alt="Product Image">
                    @endif
                </td>
                <td class="actions">
                    <a href="{{ route('inventory.edit', ['inventory' => $item]) }}" class="edit-btn">Edit</a>
                    <form method="post" action="{{ route('inventory.destroy', ['inventory' => $item]) }}" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
