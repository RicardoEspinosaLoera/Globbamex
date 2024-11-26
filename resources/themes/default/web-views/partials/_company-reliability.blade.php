<div class="container rtl pb-4 pt-3 px-0 px-md-3">
    <div class="shipping-policy-web">
        <!--<div class="row g-3 justify-content-center mx-max-md-0">
            @foreach ($companyReliability as $key=>$value)
                @if ($value['status'] == 1 && !empty($value['title']))
                    <div class="col-md-3 px-max-md-0">
                        <div class="d-flex justify-content-center">
                            <div class="shipping-method-system">
                                <div class="w-100 d-flex justify-content-center mb-1">
                                    <img alt="" class="size-60"
                                         src="{{ getValidImage(path: 'storage/app/public/company-reliability/'.$value['image'], type: 'source', source: theme_asset(path: 'public/assets/front-end/img').'/'.$value['item'].'.png') }}"
                                    >
                                </div>
                                <div class="w-100 text-center">
                                    <p class="m-0">{{ $value['title'] }}</p>
                                    <p style="color: #154058;" class="m-0"><strong>Escoge tu producto</strong><br/><span style="font-size: 12px;color: #154058;">Descubre los mies de productos que tenemos para ti.</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>-->
        <div class="row g-3 justify-content-center mx-max-md-0" style="padding: 80px !important;">
            <div class="col-md-4 px-max-md-0">
                <div class="d-flex justify-content-center">
                    <div class="shipping-method-system">
                        <div class="w-100 d-flex justify-content-center mb-1">
                            <img alt="" class="size-90"
                                 src="https://globbamex.com/public/assets/front-end/img/05_ESCOGE%20TU%20PRODUCTO.svg"
                            >
                        </div>
                        <div class="w-100 text-center">
                            <p style="color: #154058;" class="m-0"><strong>{{ translate('company_reliability_choose_your_product_title') }}</strong><br/><span style="font-size: 12px;color: #154058;">{{ translate('company_reliability_choose_your_product_description') }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 px-max-md-0">
                <div class="d-flex justify-content-center">
                    <div class="shipping-method-system">
                        <div class="w-100 d-flex justify-content-center mb-1">
                            <img alt="" class="size-90"
                                 src="https://globbamex.com/public/assets/front-end/img/06_M%C3%81S%20PRODUCTO.svg"
                            >
                        </div>
                        <div class="w-100 text-center">
                            <p style="color: #154058;" class="m-0"><strong>{{ translate('company_reliability_more_products_title') }}</strong><br/><span style="font-size: 12px;color: #154058;">{{ translate('company_reliability_more_products_description') }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 px-max-md-0" >
                <div class="d-flex justify-content-center">
                    <div class="shipping-method-system">
                        <div class="w-100 d-flex justify-content-center mb-1">
                            <img alt="" class="size-90"
                                 src="https://globbamex.com/public/assets/front-end/img/07_RASTREA%20TU%20PEDIDO.svg"
                            >
                        </div>
                        <div class="w-100 text-center">
                            <p style="color: #154058;" class="m-0"><strong>{{ translate('company_reliability_track_your_order_title') }}</strong><br/><span style="font-size: 12px;color: #154058;">{{ translate('company_reliability_track_your_order_description') }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
