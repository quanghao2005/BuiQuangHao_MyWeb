@foreach($products as $product)
    <div class="col">
        <x-client.product :product="$product" />
    </div>
@endforeach
