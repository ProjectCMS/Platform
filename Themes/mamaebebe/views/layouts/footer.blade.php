<div class="container d-none d-lg-block">
    <ul class="social-footer list-inline">
        @if(setting('social_network.facebook'))
            <li class="facebook">
                <a href="{{ setting('social_network.facebook') }}" target="_blank">
                    <i class="fa fa-facebook"></i>
                    <h3>Facebook</h3>
                    <span>Siga-nos no Facebook</span>
                </a>
            </li>
        @endif

        @if(setting('social_network.twitter'))
            <li class="twitter">
                <a href="{{ setting('social_network.twitter') }}" target="_blank">
                    <i class="fa fa-twitter"></i>
                    <h3>Twitter</h3>
                    <span>Siga-nos no Twitter</span>
                </a>
            </li>
        @endif

        @if(setting('social_network.gplus'))
            <li class="googlep">
                <a href="{{ setting('social_network.gplus') }}" target="_blank">
                    <i class="fa fa-google-plus"></i>
                    <h3>Google+</h3>
                    <span>Siga-nos no Google</span>
                </a>
            </li>
        @endif

        @if(setting('social_network.instagram'))
            <li class="instagram">
                <a href="{{ setting('social_network.instagram') }}" target="_blank">
                    <i class="fa fa-instagram"></i>
                    <h3>Instagram</h3>
                    <span>Siga-nos no Instagram</span>
                </a>
            </li>
        @endif

        @if(setting('social_network.pinterest'))
            <li class="pinterest">
                <a href="{{ setting('social_network.pinterest') }}" target="_blank">
                    <i class="fa fa-pinterest"></i>
                    <h3>Pinterest</h3>
                    <span>Siga-nos no Pinterest</span>
                </a>
            </li>
        @endif
    </ul>
</div>

<footer class="footer">
    <div class="top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <div class="collapse navbar-collapse">
                        @include('partials.menu.footer.item')
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <img src="{{ image_resize('filemanager/logo-w.png', 60, NULL, 100) }}" height="50">
    <div class="copyright">
        <div class="container">
            <span>© {{ date('Y') }} - {!! config('dashboard.logo', '') !!} - Todos os direitos reservados</span>
        </div>
    </div>
</footer>