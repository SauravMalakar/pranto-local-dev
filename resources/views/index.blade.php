
@extends('clientlayout.base')

@section('navbar')
    @include('clientlayout.navbar')
@endsection

@section('content')

  <section class="mt-8">

    <div class="container">

      <div class="hero-slider ">

        <div

          style="background: url({{ asset('') }}public/client_asset/images/slide-1.jpg)no-repeat; background-size: cover; border-radius: .5rem; background-position: center;">

          <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">

            <span class="badge text-bg-warning">Opening Sale Discount 50%</span>

            <h2 class="text-dark display-5 fw-bold mt-4">SuperMarket Daily <br> Fresh Grocery </h2>

            <p class="lead">Introduced a new model for online grocery shopping

              and convenient home delivery.</p>

            <a href="#!" class="btn btn-dark mt-3">Shop Now <i class="feather-icon icon-arrow-right ms-1"></i></a>

          </div>

        </div>

        <div class=" "

          style="background: url({{ asset('') }}public/client_asset/images/slider-2.jpg)no-repeat; background-size: cover; border-radius: .5rem; background-position: center;">

          <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">

            <span class="badge text-bg-warning">Free Shipping - orders over $100</span>

            <h2 class="text-dark display-5 fw-bold mt-4">Free Shipping on <br> orders over <span

                class="text-primary">$100</span></h2>

            <p class="lead">Free Shipping to First-Time Customers Only, After promotions and discounts are applied.

            </p>

            <a href="#!" class="btn btn-dark mt-3">Shop Now <i class="feather-icon icon-arrow-right ms-1"></i></a>

          </div>

        </div>

      </div>

    </div>

  </section>

  <!-- Category Section Start-->

  <section class="mb-lg-10 mt-lg-14 my-8">

    <div class="container">

      <div class="row">

        <div class="col-12 mb-6">

          <h3 class="mb-0">Featured Categories</h3>

        </div>

      </div>

      <div class="category-slider ">

        @if(getCategories()->isNotEmpty())
          @foreach (getCategories() as $category)
          <div class="item">
            <a href="#" class="text-decoration-none text-inherit">

              <div class="card card-product mb-4">

                <div class="card-body text-center py-8">
                  @if ($category->image != "")
                    <img src="{{ asset('public/uploads/category/thumbs/'.$category->image) }}" alt="Grocery Ecommerce Template" class="mb-3 img-fluid">
                  @endif

                  <div>{{ $category->name }}</div>

                </div>

              </div>

            </a>
          </div>
          @endforeach
        @endif

      </div>

    </div>

  </section>

  <!-- Category Section End-->

  <section>

    <div class="container">

      <div class="row">

        <div class="col-12 col-lg-6 mb-3 mb-lg-0">

          <div>

            <div class="py-10 px-8 rounded-3"

              style="background:url({{ asset('') }}public/client_asset/images/grocery-banner.png)no-repeat; background-size: cover; background-position: center;">

              <div>

                <h3 class="fw-bold mb-1">Fruits & Vegetables

                </h3>

                <p class="mb-4">Get Upto <span class="fw-bold">30%</span> Off</p>

                <a href="#!" class="btn btn-dark">Shop Now</a>

              </div>

            </div>

          </div>

        </div>

        <div class="col-12 col-lg-6 ">

          <div>

            <div class="py-10 px-8 rounded-3"

              style="background:url({{ asset('') }}public/client_asset/images/grocery-banner-2.jpg)no-repeat; background-size: cover; background-position: center;">

              <div>

                <h3 class="fw-bold mb-1">Freshly Baked

                  Buns

                </h3>

                <p class="mb-4">Get Upto <span class="fw-bold">25%</span> Off</p>

                <a href="#!" class="btn btn-dark">Shop Now</a>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </section>

  <!-- Popular Products Start-->

  <section class="my-lg-14 my-8">

    <div class="container">

      <div class="row">

        <div class="col-12 mb-6">

          <h3 class="mb-0">Popular Products</h3>

        </div>

      </div>

      <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">

        @if($getProducts->isNotEmpty())
            @foreach ($getProducts as $product)
              <div class="col">

                <div class="card card-product">

                  <div class="card-body">

                    <div class="text-center position-relative ">

                      <div class=" position-absolute top-0 start-0">

                        <span class="badge bg-danger">Sale</span>

                      </div>
                      @php
                          $productImage = $product->product_images->first();
                      @endphp

                      @if(!empty($productImage->image))

                      <a href="#!"> <img src="{{ asset('public/uploads/product/large/'.$productImage->image) }}" alt="Grocery Ecommerce Template"

                          class="mb-3 img-fluid"></a>
                      @endif

                      <div class="card-product-action">

                        <a href="#!" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i

                            class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i></a>

                        <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i

                            class="bi bi-heart"></i></a>

                        <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare"><i

                            class="bi bi-arrow-left-right"></i></a>

                      </div>

                    </div>

                    <div class="text-small mb-1"><a href="#!" class="text-decoration-none text-muted"><small>{{ $product->title }}</small></a></div>

                    <h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">{{ $product->title }}</a></h2>

                    <div>

                      <small class="text-warning"> <i class="bi bi-star-fill"></i>

                        <i class="bi bi-star-fill"></i>

                        <i class="bi bi-star-fill"></i>

                        <i class="bi bi-star-fill"></i>

                        <i class="bi bi-star-half"></i></small> <span class="text-muted small">4.5(149)</span>

                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">

                      <div><span class="text-dark">$18</span> <span class="text-decoration-line-through text-muted">$24</span>

                      </div>

                      <div><a href="#!" class="btn btn-primary btn-sm">

                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"

                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"

                            class="feather feather-plus">

                            <line x1="12" y1="5" x2="12" y2="19"></line>

                            <line x1="5" y1="12" x2="19" y2="12"></line>

                          </svg> Add</a></div>

                    </div>

                  </div>

                </div>

              </div>
            @endforeach
        @endif

        

      </div>

    </div>

  </section>

  <!-- Popular Products End-->

  <section>

    <div class="container">

      <div class="row">

        <div class="col-md-12 mb-6">

          <h3 class="mb-0">Daily Best Sells</h3>

        </div>

      </div>

      <div class="row row-cols-lg-4 row-cols-1 row-cols-md-2 g-4">

        <div class="col">

          <div class=" pt-8 px-8 rounded-3"

            style="background:url({{ asset('') }}public/client_asset/images/banner-deal.jpg)no-repeat; background-size: cover; height: 470px;">

            <div>

              <h3 class="fw-bold text-white">100% Organic

                Coffee Beans.

              </h3>

              <p class="text-white">Get the best deal before close.</p>

              <a href="#!" class="btn btn-primary">Shop Now <i class="feather-icon icon-arrow-right ms-1"></i></a>

            </div>

          </div>

        </div>

        <div class="col">

          <div class="card card-product">

            <div class="card-body">

              <div class="text-center  position-relative "> <a href="#!"><img src="{{ asset('') }}public/client_asset/images/product-img-11.jpg"

                    alt="Grocery Ecommerce Template" class="mb-3 img-fluid"></a>

                <div class="card-product-action">

                  <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i

                      class="bi bi-eye"></i></a>

                  <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i

                      class="bi bi-heart"></i></a>

                  <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare"><i

                      class="bi bi-arrow-left-right"></i></a>

                </div>

              </div>

              <div class="text-small mb-1"><a href="#!" class="text-decoration-none text-muted"><small>Tea, Coffee &

                    Drinks</small></a></div>

              <h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">Roast Ground Coffee</a></h2>

              <div class="d-flex justify-content-between align-items-center mt-3">

                <div><span class="text-dark">$13</span> <span class="text-decoration-line-through text-muted">$18</span>

                </div>

                <div>

                  <small class="text-warning"> <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-half"></i>

                  </small>

                  <span><small>4.5</small></span>

                </div>

              </div>

              <div class="d-grid mt-2"><a href="#!" class="btn btn-primary ">

                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"

                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"

                    class="feather feather-plus">

                    <line x1="12" y1="5" x2="12" y2="19"></line>

                    <line x1="5" y1="12" x2="19" y2="12"></line>

                  </svg> Add to cart </a></div>

              <div class="d-flex justify-content-start text-center mt-3">

                <div class="deals-countdown w-100" data-countdown="2022/10/10 00:00:00"></div>

              </div>

            </div>

          </div>

        </div>

        <div class="col">

          <div class="card card-product">

            <div class="card-body">

              <div class="text-center  position-relative "> <a href="#!"><img src="{{ asset('') }}public/client_asset/images/product-img-12.jpg"

                    alt="Grocery Ecommerce Template" class="mb-3 img-fluid"></a>

                <div class="card-product-action">

                  <a href="#!" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i

                      class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i></a>

                  <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i

                      class="bi bi-heart"></i></a>

                  <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare"><i

                      class="bi bi-arrow-left-right"></i></a>

                </div>

              </div>

              <div class="text-small mb-1"><a href="#!" class="text-decoration-none text-muted"><small>Fruits &

                    Vegetables</small></a></div>

              <h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">Crushed Tomatoes</a></h2>

              <div class="d-flex justify-content-between align-items-center mt-3">

                <div><span class="text-dark">$13</span> <span class="text-decoration-line-through text-muted">$18</span>

                </div>

                <div>

                  <small class="text-warning"> <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-half"></i>

                  </small>

                  <span><small>4.5</small></span>

                </div>

              </div>

              <div class="d-grid mt-2"><a href="#!" class="btn btn-primary ">

                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"

                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"

                    class="feather feather-plus">

                    <line x1="12" y1="5" x2="12" y2="19"></line>

                    <line x1="5" y1="12" x2="19" y2="12"></line>

                  </svg> Add to cart </a></div>

              <div class="d-flex justify-content-start text-center mt-3 w-100">

                <div class="deals-countdown w-100" data-countdown="2022/12/9 00:00:00"></div>

              </div>

            </div>

          </div>

        </div>

        <div class="col">

          <div class="card card-product">

            <div class="card-body">

              <div class="text-center  position-relative "> <a href="#!"><img src="{{ asset('') }}public/client_asset/images/product-img-13.jpg"

                    alt="Grocery Ecommerce Template" class="mb-3 img-fluid"></a>

                <div class="card-product-action">

                  <a href="#!" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i

                      class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i></a>

                  <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i

                      class="bi bi-heart"></i></a>

                  <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare"><i

                      class="bi bi-arrow-left-right"></i></a>

                </div>

              </div>

              <div class="text-small mb-1"><a href="#!" class="text-decoration-none text-muted"><small>Fruits &

                    Vegetables</small></a></div>

              <h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">Golden Pineapple</a></h2>

              <div class="d-flex justify-content-between align-items-center mt-3">

                <div><span class="text-dark">$13</span> <span class="text-decoration-line-through text-muted">$18</span>

                </div>

                <div>

                  <small class="text-warning"> <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-fill"></i>

                    <i class="bi bi-star-half"></i></small>

                  <span><small>4.5</small></span>

                </div>

              </div>

              <div class="d-grid mt-2"><a href="#!" class="btn btn-primary ">

                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"

                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"

                    class="feather feather-plus">

                    <line x1="12" y1="5" x2="12" y2="19"></line>

                    <line x1="5" y1="12" x2="19" y2="12"></line>

                  </svg> Add to cart </a></div>

              <div class="d-flex justify-content-start text-center mt-3">

                <div class="deals-countdown w-100" data-countdown="2022/11/11 00:00:00"></div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </section>

@endsection