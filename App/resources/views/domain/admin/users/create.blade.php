<x-dashboard-layout
    :menuSettings="$menuSettings"
    :headerSettings="$headerSettings"
    :breadcrumb="$breadcrumb">

    @php
    //
    // @TODO
    // - [ ] Add js validation
    //
    $roles = [
        1 => 'Admin',
        2 => 'Simple',
        3 => 'None',
    ];
    @endphp

    <div class="container-lg p-0">
        <div class="card mb-4">
            <form method="POST" action="{{ route('admin.users.post-create') }}">
                @csrf
                <div class="card-header">
                    <strong>Create new user</strong>
                </div>

                <div class="card-body p-3">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="inputName">Name</label>
                            <input class="form-control" id="inputName" name="name"
                                   type="text" placeholder="Name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="inputEmail">Email</label>
                            <input class="form-control" id="inputEmail" name="email"
                                   type="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="inputPassword">Password</label>
                            <input class="form-control" id="inputPassword" name="password"
                                   type="password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="inputConfirmPassword">Confirm Password</label>
                            <input class="form-control" id="inputConfirmPassword" name="password_confirmation"
                                   type="password" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="inputSelectRole">Role</label>
                            <select class="form-select" id="inputSelectRole" size="4" name="role">
                                <option selected>Choose...</option>
                                @foreach ($roles as $roleValue => $roleName)
                                    <option value="{{ $roleValue }}">{{ $roleName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="inputSelectRole">Active</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active"
                                       role="switch" id="flexSwitchCheckChecked">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Activated this user</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <div class="col-12">
                        <button class="btn btn-primary btn-shadow" type="submit">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</x-dashboard-layout>