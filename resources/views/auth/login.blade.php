@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card auth-card col-5">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <h2 class="h4 text-primary auth-card__heading">Kérjük jelentkezz be!</h2>
                    <div class="form-group mx-2">
                        <label for="email">E-mail-cím</label>

                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" id="email" aria-describedby="emailHelp">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mx-2">
                        <label for="password">Jelszó</label>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group text-center mt-4 mb-0">
                        <button type="submit" class="btn btn-primary col-8">
                            Belépés
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link d-block" href="{{ route('password.request') }}">
                                Elfelejtettem a jelszavam!
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
