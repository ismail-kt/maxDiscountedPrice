<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<style>

    .scrollable-div {
        width: auto; 
        height: 620px; 
        overflow-y: scroll; 
        scrollbar-width: thin;
        scrollbar-color: #888888 #f2f2f2; 
    }
</style>

<body>
    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="row">

                    <div class="col-9 scrollable-div mt-3">
                        <h3>Products</h3>
                        <p>Choose the desired products and add to cart</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        <div class="row">
                            @foreach ($products as $product)
                                
                                <div class="pr-2 pt-2">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$product->name}}</h5>

                                            <p class="card-text">It's an mazing book to read and enritch your experience.</p>
                                            <a href="#" class="card-link">$8</a>
                                            <br>
                                            <form action="{{route('add.cart')}}" method="post">
                                                @csrf
                                                <label for="">Count:</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" value="1">
                                                <input type="hidden" id="product_id" name="product_id" value="{{$product->id}}" min="1">
                                                <hr>
                                                <button type="submit" class="btn btn-primary">Add to cart</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>
                    <div class="col-3 mt-3">

                        <h3>Cart</h3>
                        {{-- <br> --}}
                        
                        @if (sizeof($cartData))

                            <a href="{{route('clear.cart')}}"><button type="button" class="btn btn-danger">Clear Cart</button></a>
                            <hr>
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <th>Delete</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Deduct</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartData as $item)    
                                            <tr>
                                                <td>
                                                    <form action="{{route('remove.cart', [$item->id])}}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">X</button>
                                                    </form>
                                                </td>
                                                <td>{{$item->product->name}}</td>
                                                <td>{{$item->quantity}}</td>
                                                <td><a href="{{route('update.cart', [$item->id])}}">
                                                    <button type="submit" class="btn btn-warning">-</button></a></td>
                                                </form>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p>Original Price: <strong>{{$originalPrice}} $</strong></p>
                                <hr>
                                <p>Total To Pay (after discount): <strong>{{$toPay}} $</strong></p>
                            </div>  
                            
                        @else
                            <div class="alert alert-danger" role="alert">
                                Cart is Empty!
                            </div>
                        @endif

                    </div>
                </div>
            </div>


        </div>
    </div>



</body>

</html>