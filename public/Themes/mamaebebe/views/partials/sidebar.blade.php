<div class="col-lg-4">
    <aside class="sidebar">
        <div class="widgets">
            <div class="mb-3">
                <div class="ads box" data-ads="box"></div>
            </div>
            @yield('custom_widget')
            <div class="widget">
                <div class="title">Categorias <span>populares</span></div>
                <ul class="categories list-inline">
                    @foreach($categoryPosts as $category)
                        <li>
                            <a href="{{ route('web.posts.category', $category->slug) }}" title="{{ $category->title }}">
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

            <div class="widget">
                <div class="title">Revista Mamãe Bebê</div>
                <div class="fb-page" data-href="https://www.facebook.com/RevistaMamaeBebe/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/RevistaMamaeBebe/" class="fb-xfbml-parse-ignore">
                        <a href="https://www.facebook.com/RevistaMamaeBebe/">Revista Mamãe Bebê</a></blockquote>
                </div>
            </div>

            {{--<div class="mt-3">--}}
            {{--<div class="newsletter">--}}
            {{--<h2>Newsletter</h2>--}}
            {{--<span>Não perca nada! <br>Inscreva-se para receber notícias</span>--}}
            {{--<form>--}}
            {{--<div class="form-group">--}}
            {{--<input type="email" class="form-control" placeholder="Informe seu e-mail">--}}
            {{--</div>--}}
            {{--<button type="submit" class="btn btn-info btn-block">Inscrever-se</button>--}}
            {{--</form>--}}
            {{--</div>--}}
            {{--</div>--}}
        </div>
    </aside>
</div>