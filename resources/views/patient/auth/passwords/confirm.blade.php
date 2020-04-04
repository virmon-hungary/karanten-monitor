@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('patient.password.confirm') }}">
    @csrf

    <h2 class="h4 text-primary auth-card__heading">Kérjük erősítse meg jelszavát!</h2>

    <div class="form-group">
        <label for="password">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group text-center mb-0 mt-4">
        <button type="submit" class="btn btn-primary col-12 col-sm-8">
            {{ __('Confirm Password') }}
        </button>

        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
</form>
@endsection
