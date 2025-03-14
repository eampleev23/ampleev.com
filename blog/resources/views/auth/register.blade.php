@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>
                            <script type="text/javascript">
                                if ('VKIDSDK' in window) {
                                    const VKID = window.VKIDSDK;

                                    VKID.Config.init({
                                        app: 53261431,
                                        redirectUrl: 'https://ampleev.com/redirect-vk',
                                        responseMode: VKID.ConfigResponseMode.Callback,
                                        source: VKID.ConfigSource.LOWCODE,
                                        scope: '', // Заполните нужными доступами по необходимости
                                    });

                                    const oneTap = new VKID.OneTap();

                                    oneTap.render({
                                        container: document.currentScript.parentElement,
                                        showAlternativeLogin: true,
                                        styles: {
                                            height: 38
                                        },
                                        oauthList: [
                                            'ok_ru',
                                            'mail_ru'
                                        ]
                                    })
                                        .on(VKID.WidgetEvents.ERROR, vkidOnError)
                                        .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {
                                            const code = payload.code;
                                            const deviceId = payload.device_id;

                                            VKID.Auth.exchangeCode(code, deviceId)
                                                .then(vkidOnSuccess)
                                                .catch(vkidOnError);
                                        });

                                    function vkidOnSuccess(data) {
                                        // Обработка полученного результата
                                    }

                                    function vkidOnError(error) {
                                        // Обработка ошибки
                                    }
                                }
                            </script>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
