<x-dashboard-layout :breadcrumb="$breadcrumb">

    @php
        $rolesBadge = [
            'root' => 'bg-primary',
            'admin' => 'bg-success',
            'simple' => 'bg-light text-dark',
        ];
    @endphp

    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @elseif ($message = Session::get('failed'))
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @endif

    <div class="container-fluid p-0">
        <div class="card mb-4">

            <!-- card header -->
            <div class="card-header">
                <strong><i class="fas fa-users"></i> User Management</strong><span class="small ms-1 text-medium-emphasis">(total {{ $users->count() }} users)</span>
            </div>

            <!-- card body -->
            <div class="card-body p-3">
                <div class="d-flex">

                    <div class="flex-grow-1 p-0">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-shadow bg-primary mb-3">
                            Create New User
                        </a>
                    </div>

                    <div class="ms-auto p-0">
                        <form method="GET" action="{{ route('admin.users.index') }}">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="search" placeholder="Search email">
                                <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">

                        @include('domain.admin.users._index.thead_with_sort_icons')

                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="p-0 align-middle text-center" style="min-width: 24px;">
                                    <a href="{{ route('admin.users.show', ['user' => $user]) }}">
                                        <svg class="icon icon-sm text-primary">
                                            <use xlink:href="{{ asset('/icons/sprites/free.svg') }}#cil-search"/>
                                        </svg>
                                    </a>
                                </td>
                                <td class="p-0 align-middle text-center" style="min-width: 24px;">
                                    <a href="{{ route('admin.users.edit', ['user' => $user]) }}">
                                        <svg class="icon icon-sm text-primary">
                                            <use xlink:href="{{ asset('/icons/sprites/free.svg') }}#cil-pen"/>
                                        </svg>
                                    </a>
                                </td>
                                <td class="p-0 align-middle text-center text-lowercase">
                                    @if ($user->isActive())
                                        <label class="badge rounded-pill bg-info">
                                            Active
                                        </label>
                                    @else
                                        <label class="badge rounded-pill bg-light">
                                            Deactive
                                        </label>
                                    @endif
                                </td>
                                <td class="{{ !$user->isActive() ? 'text-black-50 text-decoration-line-through' : '' }}">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge rounded-pill {{ $rolesBadge[$v] ?? '' }}">
                                                {{ $v }}
                                            </label>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="font-monospace">{{ $user->created_at }}</td>
                                <td class="font-monospace">{{ $user->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- card footer -->
            <div class="card-footer">
                @include('domain.admin.users._index.paging')
            </div>

        </div>
    </div>

</x-dashboard-layout>
