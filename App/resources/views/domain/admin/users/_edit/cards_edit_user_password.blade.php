<div class="card mb-4">
    <form method="POST" action="{{ route('admin.users.update', ['user' => $user]) }}">
        @csrf
        @method('patch')
        <input type="hidden" name="update_form" value="password"/>
        <div class="card-header bg-info text-white">
            <strong>Change User Password</strong>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="inputPassword">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="inputPassword"
                           name="password"
                           minlength="8" maxlength="255"
                           type="password" required>
                    <small class="form-text text-muted">
                        {{ $errors->first('password') }}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="inputConfirmPassword">Confirm Password</label>
                    <input class="form-control @error('password_confirmation') is-invalid @enderror"
                           id="inputConfirmPassword" name="password_confirmation"
                           minlength="8" maxlength="255"
                           type="password" required>
                    <small class="form-text text-muted">
                        {{ $errors->first('password_confirmation') }}
                    </small>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <div class="col-12">
                <button class="btn btn-primary bg-info btn-shadow" type="submit">Change Password</button>
            </div>
        </div>
    </form>
</div>
