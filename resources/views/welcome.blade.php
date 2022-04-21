<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" class="stylesheet">
</head>
<body>

@extends('shopify-app::layouts.default')

@section('content')
    <p>User: {{ Auth::user()->name }}</p>

    <?php echo __DIR__ ?>
    <main>
        
        <section>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Type</th>
                            <th>Vendor</th>
                            <th>Handle</th>
                            <th>Price</th>
                            <th>Compare at price</th>
                            <th>Inventory Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // echo '<pre> Products Array:';
                            // print_r($products);
                            // echo '</pre>';
                            // echo '<hr>';
                            // echo '<pre> ORDERS Array:';
                            // dd($orders);
                            // die();
                        @endphp

                        @foreach ($products as $product)
                            @if($product['status'] !== 'draft')
                                @php
                                    $image = '';
                                @endphp
                                @if ( count($product['images']) > 0 ) 
                                    @php
                                        $image = $product['images'][0]['src'];
                                    @endphp
                                @endif

                        <tr>
                            <td>
                                {{ $product['id'] }}
                            </td>
                            <td>
                                <img src="{{ $image }}" alt="{{ $product['title'] }}" width="50" height="50"></img>
                            </td>
                            <td>
                                {{ $product['title'] }}
                            </td>
                            <td>
                                {{ $product['product_type'] }}
                            </td>
                            <td>
                                {{ $product['vendor'] }}
                            </td>
                            <td>
                                {{ $product['handle'] }}
                            </td>
                            <td>
                                {{ $product['variants'][0]['price'] }}
                            </td>
                            <td style="background-color: red; color: white;">
                                {{ $product['variants'][0]['compare_at_price'] }}
                            </td>
                            <td>
                                {{ $product['variants'][0]['inventory_management'] }}
                            </td>
                        </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

            </div>
        </section>

    </main>


    @endsection

    @section('scripts')
        @parent
        <script>
            actions.TitleBar.create(app, { title: 'Welcome' });
        </script>
    @endsection

</body>
</html>
