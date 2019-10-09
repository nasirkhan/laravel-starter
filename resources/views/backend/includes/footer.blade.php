<footer class="app-footer text-muted">
    <span>
        @if(setting('show_copyright'))
        Copyright &copy; {{ date('Y') }}
        @endif
        <a href="/">{{app_name()}}</a>
    </span>
    <span class="ml-auto" style="">{!! setting('footer_text') !!}</span>
</footer>
