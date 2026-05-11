
@include('userheader')
<!-- HERO SLIDER -->
<div class="hero">
  <div class="hero-slide active" id="slide-0">
    <div class="hero-bg" style="background: linear-gradient(135deg, #2d1b18 0%, #5c2d35 50%, #8b4a55 100%);"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <div class="hero-tag">New Collection — Summer 2025</div>
      <div class="hero-title">
        Beauty That<br><em>Speaks</em> For You
      </div>
      <div class="hero-sub">Discover luxurious skincare & makeup crafted for every Indian skin tone. Vegan. Cruelty-free. Radiance-first.</div>
      <div class="hero-btns">
        <a href="#" class="btn-primary">Shop Collection</a>
        <a href="#" class="btn-outline">Explore Skincare</a>
      </div>
    </div>
  </div>
  <div class="hero-slide" id="slide-1">
    <div class="hero-bg" style="background: linear-gradient(135deg, #1a2b2e 0%, #1d5a52 50%, #2d8a7c 100%);"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <div class="hero-tag">Best Seller — Hyaluronic Glow Serum</div>
      <div class="hero-title">
        Hydrate<br><em>Deeply.</em> Glow Visibly.
      </div>
      <div class="hero-sub">Our #1 rated serum with 2% Hyaluronic Acid + Niacinamide. 50,000+ happy customers.</div>
      <div class="hero-btns">
        <a href="#" class="btn-primary">Shop Serums</a>
        <a href="#" class="btn-outline">See Reviews</a>
      </div>
    </div>
  </div>
  <div class="hero-slide" id="slide-2">
    <div class="hero-bg" style="background: linear-gradient(135deg, #2a1f0a 0%, #6b4e0f 50%, #c9973a 100%);"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <div class="hero-tag">Limited Edition — Festive Glow</div>
      <div class="hero-title">
        Light Up<br><em>Every Room</em>
      </div>
      <div class="hero-sub">Festive makeup kits with buildable coverage & all-day wear. Curated for Indian celebrations.</div>
      <div class="hero-btns">
        <a href="#" class="btn-primary">Shop Kits</a>
        <a href="#" class="btn-outline">Gift Guide</a>
      </div>
    </div>
  </div>
  <div class="hero-dots">
    <div class="dot active" onclick="goToSlide(0)"></div>
    <div class="dot" onclick="goToSlide(1)"></div>
    <div class="dot" onclick="goToSlide(2)"></div>
  </div>
</div>

<!-- PERKS BAR -->
<div class="perks-bar">
  <div class="perks-inner">
    <div class="perk"><span class="perk-icon">🚚</span> Free Delivery above ₹799</div>
    <div class="perk"><span class="perk-icon">✅</span> 100% Authentic Products</div>
    <div class="perk"><span class="perk-icon">🔄</span> Easy 15-Day Returns</div>
    <div class="perk"><span class="perk-icon">🌿</span> Vegan & Cruelty Free</div>
    <div class="perk"><span class="perk-icon">💳</span> Pay via UPI / Card / COD</div>
  </div>
</div>

<!-- CATEGORIES -->
<section class="categories-bg">
  <div class="container">
    <div class="section-header center">
      <div class="section-label">Explore</div>
      <div class="section-title" style="color:#FDF8F2;">Shop by <em>Category</em></div>
    </div>
    <div class="cat-grid">
      <a href="#" class="cat-card">
        <div class="cat-icon-wrap">💄</div>
        <div class="cat-name">Makeup</div>
      </a>
      <a href="#" class="cat-card">
        <div class="cat-icon-wrap">🌸</div>
        <div class="cat-name">Skincare</div>
      </a>
      <a href="#" class="cat-card">
        <div class="cat-icon-wrap">💇</div>
        <div class="cat-name">Haircare</div>
      </a>
      <a href="#" class="cat-card">
        <div class="cat-icon-wrap">🌹</div>
        <div class="cat-name">Fragrance</div>
      </a>
      <a href="#" class="cat-card">
        <div class="cat-icon-wrap">🧴</div>
        <div class="cat-name">Body Care</div>
      </a>
      <a href="#" class="cat-card">
        <div class="cat-icon-wrap">🍃</div>
        <div class="cat-name">Organic</div>
      </a>
    </div>
  </div>
</section>

