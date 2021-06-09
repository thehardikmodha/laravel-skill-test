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
            {{--     Add New Product Form       --}}
            <div class="card">
                <div class="card-header">
                    Add New Product
                </div>
                <div class="card-body">
                    <form id="product-form">
                        <div class="mb-3">
                            <label for="product-name" class="visually-hidden">Product Name</label>
                            <input type="text" class="form-control" id="product-name" placeholder="Product Name"
                                   name="name"
                                   autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="quantity-in-stock" class="visually-hidden">Product Quantity (in stock)</label>
                            <input type="number" class="form-control" id="quantity-in-stock" name="quantity"
                                   placeholder="Product Quantity (In stock)">
                        </div>
                        <div class="mb-3">
                            <label for="product-price" class="visually-hidden">Product Price (Per item)</label>
                            <input type="number" class="form-control" id="product-price" name="price"
                                   placeholder="Product Price (Per item)">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header">
                    Product List
                </div>
                <table id="product-table" class="card-body table table-bordered table-hover m-0">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Quantity</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Total Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>

    function fetchProducts() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('products-list') }}',
            method: 'GET',
            success: function (data) {
                $('#product-table tbody').empty();
                if (data.length > 0)
                {
                    for (let i = 0; i < data.length; i++) {
                        const id = data[i].id;
                        const name = data[i].name;
                        const quantity = data[i].quantity;
                        const price = data[i].price;
                        $("#product-table tbody").append('<tr>' +
                            '<th scope="row">' + id + '</th>' +
                            '<td>' + name + '</td>' +
                            '<td>' + quantity + '</td>' +
                            '<td>$' + price + '</td>' +
                            '<td>$' + (parseInt(price) * parseInt(quantity)) + '</td>' +
                            '</tr>');
                    }
                } else {
                    $("#product-table tbody").append('<tr><td class="text-center" colspan="5">No record found.</td></tr>');
                }
            }
        })
    }

    $(function () {
        fetchProducts();
        $('#product-form').on('submit', function (e) {
            e.preventDefault();
            const data = $(this).serialize();
            $("#product-form input").prop("disabled", true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('product-store') }}',
                method: 'POST',
                data: data,
                success: function (response) {
                    $("#product-form input").prop("disabled", false);
                    if (response.status) {
                        fetchProducts();
                        $("#product-form input").val('');
                    } else
                        alert(response.message);
                }
            })
        })
    })
</script>
</body>
</html>
