@unless ($breadcrumbs->isEmpty())
    <div class="flex items-center gap-2 text-sm">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$loop->last)
                <a href="{{ $breadcrumb->url }}"
                   class="text-red-700 font-medium hover:underline">
                    {{ $breadcrumb->title }}
                </a>
                <span class="text-slate-500">/</span>
            @else
                <span class="font-medium text-slate-500">{{ $breadcrumb->title }}</span>
            @endif
        @endforeach
    </div>
@endunless
