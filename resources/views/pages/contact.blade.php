@extends('layouts.app')

@section('meta_title', $meta['title'])
@section('meta_description', $meta['description'])

@section('content')

<section class="sp-hero">
    <div class="container">
        <div class="sp-hero-eyebrow"><i class="bi bi-envelope"></i> Get In Touch</div>
        <h1>Contact <em>{{ config('app.name') }}</em></h1>
        <p class="sp-hero-sub">
            Questions about a coupon, a partnership inquiry, or something else — we'd love to hear from you.
        </p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container" style="max-width:900px">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 bg-light h-100 text-center py-4 px-3">
                    <div class="fs-2 mb-2">🤝</div>
                    <div class="fw-semibold mb-1">Partnerships & Sponsors</div>
                    <div class="text-muted small">Want your brand in the sponsor bar or a featured placement? Reach out.</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light h-100 text-center py-4 px-3">
                    <div class="fs-2 mb-2">🏷️</div>
                    <div class="fw-semibold mb-1">Coupon Corrections</div>
                    <div class="text-muted small">Found an expired or incorrect code? Let us know and we'll fix it fast.</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light h-100 text-center py-4 px-3">
                    <div class="fs-2 mb-2">💬</div>
                    <div class="fw-semibold mb-1">General Support</div>
                    <div class="text-muted small">Anything else on your mind — questions, feedback, or suggestions.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sp-contact">
    <div class="container">
        <h2>Email us directly</h2>
        <p>We read every message and reply within 1 business day.</p>
        <a href="mailto:{{ $email }}" class="sp-contact-btn">
            <i class="bi bi-envelope"></i> {{ $email }}
        </a>
    </div>
</section>

@endsection
