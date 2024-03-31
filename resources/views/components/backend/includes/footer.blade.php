<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="row align-items-center flex-row-reverse text-center">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a class="link-secondary"
                            href="https://github.com/nasirkhan/laravel-starter" target="_blank"
                            rel="noopener">Documentation</a></li>
                    <li class="list-inline-item"><a class="link-secondary" href="#">License</a></li>
                    <li class="list-inline-item">
                        {!! setting('footer_text') !!}
                    </li>
                </ul>
            </div>
            @if (setting('show_copyright'))
                <div class="col-12 col-lg-auto mt-lg-0 mt-3">
                    <ul class="list-inline list-inline-dots mb-0">
                        <li class="list-inline-item">
                            <a class="text-muted" href="/">{{ app_name() }}</a>.

                            &copy; {{ date('Y') }}, All rights reserved.

                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</footer>
