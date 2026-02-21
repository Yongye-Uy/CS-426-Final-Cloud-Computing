<!-- Testimonials Section -->
<section id="testimonials" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What Our Clients Say</h2>
            <p class="lead text-muted">Trusted by nonprofits and charities worldwide</p>
        </div>
        
        <div class="row g-4">
            @forelse($testimonials ?? [] as $testimonial)
            <div class="col-lg-4">
                <div class="card h-100 p-4">
                    <div class="text-center mb-4">
                        <img src="https://randomuser.me/api/portraits/{{ rand(0, 1) ? 'men' : 'women' }}/{{ rand(1, 99) }}.jpg" class="testimonial-img mb-3">
                        <div class="d-flex justify-content-center text-warning mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($testimonial->rating))
                                    <i class="fas fa-star"></i>
                                @elseif ($i == floor($testimonial->rating) + 1 && ($testimonial->rating - floor($testimonial->rating)) >= 0.5)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <h5 class="mb-1">{{ $testimonial->donor_name }}</h5>
                        <small class="text-muted">{{ $testimonial->donor_title }}</small>
                    </div>
                    <p class="text-muted">"{{ $testimonial->content }}"</p>
                </div>
            </div>
            @empty
            <div class="col-lg-4">
                <div class="card h-100 p-4">
                    <div class="text-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" class="testimonial-img mb-3">
                        <div class="d-flex justify-content-center text-warning mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h5 class="mb-1">Sarah Johnson</h5>
                        <small class="text-muted">Director, Hearts for Hope</small>
                    </div>
                    <p class="text-muted">"{{ config('app.name') }} has transformed how we manage our donations. The real-time tracking and automated receipts have saved us countless hours."</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 p-4">
                    <div class="text-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" class="testimonial-img mb-3">
                        <div class="d-flex justify-content-center text-warning mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h5 class="mb-1">Michael Chen</h5>
                        <small class="text-muted">Founder, Community Care</small>
                    </div>
                    <p class="text-muted">"The analytics dashboard gives us insights we never had before. We can now identify trends and optimize our fundraising campaigns effectively."</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 p-4">
                    <div class="text-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/28.jpg" class="testimonial-img mb-3">
                        <div class="d-flex justify-content-center text-warning mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h5 class="mb-1">Emily Rodriguez</h5>
                        <small class="text-muted">Executive Director, Green Future</small>
                    </div>
                    <p class="text-muted">"Our donors love the transparency and the detailed reports. The system has helped us build stronger relationships with our supporters."</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section> 