<!-- BRAND SCROLL -->
<div class="brands-strip">
  <div class="brands-inner" id="brandsTrack">
    <span class="brand-item">Lakmé</span>
    <span class="brand-item">Mamaearth</span>
    <span class="brand-item">L'Oréal Paris</span>
    <span class="brand-item">Wow Skin</span>
    <span class="brand-item">Plum</span>
    <span class="brand-item">Forest Essentials</span>
    <span class="brand-item">The Ordinary</span>
    <span class="brand-item">SUGAR</span>
    <span class="brand-item">Minimalist</span>
    <span class="brand-item">Biotique</span>
    <!-- duplicate for seamless loop -->
    <span class="brand-item">Lakmé</span>
    <span class="brand-item">Mamaearth</span>
    <span class="brand-item">L'Oréal Paris</span>
    <span class="brand-item">Wow Skin</span>
    <span class="brand-item">Plum</span>
    <span class="brand-item">Forest Essentials</span>
    <span class="brand-item">The Ordinary</span>
    <span class="brand-item">SUGAR</span>
    <span class="brand-item">Minimalist</span>
    <span class="brand-item">Biotique</span>
  </div>
</div>

<!-- BEST SELLERS -->
<section>
  <div class="container">
    <div class="section-header-row">
      <div>
        <div class="section-label">Customer Favourites</div>
        <div class="section-title">Best <em>Sellers</em></div>
      </div>
      <a href="#" class="view-all">View All Products →</a>
    </div>
    <div class="product-grid">

      <div class="product-card fade-up visible">
        <div class="product-img-wrap">
          <div class="product-img" style="background: linear-gradient(135deg, #f5e6ea, #f0c4cd);">💄</div>
          <div class="product-badge">-30%</div>
          <div class="product-overlay">
            <div class="product-actions">
              <button class="prod-btn">Add to Cart</button>
              <button class="prod-btn wish">♡</button>
            </div>
          </div>
        </div>
        <div class="product-brand">SUGAR Cosmetics</div>
        <div class="product-name">Matte as Hell Crayon Lipstick</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#C84B6C;" title="Cherry Red"></div>
          <div class="shade-dot" style="background:#A0304A;" title="Deep Wine"></div>
          <div class="shade-dot" style="background:#E8926A;" title="Nude Peach"></div>
          <div class="shade-dot" style="background:#7B3548;" title="Mauve"></div>
        </div>
        <div class="stars">★★★★★</div>
        <div class="product-price">
          <span class="price-current">₹499</span>
          <span class="price-mrp">₹699</span>
          <span class="price-off">30% off</span>
        </div>
      </div>

      <div class="product-card fade-up visible">
        <div class="product-img-wrap">
          <div class="product-img" style="background: linear-gradient(135deg, #e8f5e8, #c5e8c5);">✨</div>
          <div class="product-badge new">New</div>
          <div class="product-overlay">
            <div class="product-actions">
              <button class="prod-btn">Add to Cart</button>
              <button class="prod-btn wish">♡</button>
            </div>
          </div>
        </div>
        <div class="product-brand">Minimalist</div>
        <div class="product-name">10% Niacinamide Face Serum</div>
        <div class="product-shades"></div>
        <div class="stars">★★★★★</div>
        <div class="product-price">
          <span class="price-current">₹599</span>
          <span class="price-mrp">₹799</span>
          <span class="price-off">25% off</span>
        </div>
      </div>

      <div class="product-card fade-up visible">
        <div class="product-img-wrap">
          <div class="product-img" style="background: linear-gradient(135deg, #fef3e2, #fde0a0);">🌟</div>
          <div class="product-badge">-40%</div>
          <div class="product-overlay">
            <div class="product-actions">
              <button class="prod-btn">Add to Cart</button>
              <button class="prod-btn wish">♡</button>
            </div>
          </div>
        </div>
        <div class="product-brand">Lakmé</div>
        <div class="product-name">9to5 Weightless Foundation</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#f5d5b0;" title="Ivory"></div>
          <div class="shade-dot" style="background:#d4a978;" title="Natural"></div>
          <div class="shade-dot" style="background:#b08060;" title="Warm Beige"></div>
          <div class="shade-dot" style="background:#8b6045;" title="Tan"></div>
          <div class="shade-dot" style="background:#6b4030;" title="Espresso"></div>
        </div>
        <div class="stars">★★★★☆</div>
        <div class="product-price">
          <span class="price-current">₹479</span>
          <span class="price-mrp">₹799</span>
          <span class="price-off">40% off</span>
        </div>
      </div>

      <div class="product-card fade-up visible">
        <div class="product-img-wrap">
          <div class="product-img" style="background: linear-gradient(135deg, #ede8f5, #c8b8ea);">💜</div>
          <div class="product-badge">Hot</div>
          <div class="product-overlay">
            <div class="product-actions">
              <button class="prod-btn">Add to Cart</button>
              <button class="prod-btn wish">♡</button>
            </div>
          </div>
        </div>
        <div class="product-brand">Plum</div>
        <div class="product-name">Grape Seed & Sea Buckthorn Face Wash</div>
        <div class="product-shades"></div>
        <div class="stars">★★★★★</div>
        <div class="product-price">
          <span class="price-current">₹285</span>
          <span class="price-mrp">₹390</span>
          <span class="price-off">27% off</span>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- OFFER BANNER -->
