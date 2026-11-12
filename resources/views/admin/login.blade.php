<x-layouts.admin title="Sign in" bare>
    <div class="login-card">
        <div class="login-brand">
            <img src="{{ asset('images/logo-reversed.svg') }}" alt="{{ config('site.legal_name') }}">
        </div>
        <div class="login-body">
        <h1>Sign in</h1>
        <p class="muted">Quote requests for {{ config('site.name') }}.</p>

        <form method="POST" action="{{ route('admin.login.store') }}" class="login-form">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>
            <label class="check"><input type="checkbox" name="remember" value="1"> Keep me signed in on this device</label>
            <button class="btn btn-primary" type="submit">Sign in</button>
        </form>
        </div>
    </div>
</x-layouts.admin>
