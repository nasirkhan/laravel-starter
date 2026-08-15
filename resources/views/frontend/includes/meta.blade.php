@php
    use Laravel\Head\Enums\OgType;
    use Laravel\Head\Facades\Head;

    $meta_page_type ??= 'website';

    // Override the default og:type and set article/profile-specific properties.
    // The common tags (og:url, og:title, og:description, og:image, og:site_name,
    // twitter:*, canonical) are already handled by Head::defaults() in CubeServiceProvider.
    if ($meta_page_type === 'article' && isset($module_name_singular)) {
        $subject = $$module_name_singular ?? null;

        if ($subject) {
            Head::og(type: OgType::Article);

            if (! empty($subject->published_at)) {
                Head::meta('article:published_time', (string) $subject->published_at);
            }
            if (! empty($subject->updated_at)) {
                Head::meta('article:modified_time', (string) $subject->updated_at);
            }

            $authorName = $subject->created_by_alias ?? $subject->created_by_name ?? null;
            if ($authorName) {
                Head::meta('article:author', (string) $authorName);
            }
            if (! empty($subject->category_name)) {
                Head::meta('article:section', (string) $subject->category_name);
            }
        }
    } elseif ($meta_page_type === 'profile' && isset($module_name_singular)) {
        $subject = $$module_name_singular ?? null;

        if ($subject) {
            Head::og(type: OgType::Profile);

            if (! empty($subject->first_name)) {
                Head::meta('profile:first_name', (string) $subject->first_name);
            }
            if (! empty($subject->last_name)) {
                Head::meta('profile:last_name', (string) $subject->last_name);
            }
            if (! empty($subject->email)) {
                Head::meta('profile:username', (string) $subject->email);
            }
            if (! empty($subject->gender)) {
                Head::meta('profile:gender', (string) $subject->gender);
            }
        }
    }
@endphp

{{-- Static tags preserved for discoverability/authorship --}}
<link type="text/plain" rel="author" href="{{ asset('humans.txt') }}" />
<meta name="generator" content="Laravel Starter - A CMS like modular Laravel starter project." />

{{-- article:tag requires multiple <meta> with the same property name; Head deduplicates
     same-key meta calls so these are pushed to a stack rendered after @head. --}}
@if ($meta_page_type === 'article' && isset($module_name_singular) && isset($$module_name_singular))
    @foreach (($$module_name_singular->tags ?? []) as $tag)
        @push('head-meta')
            <meta property="article:tag" content="{{ $tag->name }}" />
        @endpush
    @endforeach
@endif