<div style="padding: 0 40px; background: var(--cream);">
  <div class="offer-banner">
    <div class="offer-text">
      <div class="offer-tag">Limited Time Offer</div>
      <div class="offer-title">40% Off<br>Skincare Range</div>
      <div class="offer-sub">Valid till 30th April 2025 · Min. order ₹999</div>
    </div>
    <a href="#" class="offer-cta">Shop Skincare Now</a>
  </div>
</div>

<!-- NEW ARRIVALS -->
<section>
  <div class="container">
    <div class="section-header-row">
      <div>
        <div class="section-label">Just Landed</div>
        <div class="section-title">New <em>Arrivals</em></div>
      </div>
      <a href="#" class="view-all">View All New →</a>
    </div>
    <div class="product-grid">

      <div class="product-card">
        <div class="product-img-wrap">
          <div class="product-img" style="background: linear-gradient(135deg, #fde8f0, #fac0d5);">🌸</div>
          <div class="product-badge new">New</div>
          <div class="product-overlay">
            <div class="product-actions">
              <button class="prod-btn">Add to Cart</button>
              <button class="prod-btn wish">♡</button>
            </div>
          </div>
        </div>
        <div class="product-brand">Mamaearth</div>
        <div class="product-name">Rose Water Toner with Hyaluronic Acid</div>
        <div class="stars">★★★★☆</div>
        <div class="product-price">
          <span class="price-current">₹349</span>
          <span class="price-mrp">₹499</span>
          <span class="price-off">30% off</span>
        </div>
      </div>

      <div class="product-card">
        <div class="product-img-wrap">
          <div class="product-img" style="background: linear-gradient(135deg, #e8f0fe, #b8d0f8);">💙</div>
          <div class="product-badge new">New</div>
          <div class="product-overlay">
            <div class="product-actions">
              <button class="prod-btn">Add to Cart</button>
              <button class="prod-btn wish">♡</button>
            </div>
          </div>
        </div>
        <div class="product-brand">The Ordinary</div>
        <div class="product-name">Multi-Peptide Eye Serum</div>
        <div class="stars">★★★★★</div>
        <div class="product-price">
          <span class="price-current">₹1,299</span>
          <span class="price-mrp">₹1,599</span>
          <span class="price-off">19% off</span>
        </div>
      </div>

      <div class="product-card">
        <div class="product-img-wrap">
          <div class="product-img" style="background: linear-gradient(135deg, #e8fce8, #a0e0a0);">🌿</div>
          <div class="product-badge new">New</div>
          <div class="product-overlay">
            <div class="product-actions">
              <button class="prod-btn">Add to Cart</button>
              <button class="prod-btn wish">♡</button>
            </div>
          </div>
        </div>
        <div class="product-brand">Forest Essentials</div>
        <div class="product-name">Soundarya Radiance Cream</div>
        <div class="stars">★★★★★</div>
        <div class="product-price">
          <span class="price-current">₹2,450</span>
          <span class="price-mrp">₹2,800</span>
          <span class="price-off">13% off</span>
        </div>
      </div>

      <div class="product-card">
        <div class="product-img-wrap">
          <div class="product-img" style="background: linear-gradient(135deg, #fff5e0, #ffe0a0);">🍊</div>
          <div class="product-badge new">New</div>
          <div class="product-overlay">
            <div class="product-actions">
              <button class="prod-btn">Add to Cart</button>
              <button class="prod-btn wish">♡</button>
            </div>
          </div>
        </div>
        <div class="product-brand">Wow Skin</div>
        <div class="product-name">Vitamin C Brightening SPF 50 Sunscreen</div>
        <div class="stars">★★★★★</div>
        <div class="product-price">
          <span class="price-current">₹449</span>
          <span class="price-mrp">₹599</span>
          <span class="price-off">25% off</span>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- SKIN TYPE SHOP -->
