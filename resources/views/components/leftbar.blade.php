<nav class="ts-sidebar">
    <ul class="ts-sidebar-menu">
    
    <li class="ts-label">Menu</li>
    <li><a href="{{route('home')}}"><i class="fas fa-list-alt fa-fw"></i> &nbsp;Info</a>
    </li>
    <li><a href="{{route('feedback')}}"><i class="fas fa-envelope fa-fw"></i> &nbsp;Palaute</a>
    </li>
    <li><a href="{{route('files')}}"><i class="fas fa-file fa-fw"></i> &nbsp;Tiedostot</a>
    </li>
    <li><a href="{{route('groups')}}"><i class="fas fa-users fa-fw"></i> &nbsp;Ryhmät</a>
    </li>
    </li>
    <li><a href="{{route('create.loan')}}"><i class="fas fa-box-open fa-fw"></i> &nbsp;Lainaus</a>
    </li>
    @can('access_management')
    <li><a href="{{route('expenses.index')}}"><i class="fas fa-money-bill fa-fw"></i> &nbsp;Kulut</a>    
    </li>
    <li><a href="{{route('management')}}"><i class="fas fa-clipboard fa-fw"></i> &nbsp;Hallinto</a>    
    </li>
    @endcan
    </ul>
</nav>
