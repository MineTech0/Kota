<div class="ptp-dark brand clearfix">
    <a href="{{route('home')}}">
        <h4 class="float-left text-white text-uppercase" style="margin:20px 0px 0px 20px">Kota</h4>
    </a>
    <span class="menu-btn"><i class="fas fa-bars"></i></span>
    <ul class="ts-profile-nav">

        <li class="ptp-light ts-account">
            <a> {{ Auth::user()->name }} <i class="fas fa-angle-down hidden-side"></i></a>
            <ul>
                <li><a href="/password/reset">Vaihda salasana</a></li>
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        Kirjaudu ulos
                    </a>
                </li>

            </ul>
        </li>
    </ul>
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</div>
