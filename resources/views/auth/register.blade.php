<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/popover.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>

</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="col-form-label">{{ __('Name') }}</label>

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="col-form-label ">{{ __('Email Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3">
                        <label for="store_type_id" class="form-label">Role</label>
                            <select class="form-select form-select-md" name="role" id="role">
                                
                                <option value="2">Carering</option>
                                <option value="3">Venu</option>
                                <option value="4">Chairity</option>
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                          
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="mb-0 d-flex">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Register') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
</body>
</html>

