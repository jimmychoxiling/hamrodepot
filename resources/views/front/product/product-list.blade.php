@if(count($products) > 0)
    @foreach($products as $product)
        <div class="sb_product__item">
            @if($product->sell_type == 'Rent')
                <div class="product-badge"><span>Available for Rent</span></div>
            @endif
            <div class="sb_product__image">
                <div class="sb_product_favorite ">
                <!-- <input class="whishListCheck" value="{{$product->id}}" {{$product->wishlistCheck? 'checked': ''}} type="checkbox"> -->
                    <div class="sb_favorite_icon whishListCheck {{$product->wishlistCheck? 'active': ''}}"
                         data-id="{{$product->id}}">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </div>
                </div>
                @if(isset($product->type))
                    <a href="{{ route('product-detail', array('slug2' => $product->category->slug, 'slug3' => $product->sub_category->slug, 'slug4' => $product->type->slug, 'slug5' => $product->slug)) }}">
                        @else
                            <a href="{{ route('product-detail', array('slug2' => $product->category->slug, 'slug3' => $product->sub_category->slug, 'slug4' => $product->slug)) }}">
                                @endif
                                @if(!empty($product->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($product->productsImagesFirst->filename))
                                    <img src="{{ url('storage') . '/' . $product->productsImagesFirst->filename}}"
                                         alt="{{ $product->name }}">
                                @else
                                    <img src="{{ url('storage') . '/no_image.png'}}" alt="{{ $product->name }}">
                                @endif
                            </a>
            </div>
            <div class="sb_product__content">
                <p>
                    @if(isset($product->type))
                        <a href="{{ route('product-detail', array('slug2' => $product->category->slug, 'slug3' => $product->sub_category->slug, 'slug4' => $product->type->slug, 'slug5' => $product->slug)) }}">{{ $product->name }} </a>
                    @else
                        <a href="{{ route('product-detail', array('slug2' => $product->category->slug, 'slug3' => $product->sub_category->slug, 'slug4' => $product->slug)) }}">{{ $product->name }} </a>
                    @endif
                </p>
                <div class="sb_product__rating">
                    <div class="common-rating" data-average="{{$product->avg_rating}}" data-id="0"></div>
                    <span>&nbsp; ({{$product->all_rating}})</span>
                </div>
                <div class="sb_product__price">
                    @if($product->sell_type == 'Sell')
                        <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $product->price }}</ins>
                    @else
                        <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $product->price }} / hour</ins>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif
