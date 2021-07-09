    <footer class="ps-footer onlydesktop">
        <div class="ps-container">
   

        <div class="ps-footer__widgets">
@php
    $widget1=Front::GetWidget('footer-widget1');
    $widget2=Front::GetWidget('footer-widget2');
    $widget3=Front::GetWidget('footer-widget3');
    $widget4=Front::GetWidget('footer-widget4');
    $widget5=Front::GetWidget('footer-app');
    $copyright=Front::GetWidget('footer__copyright');

    


//dd($widget1->body);
@endphp
            
                
                @if(isset($widget1))
                {!! $widget1->getTranslation('body',App::getLocale()) !!}
                @endif

                @if(isset($widget2))
                {!! $widget2->getTranslation('body',App::getLocale()) !!}
                @endif
                @if(isset($widget3))
                {!! $widget3->getTranslation('body',App::getLocale()) !!}
                @endif
                @if(isset($widget4))
                {!! $widget4->getTranslation('body',App::getLocale()) !!}
                @endif
                @if(isset($widget5))
                {!! $widget5->getTranslation('body',App::getLocale()) !!}
                @endif
            
                {{-- 
                <aside class="widget widget_footer col-3">
                    <h4 class="widget-title">Quick links 2 </h4>
                    <ul class="ps-list--link">
                        <li><a href="#">Policy 2 </a></li>
                        <li><a href="#">Term & Condition 2 </a></li>
                        <li><a href="#">Shipping 2 </a></li>
                        <li><a href="#">Return 2 </a></li>
                        <li><a href="faqs.html">FAQs 2 </a></li>
                    </ul>
                </aside>


               <aside class="widget widget_footer col-3">
                    <h4 class="widget-title">Quick links 2 </h4>
                    <ul class="ps-list--link">
                        <li><a href="#">Policy 2 </a></li>
                        <li><a href="#">Term & Condition 2 </a></li>
                        <li><a href="#">Shipping 2 </a></li>
                        <li><a href="#">Return 2 </a></li>
                        <li><a href="faqs.html">FAQs 2 </a></li>
                    </ul>
                </aside>
                <aside class="widget widget_footer col-3">
                    <h4 class="widget-title">Quick links 2 </h4>
                    <ul class="ps-list--link">
                        <li><a href="#">Policy 2 </a></li>
                        <li><a href="#">Term & Condition 2 </a></li>
                        <li><a href="#">Shipping 2 </a></li>
                        <li><a href="#">Return 2 </a></li>
                        <li><a href="faqs.html">FAQs 2 </a></li>
                    </ul>
                </aside>
                <aside class="widget widget_footer col-3">
                    <h4 class="widget-title">Quick links old</h4>
                    <ul class="ps-list--link">
                        <li><a href="#">Policy</a></li>
                        <li><a href="#">Term & Condition</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Return</a></li>
                        <li><a href="faqs.html">FAQs</a></li>
                    </ul>
                </aside>

                <aside class="widget widget_footer col-3">
                    <h4 class="widget-title">Company</h4>
                    <ul class="ps-list--link">
                        <li><a href="about-us.html">About Us</a></li>
                        <li><a href="#">Affilate</a></li>
                        <li><a href="#">Career</a></li>
                        <li><a href="contact-us.html">Contact</a></li>
                    </ul>
                </aside>
                <aside class="widget widget_footer col-3">
                    <h4 class="widget-title">Bussiness</h4>
                    <ul class="ps-list--link">
                        <li><a href="#">Our Press</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="my-account.html">My account</a></li>
                        <li><a href="shop-default.html">Shop</a></li>
                    </ul>
                </aside>

                  <aside class="widget widget_footer col-3">
                    <h4 class="widget-title">Quick links</h4>
                    <ul class="ps-list--link">
                        <li><a href="#">Policy</a></li>
                        <li><a href="#">Term & Condition</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Return</a></li>
                        <li><a href="faqs.html">FAQs</a></li>
                    </ul>
                </aside>
            
              <aside class="widget widget_footer col-3 widget_contact-us">
                    <h4 class="widget-title">Contact Us</h4>
                    <div class="widget_content">
                        <p>Call us 24/7</p>
                        <h3>9876 543 210</h3>
                        <p>#123 ABC city state country 101010 <br><a
                                href="https://www.websoftgeeks.com/">support@abboda.com</a>
                        </p>
                        <ul class="ps-list--social">
                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </aside> --}}
            </div>
            {{-- <div class="ps-footer__links">
                <p><strong>Consumer Electric:</strong><a href="#">Air Conditioners</a><a href="#">Audios &amp;
                        Theaters</a><a href="#">Car Electronics</a><a href="#">Office Electronics</a><a href="#">TV
                        Televisions</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Others</a>
                </p>
                <p><strong>Clothing &amp; Apparel:</strong><a href="#">Printers</a><a href="#">Projectors</a><a
                        href="#">Scanners</a><a href="#">Store &amp; Business</a><a href="#">4K Ultra HD TVs</a><a
                        href="#">LED
                        TVs</a><a href="#">OLED TVs</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Others</a>
                </p>
                <p><strong>Home, Garden &amp; Kitchen:</strong><a href="#">Cookware</a><a href="#">Decoration</a><a
                        href="#">Furniture</a><a href="#">Garden Tools</a><a href="#">Garden Equipments</a><a
                        href="#">Powers And
                        Hand Tools</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Others</a>
                </p>
                <p><strong>Health &amp; Beauty:</strong><a href="#">Hair Care</a><a href="#">Decoration</a><a
                        href="#">Hair
                        Care</a><a href="#">Makeup</a><a href="#">Body Shower</a><a href="#">Skin
                        Care</a><a href="#">Cologine</a><a href="#">Perfume</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Others</a>
                </p>
                <p><strong>Jewelry &amp; Watches:</strong><a href="#">Necklace</a><a href="#">Pendant</a><a
                        href="#">Diamond
                        Ring</a><a href="#">Sliver Earing</a><a href="#">Leather Watcher</a><a href="#">Gucci</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Others</a>
                </p>
                <p><strong>Computer &amp; Technologies:</strong><a href="#">Desktop PC</a><a href="#">Laptop</a><a
                        href="#">Smartphones</a><a href="#">Tablet</a><a href="#">Game Controller</a><a href="#">Audio
                        &amp;
                        Video</a><a href="#">Wireless Speaker</a><a href="#">Done</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Washing Machines</a>
                    <a href="#">Others</a>
                </p>
            </div> --}}
            <div class="ps-footer__copyright">
                 @if(isset($copyright))
                {!! $copyright->getTranslation('body',App::getLocale()) !!}
                @endif
                
                {{-- <p><span>We Using Safe Payment For:</span><a href="#"><img src="{{ asset('img/payment-method/1.jpg') }}" alt=""></a><a
                        href="#"><img src="{{ asset('img/payment-method/2.jpg') }}" alt=""></a><a href="#"><img
                            src="img/payment-method/3.jpg" alt=""></a><a href="#"><img src="img/payment-method/4.jpg"
                            alt=""></a><a href="#"><img src="{{ asset('img/payment-method/5.jpg') }}" alt=""></a></p> --}}
            </div>
        </div>
    </footer>
