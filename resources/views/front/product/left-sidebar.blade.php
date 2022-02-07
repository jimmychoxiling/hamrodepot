<div class="sidebar" id="filter_sidebar">
    @if(isset($category_filter) && count($category_filter) > 0)
    <div class="sb_sub_category_wrap">
        <h4 class="sb_sub_category_title">Categories <i class="fa fa-caret-up" aria-hidden="true"></i></h4>
        <div class="sb_sub_category_list_wrap">
            <ul class="sb_filter_list_wrap truncate">
                @foreach($category_filter as $category_filter_val)
                <li class="sb_filter_item">
                    <input type="checkbox" class="category" value="{{$category_filter_val->id}}"
                        {{ isset($category->slug) && $category->slug == $category_filter_val->slug ? 'checked' : ''}}>
                    <label for="" class="sb_category_text">{{ $category_filter_val->name }} </label>
                    <ul class="sb_filter_list_wrap">
                        @foreach($category_filter_val->sub_category as $sub_category_val)
                        <li class="sb_filter_item">
                            <input type="checkbox" class="category" value="{{$sub_category_val->id}}" {{ isset($sub_category->slug) && $sub_category->slug == $sub_category_val->slug ? 'checked' : ''}}>
                            <label for="" class="sb_category_text">{{$sub_category_val->name}}</label>
                            <ul class="sb_filter_list_wrap">
                                @foreach($sub_category_val->types as $types_val)
                                <li class="sb_filter_item">
                                    <input type="checkbox" class="category" value="{{$types_val->id}}" {{ isset($type->slug) && $type->slug == $types_val->slug ? 'checked' : ''}}>
                                    <label for="" class="sb_category_text">{{$types_val->name}}</label>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
            <div class="txtcol"><a>Show More</a></div>
        </div>
    </div>
    @endif
    @if(isset($brands) && count($brands) > 0)
    <div class="sb_sub_category_wrap">
        <h4 class="sb_sub_category_title">Brands<i class="fa fa-caret-up" aria-hidden="true"></i></h4>
        <div class="sb_sub_category_list_wrap">
            <ul class="sb_filter_list_wrap">
                @foreach($brands as $brand)
                <li class="sb_filter_item">
                    <input type="checkbox" class="brand" value="{{$brand->id}}">
                    <label for="" class="sb_category_text">{{ $brand->name }} <span
                            class="sb_category_count">({{ $brand->products_count }})</span></label>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="sb_sub_category_wrap">
        <h4 class="sb_sub_category_title">Price <i class="fa fa-caret-up" aria-hidden="true"></i></h4>
        <div class="sb_sub_category_list_wrap">
            <div id="rangeSlider" class="range-slider">
                <div class="number-group">
                    <div class="input__wrap">
                        <input class="number-input" type="number" value="0" min="0" max="{{ $max_amount }}" />
                        <span>$</span>
                    </div>
                    <span>to</span>
                    <div class="input__wrap">
                        <input class="number-input" type="number" value="{{ $max_amount }}" min="0"
                            max="{{ $max_amount }}" />
                        <span>$</span>
                    </div>
                </div>
                <div class="range-group">
                    <input class="range-input" value="0" min="0" max="{{ $max_amount }}" step="1" type="range"
                        id="min_price" />
                    <input class="range-input" value="{{ $max_amount }}" min="0" max="{{ $max_amount }}" step="1"
                        type="range" id="max_price" />
                </div>
            </div>
        </div>
    </div>
    <div class="sb_sub_category_wrap">
        <h4 class="sb_sub_category_title">Customer Rating <i class="fa fa-caret-up" aria-hidden="true"></i></h4>
        <div class="sb_sub_category_list_wrap">
            <ul class="sb_filter_list_wrap">
                @for($i=4;$i>=1;$i--)
                <li class="sb_filter_item">
                    <input type="checkbox" class="rating" value="{{ $i }}">
                    <label class="sb_category_text">{{ $i }} <i class="fa fa-star"></i> & above </label>
                </li>
                @endfor
            </ul>
        </div>
    </div>
    <div class="sb_sub_category_wrap">
        <h4 class="sb_sub_category_title">Buy / Rent <i class="fa fa-caret-up" aria-hidden="true"></i></h4>
        <div class="sb_sub_category_list_wrap">
            <ul class="sb_filter_list_wrap">
                <li class="sb_filter_item">
                    <input type="checkbox" class="saleType_checkbox" value="Sell">
                    <label for="" class="sb_category_text">Only for Buy</label>
                </li>
                <li class="sb_filter_item">
                    <input type="checkbox" class="saleType_checkbox" value="Rent">
                    <label for="" class="sb_category_text">Only for Rent</label>
                </li>
                <li class="sb_filter_item">
                    <input type="checkbox" class="saleType_checkbox" value="Both">
                    <label for="" class="sb_category_text">Both</label>
                </li>
            </ul>
        </div>
    </div>
</div>
