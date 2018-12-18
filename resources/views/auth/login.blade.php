@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card-group">
        <div class="card text-white bg-primary py-5 d-md-down-none">
          <img height="200px" src="https://www.ebpearls.com.au/wp-content/uploads/2017/08/ebpearls1.svg" alt=""/>
        </div>
        <div class="card p-4">
          <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <h1>Login</h1>
              <p class="text-muted">Sign In to your account</p>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-user"></i>
                    </span>
                </div>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       name="email" value="{{ old('email') }}"/>
                @if ($errors->has('email'))
                  <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-lock"></i>
                    </span>
                </div>
                <input id="password" type="password"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                @if ($errors->has('password'))
                  <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="submit" class="btn btn-primary px-4">Login</button>
                </div>
                <div class="col-6 text-right">
                  <a href="{{ route('password.request') }}" class="btn btn-link px-0">Forgot password?</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
