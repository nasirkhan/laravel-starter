<footer class="footer">
    <div class="container">
        <nav>
            <ul>
                <li>
                    <a href="/">
                        {{ config('app.name', 'Laravel Starter') }}
                    </a>
                </li>
                <li>
                    <a href="#">
                        About Us
                    </a>
                </li>
                @guest
                <li>
                    <a href="{{ route('frontend.auth.register') }}">
                        Register
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.auth.login') }}">
                        Login
                    </a>
                </li>
                @else
                <li>
                    <a href="#">
                        {{ Auth::user()->name }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.auth.logout') }}">
                        Logout
                    </a>
                </li>
                @endguest
            </ul>
        </nav>
        <div class="copyright">
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script> {{ config('app.name', 'Laravel Starter') }}, Built with ♥ by
            <a href="https://nasirkhn.com" target="_blank">Nasir Khan Saikat</a>
        </div>
    </div>
</footer>
