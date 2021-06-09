<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                    <form>
                        <div class="mb-3">
                            <label for="product-name" class="visually-hidden">Product Name</label>
                            <input type="text" class="form-control" id="product-name" placeholder="Product Name"
                                   autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="quantity-in-stock" class="visually-hidden">Product Quantity (in stock)</label>
                            <input type="number" class="form-control" id="quantity-in-stock"
                                   placeholder="Product Quantity (in stock)">
                        </div>
                        <div class="mb-3">
                            <label for="product-price" class="visually-hidden">Product Price (Per item)</label>
                            <input type="number" class="form-control" id="product-price"
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


<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
</body>
</html>
