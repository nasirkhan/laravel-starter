<footer class="c-footer text-muted">
    <div>
        <a href="/">{{app_name()}}</a>
        @if(setting('show_copyright'))
        @lang('Copyright') &copy; {{ date('Y') }}
        @endif
    </div>
    <div class="ml-auto text-muted">{!! setting('footer_text') !!}</div>
</footer>
