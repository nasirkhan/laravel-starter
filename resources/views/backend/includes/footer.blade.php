<footer class="c-footer text-muted">
    <div>
        <a href="/">{{app_name()}}</a>
        @if(setting('show_copyright'))
        Copyright &copy; {{ date('Y') }}
        @endif
    </div>
    <div class="ml-auto">{!! setting('footer_text') !!}</div>
</footer>