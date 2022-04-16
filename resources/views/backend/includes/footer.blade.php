<footer class="footer text-sm">
    <div>
        <a href="/">{{app_name()}}</a>.
        @if(setting('show_copyright'))
        @lang('Copyright') &copy; {{ date('Y') }}
        @endif
    </div>
    <div class="ms-auto">{!! setting('footer_text') !!}</div>
</footer>