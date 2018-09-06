<div class="dropdown">
    <span class="nav-link" id="myAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Minha conta <i class="fa fa-angle-down" aria-hidden="true"></i></span>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="myAccount">
        <a class="dropdown-item" href="{{ route('web.clients.account.home') }}">
            <span>Meu Peril</span>
            {{ $client->email }}
            <i class="fa fa-user"></i></a>
        <a class="dropdown-item" href="{{ route('web.clients.account.profile') }}">Configurações <i class="fa fa-cogs"></i></a>
        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout <i class="fa fa-sign-out"></i></a>
        <form id="logout-form" action="{{ route('web.clients.logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</div>