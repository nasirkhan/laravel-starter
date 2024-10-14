<footer class="footer mt-4 px-4">
    <div>
        @if (setting("show_copyright"))
            <small>
                @lang("Copyright")
                &copy; {{ date("Y") }}
                <a class="text-muted" href="/">{{ app_name() }}</a>
            </small>
        @endif
    </div>
    <div class="ms-auto"><small>{!! setting("footer_text") !!}</small></div>
</footer>
