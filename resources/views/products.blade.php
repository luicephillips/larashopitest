<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" class="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  

</head>
<body>

@extends('shopify-app::layouts.default')

@section('content')
    <main>
        <section id="table_section">
            <div class="card">
                <h3>Product Type Popularity Report</h3>
                <table id="product_productivity_table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Type</th>
                            @for ($col=1; $col <= 10; $col++)
                                @if ($col == 1)
                                <th>{{ $col }} Time</th>
                                @elseif($col > 1)
                                <th>{{ $col }} Times</th>
                                @elseif($col >= 10)
                                <th>{{ $col }}+ Times</th>
                                @endif
                            @endfor
                            <th>Customer Id</th>
                            <th>Customer Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            @php
                                $image = $product['image'];
                                $get_product_quantity = $product['product_quantity'];
                            @endphp
                        <tr>    
                            <td>{{ $product['id'] }}</td>
                            <td><img src="{{ $image }}" alt="{{ $product['title'] }}" width="50" height="50"></img></td>
                            <td>{{ $product['title'] }}</td>
                            <td>{{ $product['product_type'] }}</td>
                            <td>{{ $get_product_quantity == 1 ? '1' : '-' }}</td>
                            <td>{{ $get_product_quantity == 2 ? '2' : '-' }} </td>
                            <td>{{ $get_product_quantity == 3 ? '3' : '-' }} </td>
                            <td>{{ $get_product_quantity == 4 ? '4' : '-' }} </td>
                            <td>{{ $get_product_quantity == 5 ? '5' : '-' }} </td>
                            <td>{{ $get_product_quantity == 6 ? '6' : '-' }} </td>
                            <td>{{ $get_product_quantity == 7 ? '7' : '-' }} </td>
                            <td>{{ $get_product_quantity == 8 ? '8' : '-' }} </td>
                            <td>{{ $get_product_quantity == 9 ? '9' : '-' }} </td>
                            <td>{{ $get_product_quantity == 10 ? $get_product_quantity : '-' }} </td>
                            <td>{{ $product['customer_data']['customer_id'] }}</td>
                            <td>{{ $product['customer_data']['customer_name'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section id="summary">
            <div class="container">
                <div class="col-sm-12">
                    <h5>Total Products Bought: {{ $total_product_buy }}</h5>
                </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(function () {
            $('#product_productivity_table').DataTable();
        });
    </script>

</body>
</html>
