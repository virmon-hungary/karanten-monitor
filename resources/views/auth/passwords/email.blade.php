@extends('layouts.auth')

@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <h2 class="h4 text-primary auth-card__heading">Elfelejtett jelszó</h2>

    <div class="form-group">
        <label for="email">{{ __('E-Mail Address') }}</label>

        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group text-center mb-0 mt-4">
        <button type="submit" class="btn btn-primary col-12 col-sm-8">
            {{ __('Send Password Reset Link') }}
        </button>
    </div>
</form>
@endsection
