<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Laravel Skill Test</title>
</head>
<body>

<div class="container mt-2">
    <div class="card">
        <div class="card-body">
            {{--     Edit Product Form       --}}
            <div class="card">
                <div class="card-header">
                    Edit Product
                </div>
                <div class="card-body">
                    <form id="product-form">
                        <div class="mb-3">
                            <label for="product-name">Product Name</label>
                            <input type="text" class="form-control" id="product-name" placeholder="Product Name"
                                   name="name" value="{{ $product['name'] }}"
                                   autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="quantity-in-stock">Product Quantity (in stock)</label>
                            <input type="number" class="form-control" id="quantity-in-stock" name="quantity" value="{{ $product['quantity'] }}"
                                   placeholder="Product Quantity (In stock)">
                        </div>
                        <div class="mb-3">
                            <label for="product-price">Product Price (Per item)</label>
                            <input type="number" class="form-control" id="product-price" name="price" value="{{ $product['price'] }}"
                                   placeholder="Product Price (Per item)">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(function () {
        $('#product-form').on('submit', function (e) {
            e.preventDefault();
            const data = $(this).serialize();
            $("#product-form input").prop("disabled", true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('product-edit', ['id' => $product['id']]) }}',
                method: 'PUT',
                data: data,
                success: function (response) {
                    $("#product-form input").prop("disabled", false);
                    if (response.status) {
                        location.replace('{{ route('products') }}');
                    } else
                        alert(response.message);
                }
            })
        })
    })
</script>
</body>
</html>
