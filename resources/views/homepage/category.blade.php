@extends('homepage.extends')
@section('title','| Kategori produk')
@section('keywords','hydraulic dump truck','sparepart truck','hydraulic')
@section('desc','Halaman ini menjual berbagai produk Hydraulic Dump Truck dari Sumber Diesel.')
@section('content')
<section id="page-title">
    <div class="container">
        <div class="page-title">
            <h1>@if($itemkategori->count()<1) No data founded @else @foreach ($itemkategori->
                    take(1) as $item)
                    {{$item->nama_kategori}}
                    @endforeach
                    @endif</h1>
        </div>
        <div class="breadcrumb">
            <ul>
                <li><a href="#">Home</a>
                </li>
                <li><a href="#">Shop</a>
                </li>
                <li class="active"><a href="javascript:window.location.reload(true)">
                        @if($itemkategori->count()<1) No data founded @else @foreach ($itemkategori->
                            take(1) as $item)
                            {{$item->nama_kategori}}
                            @endforeach
                            @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>


<section id="page-content" class="sidebar-right">
    <div class="container">
        <div class="row">
            <div class="content col-lg-8">
                <div class="row m-b-20">
                    <div class="col-lg-6 p-t-10 m-b-20">
                        <h3 class="m-b-20">@if($itemkategori->count()<1) No data founded @else @foreach ($itemkategori->
                                take(1) as $item)
                                {{$item->nama_kategori}}
                                @endforeach
                                @endif
                        </h3>

                    </div>
                </div>

                <div class="shop">
                    <div class="grid-layout grid-3-columns" data-item="grid-item">
                        @if($itemkategori->count()<1) <div class="grid-item">
                            <h3>No data founded</h3>
                    </div>
                    @else
                    @foreach ($itemkategori as $itemdata)
                    <div class="grid-item">
                        <div class="product">
                            <div class="product-image">
                                <a href="/ajax-product/{{$itemdata->itemId}}" data-lightbox="ajax"><img
                                        alt="Shop product image!"
                                        src="{!!asset('storage/shop/img/'.$itemdata->images)!!}">
                                </a>
                                <a href="/ajax-product/{{$itemdata->itemId}}" data-lightbox="ajax"><img
                                        alt="Shop product image!"
                                        src="{!!asset('storage/shop/img/'.$itemdata->images)!!}">
                                </a>
                                <span class="product-new">NEW</span>
                                <span class="product-wishlist">
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                </span>
                                <div class="product-overlay">
                                    <a href="/ajax-product/{{$itemdata->itemId}}" data-lightbox="ajax">Quick
                                        View</a>
                                </div>
                            </div>
                            <div class="product-description">
                                <div class="product-category">{{$itemdata->type_product}}</div>
                                <div class="product-title">
                                    <h3><a href="#">{{$itemdata->nama_item}}</a></h3>
                                </div>
                                <div class="product-price"><ins></ins>
                                </div>
                                <div class="product-rate">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                                <div class="product-reviews"><a
                                        href="#">@if($itemdata->kategori_id){{$itemdata->nama_kategori}}@endif</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <hr>

                <ul class="pagination">
                    {{$itemkategori->links()}}
                </ul>
            </div>
        </div>

        <div class="sidebar sticky-sidebar col-lg-4">
            <div class="widget widget-archive">
                <h4 class="widget-title">Product categories</h4>
                <ul class="list list-lines">
                    @foreach ($kategori as $item)
                    <li><a href="/kategori-item/{{$item->id}}">{{$item->nama_kategori}}</a></span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="widget widget-tags">
                <h4 class="widget-title">Product Categories</h4>
                <div class="tags">
                    @foreach ($kategori as $item)
                    <a href="/kategori-item/{{$item->id}}">{{$item->nama_kategori}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
