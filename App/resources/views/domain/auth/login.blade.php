<x-auth-layout>
    <x-auth.card-group>

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('Authentication Failed!') }}</strong> {{ $message }}
                <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
            </div>
    @endif

    <!-- SignIn form card -->
        <div class="card col-md-7 p-4 mb-0">
            <div class="card-body">
                <h1 class="card-title">Login</h1>
                <p class="card-text">Sign In to your account</p>
                <form method="POST" class="needs-validation" action="{{ route('guest.login') }}" novalidate>
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <x-auth.svg-icon :icon="'cil-user'"></x-auth.svg-icon>
                        </span>
                        <input class="form-control" type="email" name="email"
                               placeholder="{{ __('E-Mail Address') }}"
                               value="{{ old('email') }}"
                               required autofocus>
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text">
                            <x-auth.svg-icon :icon="'cil-lock-locked'"></x-auth.svg-icon>
                        </span>
                        <input class="form-control" type="password" name="password"
                               placeholder="{{ __('Password') }}"
                               minlength="8" maxlength="255"
                               required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary px-4 btn-shadow" type="submit">{{ __('Login') }}</button>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('guest.password.request') }}" class="btn btn-link px-0"
                               type="button">{{ __('Forgot Your Password?') }}</a>
                        </div>
                    </div>
                    <x-auth.validation-errors class="callout callout-danger" :errors="$errors"/>
                </form>
            </div>
        </div>

        <!-- SignUp link card -->
        <div class="card col-md-5 text-white bg-primary py-5">
            <div class="card-body text-center">
                <div>
                    <h2>Sign up</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                    @if (Route::has('password.request'))
                        <a href="{{ route('register') }}"
                           class="btn btn-lg btn-outline-light mt-3">{{ __('Register') }}</a>
                    @endif
                </div>
            </div>
        </div>

        <script type="text/javascript">
            (function () {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.querySelectorAll('.needs-validation')

                // Loop over them and prevent submission
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>

    </x-auth.card-group>
</x-auth-layout>
