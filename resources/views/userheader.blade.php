<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GlowNova — Beauty & Cosmetics</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --rose: #C8566A;
    --rose-light: #F5E6EA;
    --rose-dark: #8B2D3E;
    --gold: #C9A84C;
    --gold-light: #FAF3E0;
    --cream: #FDF8F2;
    --dark: #1A1210;
    --mid: #5C4A42;
    --muted: #9C8880;
    --border: rgba(201, 168, 76, 0.2);
    --ff-display: 'Cormorant Garamond', serif;
    --ff-body: 'DM Sans', sans-serif;
  }

  html { scroll-behavior: smooth; }

  body {
    font-family: var(--ff-body);
    background: var(--cream);
    color: var(--dark);
    overflow-x: hidden;
    font-weight: 300;
  }

  /* ── ANNOUNCEMENT BAR ── */
  .announce {
    background: var(--dark);
    color: #e8d5b0;
    text-align: center;
    font-size: 12px;
    padding: 10px 20px;
    letter-spacing: 1.5px;
    font-family: var(--ff-body);
    font-weight: 400;
  }
  .announce span { color: var(--gold); }

  /* ── NAV ── */
  nav {
    background: var(--cream);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(8px);
  }
  .nav-inner {
    max-width: 1280px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    padding: 0 40px;
    height: 70px;
  }
  .nav-links {
    display: flex;
    gap: 32px;
    list-style: none;
  }
  .nav-links a {
    font-size: 12px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--mid);
    text-decoration: none;
    transition: color .2s;
    font-weight: 400;
  }
  .nav-links a:hover { color: var(--rose); }
  .nav-logo {
    text-align: center;
    font-family: var(--ff-display);
    font-size: 32px;
    font-weight: 300;
    color: var(--dark);
    letter-spacing: 3px;
    text-decoration: none;
  }
  .nav-logo em { color: var(--rose); font-style: italic; }
  .nav-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 20px;
  }
  .nav-icon {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--mid);
    font-size: 18px;
    position: relative;
    transition: color .2s;
    text-decoration: none;
    display: flex;
    align-items: center;
  }
  .nav-icon:hover { color: var(--rose); }
  .cart-badge {
    position: absolute;
    top: -6px; right: -8px;
    background: var(--rose);
    color: #fff;
    font-size: 9px;
    width: 16px; height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--ff-body);
    font-weight: 500;
  }
  .nav-search {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid var(--border);
    border-radius: 30px;
    padding: 6px 14px;
    background: transparent;
  }
  .nav-search input {
    border: none;
    background: transparent;
    font-size: 12px;
    font-family: var(--ff-body);
    color: var(--dark);
    width: 140px;
    outline: none;
  }
  .nav-search input::placeholder { color: var(--muted); }
  .search-icon { color: var(--muted); font-size: 14px; }

  /* ── HERO SLIDER ── */
  .hero {
    position: relative;
    height: 88vh;
    min-height: 560px;
    overflow: hidden;
  }
  .hero-slide {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    opacity: 0;
    transition: opacity 1.2s ease;
  }
  .hero-slide.active { opacity: 1; }
  .hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.05);
    transition: transform 8s ease;
  }
  .hero-slide.active .hero-bg { transform: scale(1); }
  .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(26,18,16,.65) 0%, rgba(26,18,16,.1) 100%);
  }
  .hero-content {
    position: relative;
    z-index: 2;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 80px;
    width: 100%;
  }
  .hero-tag {
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 20px;
    font-weight: 400;
  }
  .hero-title {
    font-family: var(--ff-display);
    font-size: clamp(52px, 7vw, 88px);
    font-weight: 300;
    color: #FDF8F2;
    line-height: 1.05;
    margin-bottom: 24px;
  }
  .hero-title em { font-style: italic; color: #e8c4b0; }
  .hero-sub {
    font-size: 15px;
    color: rgba(253,248,242,0.75);
    margin-bottom: 40px;
    font-weight: 300;
    max-width: 420px;
    line-height: 1.7;
  }
  .hero-btns { display: flex; gap: 16px; }
  .btn-primary {
    background: var(--rose);
    color: #fff;
    border: none;
    padding: 14px 36px;
    font-size: 12px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    cursor: pointer;
    font-family: var(--ff-body);
    font-weight: 400;
    text-decoration: none;
    display: inline-block;
    transition: background .2s, transform .15s;
  }
  .btn-primary:hover { background: var(--rose-dark); transform: translateY(-1px); }
  .btn-outline {
    background: transparent;
    color: #FDF8F2;
    border: 1px solid rgba(253,248,242,0.5);
    padding: 14px 36px;
    font-size: 12px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    cursor: pointer;
    font-family: var(--ff-body);
    font-weight: 400;
    text-decoration: none;
    display: inline-block;
    transition: border-color .2s, transform .15s;
  }
  .btn-outline:hover { border-color: #FDF8F2; transform: translateY(-1px); }
  .hero-dots {
    position: absolute;
    bottom: 36px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    z-index: 3;
  }
  .dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: rgba(253,248,242,0.4);
    cursor: pointer;
    transition: background .3s, transform .3s;
  }
  .dot.active { background: var(--gold); transform: scale(1.4); }

  /* ── SECTION COMMON ── */
  section { padding: 90px 40px; }
  .container { max-width: 1280px; margin: 0 auto; }
  .section-label {
    font-size: 10px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 12px;
    font-weight: 400;
  }
  .section-title {
    font-family: var(--ff-display);
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 300;
    color: var(--dark);
    line-height: 1.1;
    margin-bottom: 16px;
  }
  .section-title em { font-style: italic; color: var(--rose); }
  .section-sub {
    font-size: 14px;
    color: var(--muted);
    font-weight: 300;
    line-height: 1.7;
  }
  .section-header { margin-bottom: 52px; }
  .section-header.center { text-align: center; }

  /* ── CATEGORIES ── */
  .categories-bg { background: var(--dark); }
  .categories-bg .section-title { color: #FDF8F2; }
  .categories-bg .section-sub { color: rgba(253,248,242,0.5); }
  .cat-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 16px;
  }
  .cat-card {
    text-align: center;
    cursor: pointer;
    group: true;
    text-decoration: none;
  }
  .cat-icon-wrap {
    width: 80px; height: 80px;
    border-radius: 50%;
    margin: 0 auto 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    border: 1px solid rgba(201,168,76,0.3);
    transition: border-color .3s, transform .3s, background .3s;
  }
  .cat-card:hover .cat-icon-wrap {
    border-color: var(--gold);
    background: rgba(201,168,76,0.1);
    transform: translateY(-4px);
  }
  .cat-name {
    font-size: 11px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: rgba(253,248,242,0.7);
    font-weight: 400;
    transition: color .2s;
  }
  .cat-card:hover .cat-name { color: var(--gold); }

  /* ── BRANDS ── */
  .brands-strip {
    background: #fff;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 32px 40px;
    overflow: hidden;
  }
  .brands-inner {
    display: flex;
    gap: 60px;
    align-items: center;
    animation: scrollBrands 20s linear infinite;
    white-space: nowrap;
  }
  .brand-item {
    font-family: var(--ff-display);
    font-size: 20px;
    font-weight: 500;
    color: var(--muted);
    letter-spacing: 2px;
    transition: color .2s;
    cursor: pointer;
    flex-shrink: 0;
  }
  .brand-item:hover { color: var(--rose); }
  @keyframes scrollBrands {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
  }

  /* ── PRODUCT CARDS ── */
  .product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px;
  }
  .product-card {
    position: relative;
    cursor: pointer;
    group: true;
  }
  .product-img-wrap {
    position: relative;
    overflow: hidden;
    background: #F5EFEB;
    aspect-ratio: 3/4;
    margin-bottom: 16px;
  }
  .product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .6s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 64px;
  }
  .product-card:hover .product-img { transform: scale(1.05); }
  .product-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: var(--rose);
    color: #fff;
    font-size: 9px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 5px 10px;
    font-weight: 500;
  }
  .product-badge.new { background: var(--gold); color: var(--dark); }
  .product-overlay {
    position: absolute;
    inset: 0;
    background: rgba(26,18,16,0.4);
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding-bottom: 20px;
    opacity: 0;
    transition: opacity .3s;
  }
  .product-card:hover .product-overlay { opacity: 1; }
  .product-actions {
    display: flex;
    gap: 8px;
  }
  .prod-btn {
    background: var(--cream);
    color: var(--dark);
    border: none;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 10px 20px;
    cursor: pointer;
    font-family: var(--ff-body);
    font-weight: 400;
    transition: background .2s;
  }
  .prod-btn:hover { background: var(--rose); color: #fff; }
  .prod-btn.wish {
    width: 40px;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .product-brand {
    font-size: 10px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 5px;
    font-weight: 400;
  }
  .product-name {
    font-family: var(--ff-display);
    font-size: 18px;
    font-weight: 400;
    color: var(--dark);
    margin-bottom: 8px;
    line-height: 1.2;
  }
  .product-shades {
    display: flex;
    gap: 5px;
    margin-bottom: 10px;
  }
  .shade-dot {
    width: 14px; height: 14px;
    border-radius: 50%;
    border: 1px solid rgba(0,0,0,0.1);
    cursor: pointer;
    transition: transform .2s;
  }
  .shade-dot:hover { transform: scale(1.3); }
  .product-price {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .price-current {
    font-size: 16px;
    font-weight: 500;
    color: var(--dark);
  }
  .price-mrp {
    font-size: 13px;
    color: var(--muted);
    text-decoration: line-through;
  }
  .price-off {
    font-size: 11px;
    color: var(--rose);
    font-weight: 500;
    letter-spacing: .5px;
  }
  .stars {
    color: var(--gold);
    font-size: 12px;
    margin-bottom: 6px;
  }

  /* ── OFFER BANNER ── */
  .offer-banner {
    background: var(--rose);
    padding: 60px 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1280px;
    margin: 0 auto 0;
  }
  .offer-text .offer-tag {
    font-size: 10px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(253,248,242,0.7);
    margin-bottom: 10px;
    font-weight: 400;
  }
  .offer-title {
    font-family: var(--ff-display);
    font-size: clamp(28px, 4vw, 48px);
    font-weight: 300;
    color: #FDF8F2;
    line-height: 1.1;
    margin-bottom: 8px;
  }
  .offer-sub {
    font-size: 14px;
    color: rgba(253,248,242,0.7);
    font-weight: 300;
  }
  .offer-cta {
    background: #FDF8F2;
    color: var(--rose);
    border: none;
    padding: 16px 40px;
    font-size: 12px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    cursor: pointer;
    font-family: var(--ff-body);
    font-weight: 500;
    white-space: nowrap;
    transition: background .2s;
    text-decoration: none;
    display: inline-block;
  }
  .offer-cta:hover { background: var(--gold-light); }

  /* ── SKIN TYPE SHOP ── */
  .skin-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
  }
  .skin-card {
    border: 1px solid var(--border);
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color .3s, transform .3s, background .3s;
    text-decoration: none;
  }
  .skin-card:hover {
    border-color: var(--rose);
    background: var(--rose-light);
    transform: translateY(-4px);
  }
  .skin-emoji { font-size: 36px; margin-bottom: 14px; display: block; }
  .skin-name {
    font-family: var(--ff-display);
    font-size: 18px;
    font-weight: 400;
    color: var(--dark);
    margin-bottom: 6px;
  }
  .skin-desc {
    font-size: 11px;
    color: var(--muted);
    font-weight: 300;
    letter-spacing: .5px;
    line-height: 1.6;
  }

  /* ── CONCERN CARDS ── */
  .concern-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }
  .concern-card {
    background: var(--dark);
    padding: 36px 28px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    transition: transform .3s;
  }
  .concern-card::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 100%;
    height: 3px;
    background: var(--rose);
    transform: scaleX(0);
    transition: transform .3s;
    transform-origin: left;
  }
  .concern-card:hover::before { transform: scaleX(1); }
  .concern-card:hover { transform: translateY(-3px); }
  .concern-icon { font-size: 32px; margin-bottom: 20px; display: block; }
  .concern-name {
    font-family: var(--ff-display);
    font-size: 22px;
    font-weight: 400;
    color: #FDF8F2;
    margin-bottom: 8px;
  }
  .concern-desc {
    font-size: 12px;
    color: rgba(253,248,242,0.5);
    line-height: 1.7;
    font-weight: 300;
  }
  .concern-arrow {
    margin-top: 20px;
    font-size: 20px;
    color: var(--gold);
    display: block;
  }

  /* ── TESTIMONIALS ── */
  .testi-bg { background: var(--gold-light); }
  .testi-slider {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
  }
  .testi-card {
    background: #fff;
    padding: 32px 28px;
    border: 1px solid var(--border);
  }
  .testi-stars { color: var(--gold); font-size: 14px; margin-bottom: 16px; }
  .testi-text {
    font-family: var(--ff-display);
    font-size: 17px;
    font-weight: 300;
    font-style: italic;
    color: var(--dark);
    line-height: 1.7;
    margin-bottom: 20px;
  }
  .testi-author {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .testi-avatar {
    width: 44px; height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    background: var(--rose-light);
  }
  .testi-name {
    font-size: 13px;
    font-weight: 500;
    color: var(--dark);
    margin-bottom: 2px;
  }
  .testi-loc {
    font-size: 11px;
    color: var(--muted);
    font-weight: 300;
  }

  /* ── NEWSLETTER ── */
  .newsletter-wrap {
    background: var(--dark);
    padding: 80px 40px;
    text-align: center;
  }
  .newsletter-title {
    font-family: var(--ff-display);
    font-size: clamp(28px, 4vw, 48px);
    font-weight: 300;
    color: #FDF8F2;
    margin-bottom: 12px;
  }
  .newsletter-title em { font-style: italic; color: var(--gold); }
  .newsletter-sub {
    font-size: 14px;
    color: rgba(253,248,242,0.55);
    margin-bottom: 36px;
    font-weight: 300;
  }
  .newsletter-form {
    display: flex;
    max-width: 460px;
    margin: 0 auto;
    gap: 0;
  }
  .newsletter-input {
    flex: 1;
    border: 1px solid rgba(201,168,76,0.4);
    border-right: none;
    background: transparent;
    padding: 14px 20px;
    font-size: 13px;
    color: #FDF8F2;
    font-family: var(--ff-body);
    outline: none;
  }
  .newsletter-input::placeholder { color: rgba(253,248,242,0.35); }
  .newsletter-btn {
    background: var(--gold);
    color: var(--dark);
    border: 1px solid var(--gold);
    padding: 14px 28px;
    font-size: 11px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    cursor: pointer;
    font-family: var(--ff-body);
    font-weight: 500;
    transition: background .2s;
  }
  .newsletter-btn:hover { background: #e8c460; }

  /* ── FOOTER ── */
  footer {
    background: #100c0b;
    padding: 70px 40px 30px;
    color: rgba(253,248,242,0.6);
  }
  .footer-inner {
    max-width: 1280px;
    margin: 0 auto;
  }
  .footer-top {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1fr;
    gap: 60px;
    padding-bottom: 50px;
    border-bottom: 1px solid rgba(201,168,76,0.15);
    margin-bottom: 40px;
  }
  .footer-brand-name {
    font-family: var(--ff-display);
    font-size: 28px;
    font-weight: 300;
    color: #FDF8F2;
    letter-spacing: 3px;
    margin-bottom: 16px;
  }
  .footer-brand-name em { color: var(--rose); font-style: italic; }
  .footer-brand-desc {
    font-size: 13px;
    line-height: 1.8;
    margin-bottom: 24px;
    font-weight: 300;
  }
  .footer-socials { display: flex; gap: 12px; }
  .social-btn {
    width: 36px; height: 36px;
    border: 1px solid rgba(201,168,76,0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    text-decoration: none;
    color: rgba(253,248,242,0.6);
  }
  .social-btn:hover {
    border-color: var(--gold);
    background: rgba(201,168,76,0.1);
    color: var(--gold);
  }
  .footer-col h4 {
    font-size: 10px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 20px;
    font-weight: 500;
  }
  .footer-col ul { list-style: none; }
  .footer-col li { margin-bottom: 11px; }
  .footer-col a {
    font-size: 13px;
    color: rgba(253,248,242,0.55);
    text-decoration: none;
    font-weight: 300;
    transition: color .2s;
  }
  .footer-col a:hover { color: var(--rose); }
  .footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }
  .footer-copy { font-size: 11px; font-weight: 300; }
  .payment-logos {
    display: flex;
    gap: 10px;
    align-items: center;
  }
  .pay-badge {
    background: rgba(253,248,242,0.08);
    border: 1px solid rgba(253,248,242,0.12);
    padding: 4px 10px;
    font-size: 10px;
    letter-spacing: .5px;
    color: rgba(253,248,242,0.5);
    font-weight: 400;
  }

  /* ── ANIMATIONS ── */
  .fade-up {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity .7s ease, transform .7s ease;
  }
  .fade-up.visible { opacity: 1; transform: translateY(0); }
  .fade-up:nth-child(2) { transition-delay: .1s; }
  .fade-up:nth-child(3) { transition-delay: .2s; }
  .fade-up:nth-child(4) { transition-delay: .3s; }

  /* ── MINI TOP BAR ── */
  .perks-bar {
    background: var(--rose-light);
    border-bottom: 1px solid rgba(200,86,106,0.15);
    padding: 14px 40px;
  }
  .perks-inner {
    max-width: 1280px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
  }
  .perk {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--rose-dark);
    font-weight: 400;
    letter-spacing: .5px;
  }
  .perk-icon { font-size: 16px; }

  /* ── VIEW ALL LINK ── */
  .view-all {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--rose);
    text-decoration: none;
    font-weight: 400;
    border-bottom: 1px solid transparent;
    padding-bottom: 2px;
    transition: border-color .2s;
  }
  .view-all:hover { border-color: var(--rose); }
  .section-header-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 48px;
  }
</style>
</head>
<body>

<!-- ANNOUNCEMENT BAR -->
<div class="announce">
  ✨ FREE SHIPPING on orders above ₹799 &nbsp;|&nbsp; Use code <span>GLOW10</span> for 10% off &nbsp;|&nbsp; New Arrivals: Summer Collection 2025 ✨
</div>

<!-- NAVBAR -->
<nav>
  <div class="nav-inner">
    <ul class="nav-links">
      <li><a href="#">Shop</a></li>
      <li><a href="#">Skincare</a></li>
      <li><a href="#">Makeup</a></li>
      <li><a href="#">Brands</a></li>
    </ul>
    <a href="#" class="nav-logo">Glow<em>Nova</em></a>
    <div class="nav-actions">
      <div class="nav-search">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search products...">
      </div>
      <a href="#" class="nav-icon">♡</a>
      <a href="#" class="nav-icon">
        👤
      </a>
      <a href="#" class="nav-icon" style="position:relative;">
        🛒
        <span class="cart-badge">3</span>
      </a>
    </div>
  </div>
</nav>