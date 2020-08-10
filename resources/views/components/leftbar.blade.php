<nav class="ts-sidebar">
    <ul class="ts-sidebar-menu">
    
    <li class="ts-label">Menu</li>
    <li><a href="{{route('home')}}"><i class="fa fa-list-alt"></i> &nbsp;Info</a>
    </li>
    <li><a href="{{route('feedback')}}"><i class="fa fa-envelope"></i> &nbsp;Palaute</a>
    </li>
    <li><a href="{{route('files')}}"><i class="fa fa-file"></i> &nbsp;Tiedostot</a>
    </li>
    <li><a href="{{route('groups')}}"><i class="fa fa-users"></i> &nbsp;Ryhmät</a>
    </li>
    </li>
    <li><a href="{{route('create.equipment')}}"><i class="fa fa-users"></i> &nbsp;Lainaus</a>
    </li>
    @can('access_management')
    <li><a href="{{route('management')}}"><i class="fa fa-clipboard"></i> &nbsp;Hallinto</a>    
    </li>
    @endcan
    </ul>
</nav>