<section style="background: #fff; padding: 80px 40px;">
  <div class="container">
    <div class="section-header center">
      <div class="section-label">Personalised For You</div>
      <div class="section-title">Shop by <em>Skin Type</em></div>
      <div class="section-sub">Apni skin type choose karein aur recommended products dekho</div>
    </div>
    <div class="skin-grid">
      <a href="#" class="skin-card">
        <span class="skin-emoji">✨</span>
        <div class="skin-name">Oily Skin</div>
        <div class="skin-desc">Mattifying formulas that balance & control shine</div>
      </a>
      <a href="#" class="skin-card">
        <span class="skin-emoji">💧</span>
        <div class="skin-name">Dry Skin</div>
        <div class="skin-desc">Deep moisture & nourishment for parched skin</div>
      </a>
      <a href="#" class="skin-card">
        <span class="skin-emoji">⚖️</span>
        <div class="skin-name">Combination</div>
        <div class="skin-desc">Balanced care for T-zone control</div>
      </a>
      <a href="#" class="skin-card">
        <span class="skin-emoji">🌼</span>
        <div class="skin-name">Sensitive</div>
        <div class="skin-desc">Gentle, fragrance-free & dermatologist tested</div>
      </a>
      <a href="#" class="skin-card">
        <span class="skin-emoji">🌿</span>
        <div class="skin-name">Normal Skin</div>
        <div class="skin-desc">Maintain your natural glow with light care</div>
      </a>
    </div>
  </div>
</section>

<!-- SHOP BY CONCERN -->
<section style="padding: 80px 40px;">
  <div class="container">
    <div class="section-header">
      <div class="section-label">Targeted Solutions</div>
      <div class="section-title">Shop by <em>Concern</em></div>
    </div>
    <div class="concern-grid">
      <a href="#" class="concern-card">
        <span class="concern-icon">🌙</span>
        <div class="concern-name">Anti-Ageing</div>
        <div class="concern-desc">Fine lines, wrinkles & firmness ke liye targeted care</div>
        <span class="concern-arrow">→</span>
      </a>
      <a href="#" class="concern-card">
        <span class="concern-icon">🎯</span>
        <div class="concern-name">Acne & Pimples</div>
        <div class="concern-desc">Salicylic acid & tea tree powered clear skin solutions</div>
        <span class="concern-arrow">→</span>
      </a>
      <a href="#" class="concern-card">
        <span class="concern-icon">☀️</span>
        <div class="concern-name">Brightening</div>
        <div class="concern-desc">Vitamin C, kojic acid & turmeric for radiant skin</div>
        <span class="concern-arrow">→</span>
      </a>
      <a href="#" class="concern-card">
        <span class="concern-icon">🌊</span>
        <div class="concern-name">Hydration</div>
        <div class="concern-desc">Hyaluronic acid & ceramides for plump, bouncy skin</div>
        <span class="concern-arrow">→</span>
      </a>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testi-bg">
  <div class="container">
    <div class="section-header center">
      <div class="section-label">Real People, Real Results</div>
      <div class="section-title">Customer <em>Love</em></div>
    </div>
    <div class="testi-slider">
      <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <div class="testi-text">"Minimalist ka Niacinamide serum is absolutely life-changing. Mere dark spots 4 weeks mein kaafi light ho gaye. Definitely repurchasing!"</div>
        <div class="testi-author">
          <div class="testi-avatar">🙋</div>
          <div>
            <div class="testi-name">Priya Sharma</div>
            <div class="testi-loc">Mumbai • Verified Buyer</div>
          </div>
        </div>
      </div>
      <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <div class="testi-text">"SUGAR ka lipstick 12 hours se zyada chala — khana khaane ke baad bhi. Shade selection is excellent and the formula feels so lightweight."</div>
        <div class="testi-author">
          <div class="testi-avatar">👩</div>
          <div>
            <div class="testi-name">Ananya Gupta</div>
            <div class="testi-loc">Delhi • Verified Buyer</div>
          </div>
        </div>
      </div>
      <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <div class="testi-text">"Delivery was super fast and packaging was beautiful! The Vitamin C sunscreen is my everyday essential now. Very happy with GlowNova!"</div>
        <div class="testi-author">
          <div class="testi-avatar">🧕</div>
          <div>
            <div class="testi-name">Fatima Khan</div>
            <div class="testi-loc">Hyderabad • Verified Buyer</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- NEWSLETTER -->
<div class="newsletter-wrap">
  <div class="container" style="text-align:center;">
    <div class="newsletter-title">Get <em>Exclusive</em> Offers</div>
    <div class="newsletter-sub">Subscribe karein aur apne first order par 10% off pao 🎁</div>
    <div class="newsletter-form">
      <input type="email" class="newsletter-input" placeholder="apna email likhein...">
      <button class="newsletter-btn">Subscribe</button>
    </div>
  </div>
</div>
@include('userfooter')