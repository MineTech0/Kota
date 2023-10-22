<nav class="ts-sidebar">
    <ul class="ts-sidebar-menu">

        <li class="ts-label">Menu</li>
        <li><a href="{{ route('home') }}"><i class="fas fa-list-alt fa-fw"></i> &nbsp;Info</a>
        </li>
        <li><a href="{{ route('feedback') }}"><i class="fas fa-envelope fa-fw"></i> &nbsp;Palaute</a>
        </li>
        <li><a href="{{ route('files') }}"><i class="fas fa-file fa-fw"></i> &nbsp;Tiedostot</a>
        </li>
        <li>
            <a href="{{ route('groups') }}"><i class="fas fa-users fa-fw"></i> &nbsp;Ryhmät</a>
            <div class="content">
                <a href="{{ route('groups') }}">&nbsp;Kaikki ryhmät</a>
            </div>
        </li>
        </li>
        @if (config('kota.show.loans'))
            <li><a href="{{ route('create.loan') }}"><i class="fas fa-box-open fa-fw"></i> &nbsp;Lainaus</a>
        @endif
        </li>
        @can('see_equipment')
            <li>
                <a><i class="fas fa-toolbox"></i> &nbsp;Huolto</a>
                <div class="content">
                    <a href="{{ route('index.equipment') }}">&nbsp;Varusteet</a>
                    @can('add_edit_delete_equipment')
                        <a href="{{ route('create.equipment') }}">&nbsp;Lisää varuste</a>
                    @endcan
                </div>
            </li>
        @endcan
        @canany(['see_own_group_expenses', 'see_group_expenses', 'add_own_group_expense', 'add_group_expense'])
        <li><a><i class="fas fa-money-bill fa-fw"></i> &nbsp;Kulut</a>
            <div class="content">
                @can('see_group_expenses')
                <a href="{{ route('expenses.index') }}">&nbsp;Kaikki kulut</a>
                @endcan
                @can('see_own_group_expenses')
                <a href="{{ route('group.expenses') }}">&nbsp;Omien ryhmien kulut</a>
                @endcan
                @canany(['add_own_group_expense', 'add_group_expense'])
                <a href="{{ route('group.expenses.create') }}">&nbsp;Lisää kuluja</a>
                @endcanany
            </div>
        </li>
        @endcanany
        @can('access_management')
            <li>
                <a><i class="fas fa-clipboard fa-fw"></i> &nbsp;Hallinto</a>
                <div class="content">
                    <a href="{{ route('management') }}"></i> &nbsp;Työkalut</a>
                    <a href="{{ route('index.users') }}"></i> &nbsp;Käyttäjät</a>
                    <a href="{{ route('create.invite') }}"></i> &nbsp;Kutsut</a>
                    <a href="{{ route('budget.index') }}"></i> &nbsp;Budjetti</a>
                </div>
            </li>
        @endcan
    </ul>
</nav>
