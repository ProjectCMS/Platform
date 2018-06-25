<div class="col">
    <aside class="sidebar">
        <div class="widgets">
            <div class="mb-3">
                <div class="ads mid"></div>
            </div>
            <div class="widget">
                <div class="title">Siga-nos nas <span>redes sociais</span></div>
                <ul class="social list-inline">
                    <li><a href="" class="facebook"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="" class="twitter"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="" class="googlep"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="" class="pinterest"><i class="fa fa-pinterest"></i></a></li>
                </ul>
            </div>
            @yield('custom_widget')
            <div class="widget">
                <div class="title">Categorias <span>populares</span></div>
                <ul class="categories list-inline">
                    @foreach($postsCategory as $category)
                        <li>
                            <a href="{{ route('web.posts.category', $category->slug) }}">
                                <span>{{ $category->title }}</span>
                                @if($category->image != NULL)
                                    <img src="{{ asset('storage/'.$category->image) }}" class="no-image">
                                @else
                                    <img src class="no-image">
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-3">
                <div class="newsletter">
                    <h2>Newsletter</h2>
                    <span>Não perca nada! <br>Inscreva-se para receber notícias</span>
                    <form>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Informe seu e-mail">
                        </div>
                        <button type="submit" class="btn btn-info btn-block">Inscrever-se</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>
</div>