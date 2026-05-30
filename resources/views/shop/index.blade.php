@extends('shop.layouts.app')

@section('title', 'Главная')

@section('content')
<section class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="hero-badge mb-3"><i class="fas fa-bolt"></i> Официальный магазин</span>
                <h1 class="hero-title">
                    Резина и диски,<br><span class="hero-highlight">которые держат дорогу</span>
                </h1>
                <p class="lead mb-4" style="max-width: 480px;">Шины и диски с доставкой по России. Подбор, монтаж и гарантия — в одном месте.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products') }}" class="btn btn-lg btn-glow px-4 rounded-0">
                        <i class="fas fa-arrow-right me-2"></i>В каталог
                    </a>
                    <a href="#categories" class="btn btn-lg btn-ghost-light px-4 rounded-0">Категории</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat"><strong>500+</strong><span>моделей</span></div>
                    <div class="hero-stat"><strong>24ч</strong><span>отправка</span></div>
                    <div class="hero-stat"><strong>7 лет</strong><span>опыта</span></div>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="{{ asset('images/tire-placeholder.svg') }}" alt="Шины и диски" class="img-fluid hero-tire-glow" style="max-height: 360px;">
            </div>
        </div>
    </div>
</section>

@include('shop.partials.category_section', [
    'id' => 'categories',
    'eyebrow' => 'Ассортимент',
    'title' => 'Категории',
    'categories' => $categories,
])

<section class="ac-section ac-section--benefits">
    <div class="container-fluid px-lg-5">
        <div class="section-head text-center text-lg-start">
            <span class="section-eyebrow">Преимущества</span>
            <h2 class="section-title">Почему Autoclub</h2>
            <p class="section-subtitle mx-lg-0">Всё для комфортной и безопасной езды</p>
        </div>
        <div class="ac-bento">
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fas fa-certificate"></i></div>
                <h4 class="fw-bold mb-2">Оригинальная продукция</h4>
                <p class="mb-0 text-muted small">Сертифицированные шины и диски от официальных поставщиков.</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon benefit-icon--blue"><i class="fas fa-truck-fast"></i></div>
                <h4 class="fw-bold mb-2">Быстрая доставка</h4>
                <p class="mb-0 text-muted small">Отправка в день оформления по городу и регионам.</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon benefit-icon--green"><i class="fas fa-wrench"></i></div>
                <h4 class="fw-bold mb-2">Шиномонтаж</h4>
                <p class="mb-0 text-muted small">Установка и балансировка на собственном сервисе.</p>
            </div>
        </div>
    </div>
</section>
@endsection
