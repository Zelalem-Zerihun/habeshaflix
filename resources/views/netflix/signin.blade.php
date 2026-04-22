<x-layouts.netflix title="Sign in - HabeshaFlix">
    <header class="nf-header nf-header-landing">
        <a class="nf-logo" href="{{ route('landing') }}">HABESHAFLIX</a>
    </header>

    <main class="nf-signin">
        <form class="nf-form" action="#" method="post">
            <h1>Sign In</h1>
            <label>
                <span>Email</span>
                <input type="email" placeholder="you@example.com">
            </label>
            <label>
                <span>Password</span>
                <input type="password" placeholder="********">
            </label>
            <button class="nf-btn nf-btn-danger" type="submit">Sign In</button>
            <p>New to HabeshaFlix? <a href="{{ route('landing') }}">Start now.</a></p>
        </form>
    </main>
</x-layouts.netflix>
