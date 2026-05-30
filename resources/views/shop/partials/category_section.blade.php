<section @if(!empty($id)) id="{{ $id }}" @endif class="ac-section ac-section--paper @if(!empty($extraClass)) {{ $extraClass }} @endif">
    <div class="container-fluid px-lg-5">
        <div class="section-head">
            <span class="section-eyebrow">{{ $eyebrow }}</span>
            <h2 class="section-title mb-0">{{ $title }}</h2>
        </div>
        <div class="ac-cat-grid">
                @foreach($categories as $category)
                <article class="category-card category-card--{{ $category->slug }}">
                    <div class="card-body p-4 text-start">
                        <div class="category-icon-wrap">
                            <img src="{{ asset('images/' . ($category->image ?? 'tire-placeholder.svg')) }}" alt="{{ $category->name }}">
                        </div>
                        <h3 class="h5 fw-bold mb-1">{{ $category->name }}</h3>
                        <p class="text-muted small mb-3">{{ $category->products_count }} позиций</p>
                        <a href="{{ route('products', ['category' => $category->slug]) }}" class="btn btn-accent btn-sm">Смотреть →</a>
                    </div>
                </article>
                @endforeach
        </div>
    </div>
</section>
