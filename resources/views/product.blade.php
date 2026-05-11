<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shop — GlowNova Beauty</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --rose: #C8566A; --rose-light: #F5E6EA; --rose-dark: #8B2D3E;
  --gold: #C9A84C; --gold-light: #FAF3E0;
  --cream: #FDF8F2; --dark: #1A1210; --mid: #5C4A42;
  --muted: #9C8880; --border: rgba(201,168,76,0.2);
  --border-gray: #e8e2dc;
  --ff-display: 'Cormorant Garamond', serif;
  --ff-body: 'DM Sans', sans-serif;
}
html { scroll-behavior: smooth; }
body { font-family: var(--ff-body); background: var(--cream); color: var(--dark); overflow-x: hidden; font-weight: 300; }

/* ── ANNOUNCE ── */
.announce { background: var(--dark); color: #e8d5b0; text-align: center; font-size: 12px; padding: 9px 20px; letter-spacing: 1.5px; }
.announce span { color: var(--gold); }

/* ── NAV ── */
nav { background: var(--cream); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 200; }
.nav-inner { max-width: 1440px; margin: 0 auto; display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; padding: 0 32px; height: 64px; }
.nav-links { display: flex; gap: 28px; list-style: none; }
.nav-links a { font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--mid); text-decoration: none; transition: color .2s; font-weight: 400; }
.nav-links a:hover, .nav-links a.active { color: var(--rose); }
.nav-logo { text-align: center; font-family: var(--ff-display); font-size: 28px; font-weight: 300; color: var(--dark); letter-spacing: 3px; text-decoration: none; }
.nav-logo em { color: var(--rose); font-style: italic; }
.nav-actions { display: flex; justify-content: flex-end; align-items: center; gap: 18px; }
.nav-icon { background: none; border: none; cursor: pointer; color: var(--mid); font-size: 17px; position: relative; text-decoration: none; display: flex; align-items: center; transition: color .2s; }
.nav-icon:hover { color: var(--rose); }
.cart-badge { position: absolute; top: -6px; right: -8px; background: var(--rose); color: #fff; font-size: 9px; width: 15px; height: 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 500; }
.nav-search { display: flex; align-items: center; gap: 8px; border: 1px solid var(--border); border-radius: 30px; padding: 5px 12px; }
.nav-search input { border: none; background: transparent; font-size: 12px; font-family: var(--ff-body); color: var(--dark); width: 130px; outline: none; }
.nav-search input::placeholder { color: var(--muted); }

/* ── BREADCRUMB ── */
.breadcrumb-wrap { background: #fff; border-bottom: 1px solid var(--border-gray); padding: 12px 32px; }
.breadcrumb { max-width: 1440px; margin: 0 auto; display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--muted); }
.breadcrumb a { color: var(--muted); text-decoration: none; transition: color .2s; }
.breadcrumb a:hover { color: var(--rose); }
.breadcrumb .sep { color: var(--border-gray); }
.breadcrumb .current { color: var(--dark); font-weight: 400; }

/* ── CATEGORY HERO ── */
.cat-hero { background: linear-gradient(135deg, #2d1b18 0%, #5c2d35 100%); padding: 48px 32px; }
.cat-hero-inner { max-width: 1440px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
.cat-hero-title { font-family: var(--ff-display); font-size: clamp(32px, 4vw, 54px); font-weight: 300; color: #FDF8F2; line-height: 1.1; }
.cat-hero-title em { font-style: italic; color: #f0b8c0; }
.cat-hero-sub { font-size: 13px; color: rgba(253,248,242,0.55); margin-top: 8px; font-weight: 300; }
.cat-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
.cat-tab { padding: 9px 20px; border: 1px solid rgba(253,248,242,0.2); font-size: 11px; letter-spacing: 1px; text-transform: uppercase; color: rgba(253,248,242,0.65); cursor: pointer; transition: all .2s; background: transparent; font-family: var(--ff-body); }
.cat-tab.active, .cat-tab:hover { background: var(--rose); border-color: var(--rose); color: #fff; }

/* ── MAIN LAYOUT ── */
.shop-layout { max-width: 1440px; margin: 0 auto; display: grid; grid-template-columns: 270px 1fr; gap: 0; padding: 0 32px 60px; align-items: start; }

/* ── SIDEBAR ── */
.sidebar { padding: 28px 0 28px 0; position: sticky; top: 64px; max-height: calc(100vh - 64px); overflow-y: auto; scrollbar-width: thin; }
.sidebar::-webkit-scrollbar { width: 3px; }
.sidebar::-webkit-scrollbar-thumb { background: var(--border-gray); }

.filter-section { margin-bottom: 28px; border-bottom: 1px solid var(--border-gray); padding-bottom: 24px; }
.filter-section:last-child { border-bottom: none; }
.filter-header { display: flex; justify-content: space-between; align-items: center; cursor: pointer; margin-bottom: 16px; }
.filter-title { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--dark); font-weight: 500; }
.filter-toggle { font-size: 14px; color: var(--muted); transition: transform .3s; }
.filter-toggle.open { transform: rotate(180deg); }
.filter-body { display: block; }
.filter-body.collapsed { display: none; }

/* Checkbox filters */
.filter-option { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; cursor: pointer; }
.filter-checkbox { width: 16px; height: 16px; border: 1px solid var(--border-gray); appearance: none; cursor: pointer; position: relative; flex-shrink: 0; transition: border-color .2s, background .2s; }
.filter-checkbox:checked { background: var(--rose); border-color: var(--rose); }
.filter-checkbox:checked::after { content: '✓'; position: absolute; top: -1px; left: 2px; font-size: 10px; color: #fff; font-weight: 500; }
.filter-label { font-size: 13px; color: var(--mid); font-weight: 300; flex: 1; }
.filter-count { font-size: 11px; color: var(--muted); }

/* Price range */
.price-range-wrap { padding: 4px 0; }
.price-inputs { display: flex; gap: 8px; margin-bottom: 14px; }
.price-input { flex: 1; border: 1px solid var(--border-gray); padding: 8px 10px; font-size: 12px; font-family: var(--ff-body); color: var(--dark); outline: none; background: #fff; transition: border-color .2s; }
.price-input:focus { border-color: var(--rose); }
.range-slider { width: 100%; accent-color: var(--rose); height: 3px; }
.range-labels { display: flex; justify-content: space-between; font-size: 11px; color: var(--muted); margin-top: 6px; }

/* Color swatches filter */
.color-swatches { display: flex; flex-wrap: wrap; gap: 8px; }
.swatch-filter { width: 26px; height: 26px; border-radius: 50%; border: 2px solid transparent; cursor: pointer; transition: transform .2s, border-color .2s; position: relative; }
.swatch-filter:hover { transform: scale(1.2); }
.swatch-filter.active { border-color: var(--dark); }

/* Rating filter */
.rating-option { display: flex; align-items: center; gap: 8px; margin-bottom: 9px; cursor: pointer; }
.rating-stars { color: var(--gold); font-size: 13px; }
.rating-label { font-size: 12px; color: var(--mid); font-weight: 300; }

/* Active filters */
.active-filters { padding: 16px 0 0; }
.active-filters-title { font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); margin-bottom: 10px; font-weight: 400; }
.filter-tags { display: flex; flex-wrap: wrap; gap: 6px; }
.filter-tag { display: flex; align-items: center; gap: 6px; background: var(--rose-light); border: 1px solid rgba(200,86,106,0.2); padding: 5px 10px; font-size: 11px; color: var(--rose); font-weight: 400; cursor: pointer; transition: background .2s; }
.filter-tag:hover { background: #f0c4cd; }
.filter-tag .remove { font-size: 13px; line-height: 1; }
.clear-all { font-size: 11px; color: var(--rose); text-decoration: underline; cursor: pointer; background: none; border: none; font-family: var(--ff-body); margin-top: 8px; }

/* ── MAIN CONTENT ── */
.main-content { padding: 28px 0 0 36px; border-left: 1px solid var(--border-gray); }

/* Toolbar */
.toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 18px; border-bottom: 1px solid var(--border-gray); flex-wrap: wrap; gap: 12px; }
.results-info { font-size: 13px; color: var(--muted); font-weight: 300; }
.results-info strong { color: var(--dark); font-weight: 500; }
.toolbar-right { display: flex; align-items: center; gap: 16px; }

/* Sort */
.sort-select { border: 1px solid var(--border-gray); padding: 8px 32px 8px 12px; font-size: 12px; font-family: var(--ff-body); color: var(--dark); appearance: none; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%239C8880'/%3E%3C/svg%3E") no-repeat right 10px center; outline: none; cursor: pointer; transition: border-color .2s; }
.sort-select:focus { border-color: var(--rose); }

/* Grid toggle */
.grid-toggle { display: flex; align-items: center; gap: 2px; border: 1px solid var(--border-gray); padding: 3px; background: #fff; }
.grid-btn { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: none; background: transparent; transition: background .2s; border-radius: 2px; }
.grid-btn.active { background: var(--dark); }
.grid-btn.active svg rect, .grid-btn.active svg path { fill: #fff; }
.grid-btn svg { width: 16px; height: 16px; }
.grid-btn svg rect, .grid-btn svg path { fill: var(--muted); transition: fill .2s; }
.grid-btn:hover svg rect, .grid-btn:hover svg path { fill: var(--dark); }
.grid-btn.active:hover svg rect, .grid-btn.active:hover svg path { fill: #fff; }

.view-toggle { display: flex; gap: 4px; }
.view-btn { padding: 6px 10px; font-size: 11px; border: 1px solid var(--border-gray); background: transparent; cursor: pointer; font-family: var(--ff-body); color: var(--muted); transition: all .2s; }
.view-btn.active { background: var(--dark); color: #fff; border-color: var(--dark); }

/* Per page */
.per-page-wrap { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--muted); }
.per-page-select { border: 1px solid var(--border-gray); padding: 6px 10px; font-size: 12px; font-family: var(--ff-body); color: var(--dark); background: #fff; outline: none; cursor: pointer; }

/* ── PRODUCT GRID ── */
.product-grid { display: grid; gap: 20px; transition: all .3s; }
.product-grid.cols-4 { grid-template-columns: repeat(4, 1fr); }
.product-grid.cols-6 { grid-template-columns: repeat(6, 1fr); }
.product-grid.cols-8 { grid-template-columns: repeat(8, 1fr); }
.product-grid.cols-12 { grid-template-columns: repeat(12, 1fr); }
.product-grid.list-view { grid-template-columns: 1fr; }

/* Product Card */
.product-card { position: relative; cursor: pointer; animation: fadeUp .4s ease forwards; opacity: 0; }
@keyframes fadeUp { from { opacity:0; transform: translateY(16px); } to { opacity:1; transform: translateY(0); } }
.product-card:nth-child(1) { animation-delay:.03s } .product-card:nth-child(2) { animation-delay:.06s }
.product-card:nth-child(3) { animation-delay:.09s } .product-card:nth-child(4) { animation-delay:.12s }
.product-card:nth-child(5) { animation-delay:.15s } .product-card:nth-child(6) { animation-delay:.18s }
.product-card:nth-child(7) { animation-delay:.21s } .product-card:nth-child(8) { animation-delay:.24s }

.product-img-wrap { position: relative; overflow: hidden; background: #F5EFEB; aspect-ratio: 3/4; margin-bottom: 12px; }
.product-img { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 52px; transition: transform .6s ease; }
.product-card:hover .product-img { transform: scale(1.06); }

.product-badge { position: absolute; top: 10px; left: 10px; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; padding: 4px 8px; font-weight: 500; z-index: 2; }
.badge-sale { background: var(--rose); color: #fff; }
.badge-new { background: var(--gold); color: var(--dark); }
.badge-hot { background: var(--dark); color: #fff; }
.badge-oos { background: #ccc; color: #666; }

.wishlist-btn { position: absolute; top: 10px; right: 10px; width: 32px; height: 32px; background: rgba(253,248,242,0.9); border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 14px; opacity: 0; transition: opacity .2s, color .2s; z-index: 2; }
.product-card:hover .wishlist-btn { opacity: 1; }
.wishlist-btn.active { opacity: 1; color: var(--rose); }
.wishlist-btn:hover { background: #fff; }

.product-overlay { position: absolute; bottom: 0; left: 0; right: 0; padding: 14px 12px; background: linear-gradient(transparent, rgba(26,18,16,0.55)); opacity: 0; transition: opacity .3s; display: flex; gap: 6px; }
.product-card:hover .product-overlay { opacity: 1; }
.btn-cart { flex: 1; background: #fff; color: var(--dark); border: none; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; padding: 9px; cursor: pointer; font-family: var(--ff-body); font-weight: 400; transition: background .2s, color .2s; }
.btn-cart:hover { background: var(--rose); color: #fff; }
.btn-quick { background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.4); font-size: 10px; padding: 9px 12px; cursor: pointer; font-family: var(--ff-body); font-weight: 400; letter-spacing: 1px; white-space: nowrap; transition: background .2s; }
.btn-quick:hover { background: rgba(255,255,255,0.35); }

.product-brand { font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); margin-bottom: 4px; font-weight: 400; }
.product-name { font-family: var(--ff-display); font-size: 16px; font-weight: 400; color: var(--dark); margin-bottom: 6px; line-height: 1.2; }
.product-shades { display: flex; gap: 4px; margin-bottom: 6px; flex-wrap: wrap; }
.shade-dot { width: 12px; height: 12px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); cursor: pointer; transition: transform .2s; }
.shade-dot:hover { transform: scale(1.3); }
.shade-more { font-size: 10px; color: var(--muted); align-self: center; }
.product-rating { display: flex; align-items: center; gap: 5px; margin-bottom: 6px; }
.stars-small { color: var(--gold); font-size: 11px; }
.rating-num { font-size: 11px; color: var(--muted); font-weight: 300; }
.product-price { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.price-current { font-size: 15px; font-weight: 500; color: var(--dark); }
.price-mrp { font-size: 12px; color: var(--muted); text-decoration: line-through; }
.price-off { font-size: 10px; color: var(--rose); font-weight: 500; }

/* Compact card for 6/8/12 cols */
.product-grid.cols-6 .product-name,
.product-grid.cols-8 .product-name,
.product-grid.cols-12 .product-name { font-size: 13px; }
.product-grid.cols-6 .product-img, .product-grid.cols-8 .product-img, .product-grid.cols-12 .product-img { font-size: 32px; }
.product-grid.cols-8 .product-brand, .product-grid.cols-12 .product-brand { font-size: 9px; }
.product-grid.cols-8 .price-current, .product-grid.cols-12 .price-current { font-size: 13px; }
.product-grid.cols-12 .product-shades, .product-grid.cols-12 .product-rating { display: none; }
.product-grid.cols-12 .wishlist-btn { width: 26px; height: 26px; font-size: 11px; }

/* List View */
.list-view .product-card { display: grid; grid-template-columns: 160px 1fr auto; gap: 0; align-items: start; border: 1px solid var(--border-gray); background: #fff; }
.list-view .product-img-wrap { margin-bottom: 0; aspect-ratio: auto; height: 180px; }
.list-view .product-info { padding: 20px 24px; }
.list-view .product-name { font-size: 20px; margin-bottom: 8px; }
.list-view .product-shades { margin-bottom: 10px; }
.list-view .product-desc { font-size: 13px; color: var(--muted); line-height: 1.7; font-weight: 300; margin-bottom: 12px; max-width: 600px; }
.list-view .product-actions { padding: 20px 24px; display: flex; flex-direction: column; gap: 8px; justify-content: center; border-left: 1px solid var(--border-gray); min-width: 160px; }
.list-view .price-current { font-size: 20px; }
.list-view .btn-list-cart { background: var(--rose); color: #fff; border: none; padding: 10px 20px; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; font-family: var(--ff-body); font-weight: 400; transition: background .2s; }
.list-view .btn-list-cart:hover { background: var(--rose-dark); }
.list-view .btn-list-wish { background: transparent; color: var(--mid); border: 1px solid var(--border-gray); padding: 8px 20px; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; font-family: var(--ff-body); transition: all .2s; }
.list-view .btn-list-wish:hover { border-color: var(--rose); color: var(--rose); }
.list-view .product-overlay, .list-view .wishlist-btn { display: none; }

/* No results */
.no-results { text-align: center; padding: 80px 20px; color: var(--muted); }
.no-results-icon { font-size: 48px; margin-bottom: 16px; }
.no-results-title { font-family: var(--ff-display); font-size: 28px; font-weight: 300; color: var(--dark); margin-bottom: 8px; }
.no-results-sub { font-size: 14px; font-weight: 300; }

/* ── PAGINATION ── */
.pagination-wrap { display: flex; align-items: center; justify-content: space-between; margin-top: 48px; padding-top: 24px; border-top: 1px solid var(--border-gray); flex-wrap: wrap; gap: 16px; }
.pagination { display: flex; gap: 4px; align-items: center; }
.page-btn { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-gray); background: #fff; font-size: 13px; color: var(--mid); cursor: pointer; font-family: var(--ff-body); transition: all .2s; text-decoration: none; }
.page-btn:hover { border-color: var(--rose); color: var(--rose); }
.page-btn.active { background: var(--dark); color: #fff; border-color: var(--dark); }
.page-btn.disabled { opacity: 0.4; cursor: not-allowed; }
.page-dots { width: 36px; text-align: center; color: var(--muted); font-size: 13px; }
.load-more-btn { background: transparent; color: var(--dark); border: 1px solid var(--dark); padding: 12px 36px; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; cursor: pointer; font-family: var(--ff-body); font-weight: 400; transition: all .2s; }
.load-more-btn:hover { background: var(--dark); color: #fff; }
.load-more-btn.loading { opacity: 0.6; cursor: wait; }

/* ── COMPARE BAR ── */
.compare-bar { position: fixed; bottom: 0; left: 0; right: 0; background: var(--dark); color: #FDF8F2; padding: 14px 40px; display: flex; align-items: center; justify-content: space-between; z-index: 300; transform: translateY(100%); transition: transform .3s; }
.compare-bar.visible { transform: translateY(0); }
.compare-items { display: flex; gap: 16px; align-items: center; }
.compare-item { display: flex; align-items: center; gap: 8px; font-size: 13px; }
.compare-item-img { width: 36px; height: 36px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; font-size: 18px; }
.compare-item-close { background: none; border: none; color: rgba(253,248,242,0.5); cursor: pointer; font-size: 16px; }
.compare-label { font-size: 12px; color: rgba(253,248,242,0.5); letter-spacing: 1px; }
.btn-compare { background: var(--rose); color: #fff; border: none; padding: 10px 28px; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; cursor: pointer; font-family: var(--ff-body); transition: background .2s; }
.btn-compare:hover { background: var(--rose-dark); }
.compare-clear { background: none; border: 1px solid rgba(253,248,242,0.2); color: rgba(253,248,242,0.6); padding: 10px 20px; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; font-family: var(--ff-body); transition: all .2s; margin-left: 8px; }

/* ── MOBILE FILTER TOGGLE ── */
.mobile-filter-btn { display: none; align-items: center; gap: 8px; background: var(--dark); color: #fff; border: none; padding: 10px 20px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; font-family: var(--ff-body); }
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 150; }

/* Scrollbar sidebar */
.sidebar { scrollbar-color: var(--border-gray) transparent; }

/* ── QUICK VIEW MODAL ── */
.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(26,18,16,0.6); z-index: 500; align-items: center; justify-content: center; }
.modal-overlay.open { display: flex; }
.modal-box { background: var(--cream); width: 90%; max-width: 700px; max-height: 85vh; overflow-y: auto; animation: modalIn .3s ease; }
@keyframes modalIn { from { opacity:0; transform: scale(.95); } to { opacity:1; transform: scale(1); } }
.modal-inner { display: grid; grid-template-columns: 1fr 1fr; }
.modal-img-side { background: #F5EFEB; display: flex; align-items: center; justify-content: center; font-size: 100px; min-height: 360px; }
.modal-info-side { padding: 36px 32px; }
.modal-close { position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 22px; cursor: pointer; color: var(--muted); }
.modal-brand { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; }
.modal-name { font-family: var(--ff-display); font-size: 26px; font-weight: 400; color: var(--dark); margin-bottom: 12px; line-height: 1.2; }
.modal-price-row { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.modal-price { font-size: 22px; font-weight: 500; color: var(--dark); }
.modal-mrp { font-size: 15px; color: var(--muted); text-decoration: line-through; }
.modal-off { font-size: 13px; color: var(--rose); font-weight: 500; }
.modal-section { margin-bottom: 16px; }
.modal-section-label { font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; font-weight: 400; }
.modal-shades { display: flex; gap: 8px; flex-wrap: wrap; }
.modal-shade { width: 24px; height: 24px; border-radius: 50%; border: 2px solid transparent; cursor: pointer; transition: all .2s; }
.modal-shade.active { border-color: var(--dark); transform: scale(1.2); }
.modal-qty { display: flex; align-items: center; gap: 0; border: 1px solid var(--border-gray); width: fit-content; }
.qty-btn { width: 36px; height: 36px; background: #fff; border: none; font-size: 18px; cursor: pointer; color: var(--mid); transition: background .2s; }
.qty-btn:hover { background: var(--rose-light); }
.qty-val { width: 40px; height: 36px; border: none; border-left: 1px solid var(--border-gray); border-right: 1px solid var(--border-gray); text-align: center; font-size: 14px; font-family: var(--ff-body); color: var(--dark); background: #fff; }
.modal-add-btn { width: 100%; background: var(--rose); color: #fff; border: none; padding: 14px; font-size: 12px; letter-spacing: 1.5px; text-transform: uppercase; cursor: pointer; font-family: var(--ff-body); font-weight: 400; margin-top: 20px; transition: background .2s; }
.modal-add-btn:hover { background: var(--rose-dark); }
.modal-view-btn { width: 100%; background: transparent; color: var(--dark); border: 1px solid var(--border-gray); padding: 10px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; font-family: var(--ff-body); margin-top: 8px; transition: all .2s; }
.modal-view-btn:hover { border-color: var(--dark); }

@media (max-width: 900px) {
  .shop-layout { grid-template-columns: 1fr; padding: 0 16px 40px; }
  .sidebar { display: none; position: fixed; left: 0; top: 0; bottom: 0; width: 280px; background: var(--cream); z-index: 160; padding: 80px 24px 24px; overflow-y: auto; box-shadow: 4px 0 20px rgba(0,0,0,0.15); }
  .sidebar.open { display: block; }
  .sidebar-overlay { display: block; }
  .mobile-filter-btn { display: flex; }
  .main-content { padding: 20px 0 0; border-left: none; }
  .product-grid.cols-4 { grid-template-columns: repeat(2, 1fr); }
  .product-grid.cols-6, .product-grid.cols-8, .product-grid.cols-12 { grid-template-columns: repeat(3, 1fr); }
}
</style>
</head>
<body>

<!-- ANNOUNCE -->
<div class="announce">FREE SHIPPING above ₹799 &nbsp;|&nbsp; Code <span>GLOW10</span> for 10% off</div>

<!-- NAV -->
<nav>
  <div class="nav-inner">
    <ul class="nav-links">
      <li><a href="beauty_homepage.html">Home</a></li>
      <li><a href="#" class="active">Shop</a></li>
      <li><a href="#">Skincare</a></li>
      <li><a href="#">Makeup</a></li>
      <li><a href="#">Brands</a></li>
    </ul>
    <a href="beauty_homepage.html" class="nav-logo">Glow<em>Nova</em></a>
    <div class="nav-actions">
      <div class="nav-search"><span>🔍</span><input type="text" placeholder="Search..."></div>
      <a href="#" class="nav-icon">♡</a>
      <a href="#" class="nav-icon">👤</a>
      <a href="#" class="nav-icon" style="position:relative;">🛒<span class="cart-badge" id="cartCount">3</span></a>
    </div>
  </div>
</nav>

<!-- BREADCRUMB -->
<div class="breadcrumb-wrap">
  <div class="breadcrumb">
    <a href="beauty_homepage.html">Home</a>
    <span class="sep">›</span>
    <a href="#">Shop</a>
    <span class="sep">›</span>
    <span class="current">Makeup</span>
  </div>
</div>

<!-- CATEGORY HERO -->
<div class="cat-hero">
  <div class="cat-hero-inner">
    <div>
      <div class="cat-hero-title">All <em>Makeup</em> Products</div>
      <div class="cat-hero-sub">156 products · Free delivery available</div>
    </div>
    <div class="cat-tabs">
      <button class="cat-tab active" onclick="filterCat(this,'all')">All</button>
      <button class="cat-tab" onclick="filterCat(this,'lips')">Lips</button>
      <button class="cat-tab" onclick="filterCat(this,'eyes')">Eyes</button>
      <button class="cat-tab" onclick="filterCat(this,'face')">Face</button>
      <button class="cat-tab" onclick="filterCat(this,'nails')">Nails</button>
      <button class="cat-tab" onclick="filterCat(this,'kits')">Kits</button>
    </div>
  </div>
</div>

<!-- MOBILE FILTER BUTTON -->
<div style="padding:12px 16px; display:none;" class="mobile-filter-btn-wrap">
  <button class="mobile-filter-btn" onclick="toggleSidebar()">☰ Filters & Sort</button>
</div>

<!-- SIDEBAR OVERLAY -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()" style="display:none;"></div>

<!-- SHOP LAYOUT -->
<div class="shop-layout">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">

    <!-- Active Filters -->
    <div class="active-filters" id="activeFilters" style="margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid var(--border-gray); display:none;">
      <div class="active-filters-title">Active Filters</div>
      <div class="filter-tags" id="filterTagsContainer"></div>
      <button class="clear-all" onclick="clearAllFilters()">Clear All</button>
    </div>

    <!-- Category -->
    <div class="filter-section">
      <div class="filter-header" onclick="toggleFilter(this)">
        <span class="filter-title">Category</span>
        <span class="filter-toggle open">▾</span>
      </div>
      <div class="filter-body">
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Lipstick')"> <span class="filter-label">Lipstick</span> <span class="filter-count">(42)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Foundation')"> <span class="filter-label">Foundation</span> <span class="filter-count">(28)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Mascara')"> <span class="filter-label">Mascara</span> <span class="filter-count">(19)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Eyeliner')"> <span class="filter-label">Eyeliner</span> <span class="filter-count">(22)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Blush')"> <span class="filter-label">Blush & Bronzer</span> <span class="filter-count">(15)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Kajal')"> <span class="filter-label">Kajal</span> <span class="filter-count">(18)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Primer')"> <span class="filter-label">Primer</span> <span class="filter-count">(12)</span></label>
      </div>
    </div>

    <!-- Brand -->
    <div class="filter-section">
      <div class="filter-header" onclick="toggleFilter(this)">
        <span class="filter-title">Brand</span>
        <span class="filter-toggle open">▾</span>
      </div>
      <div class="filter-body">
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('SUGAR')"> <span class="filter-label">SUGAR Cosmetics</span> <span class="filter-count">(34)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Lakmé')"> <span class="filter-label">Lakmé</span> <span class="filter-count">(28)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Maybelline')"> <span class="filter-label">Maybelline</span> <span class="filter-count">(22)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('NYX')"> <span class="filter-label">NYX Professional</span> <span class="filter-count">(18)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Faces')"> <span class="filter-label">Faces Canada</span> <span class="filter-count">(16)</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('L\'Oréal')"> <span class="filter-label">L'Oréal Paris</span> <span class="filter-count">(20)</span></label>
      </div>
    </div>

    <!-- Price Range -->
    <div class="filter-section">
      <div class="filter-header" onclick="toggleFilter(this)">
        <span class="filter-title">Price Range</span>
        <span class="filter-toggle open">▾</span>
      </div>
      <div class="filter-body">
        <div class="price-range-wrap">
          <div class="price-inputs">
            <input type="number" class="price-input" id="priceMin" placeholder="₹ Min" value="100" min="0">
            <input type="number" class="price-input" id="priceMax" placeholder="₹ Max" value="2000" max="5000">
          </div>
          <input type="range" class="range-slider" min="100" max="5000" value="2000" oninput="document.getElementById('priceMax').value=this.value">
          <div class="range-labels"><span>₹100</span><span>₹5,000</span></div>
        </div>
      </div>
    </div>

    <!-- Skin Type -->
    <div class="filter-section">
      <div class="filter-header" onclick="toggleFilter(this)">
        <span class="filter-title">Skin Type</span>
        <span class="filter-toggle open">▾</span>
      </div>
      <div class="filter-body">
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Oily')"> <span class="filter-label">Oily Skin</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Dry')"> <span class="filter-label">Dry Skin</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Combination')"> <span class="filter-label">Combination</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Sensitive')"> <span class="filter-label">Sensitive</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('All Types')"> <span class="filter-label">All Skin Types</span></label>
      </div>
    </div>

    <!-- Shade / Color -->
    <div class="filter-section">
      <div class="filter-header" onclick="toggleFilter(this)">
        <span class="filter-title">Shade Family</span>
        <span class="filter-toggle open">▾</span>
      </div>
      <div class="filter-body">
        <div class="color-swatches">
          <div class="swatch-filter" style="background:#C84B6C;" title="Red" onclick="toggleSwatch(this,'Red')"></div>
          <div class="swatch-filter" style="background:#A0304A;" title="Wine" onclick="toggleSwatch(this,'Wine')"></div>
          <div class="swatch-filter" style="background:#E8926A;" title="Peach" onclick="toggleSwatch(this,'Peach')"></div>
          <div class="swatch-filter" style="background:#D4A56A;" title="Nude" onclick="toggleSwatch(this,'Nude')"></div>
          <div class="swatch-filter" style="background:#8B4A6B;" title="Mauve" onclick="toggleSwatch(this,'Mauve')"></div>
          <div class="swatch-filter" style="background:#C86830;" title="Coral" onclick="toggleSwatch(this,'Coral')"></div>
          <div class="swatch-filter" style="background:#3a3a3a;" title="Black" onclick="toggleSwatch(this,'Black')"></div>
          <div class="swatch-filter" style="background:#b8860b;" title="Gold" onclick="toggleSwatch(this,'Gold')"></div>
        </div>
      </div>
    </div>

    <!-- Rating -->
    <div class="filter-section">
      <div class="filter-header" onclick="toggleFilter(this)">
        <span class="filter-title">Rating</span>
        <span class="filter-toggle open">▾</span>
      </div>
      <div class="filter-body">
        <div class="rating-option" onclick="addFilterTag('4★ & above')"><span class="rating-stars">★★★★☆</span><span class="rating-label">4 & above (89)</span></div>
        <div class="rating-option" onclick="addFilterTag('3★ & above')"><span class="rating-stars">★★★☆☆</span><span class="rating-label">3 & above (124)</span></div>
        <div class="rating-option" onclick="addFilterTag('Top Rated')"><span class="rating-stars">★★★★★</span><span class="rating-label">5 star only (42)</span></div>
      </div>
    </div>

    <!-- Concern -->
    <div class="filter-section">
      <div class="filter-header" onclick="toggleFilter(this)">
        <span class="filter-title">Formulation</span>
        <span class="filter-toggle open">▾</span>
      </div>
      <div class="filter-body">
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Matte')"> <span class="filter-label">Matte Finish</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Glossy')"> <span class="filter-label">Glossy / Shiny</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Waterproof')"> <span class="filter-label">Waterproof</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Vegan')"> <span class="filter-label">Vegan</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('Cruelty-Free')"> <span class="filter-label">Cruelty-Free</span></label>
        <label class="filter-option"><input type="checkbox" class="filter-checkbox" onchange="addFilterTag('In Stock')"> <span class="filter-label">In Stock Only</span></label>
      </div>
    </div>

  </aside>

  <!-- MAIN CONTENT -->
  <main class="main-content">

    <!-- TOOLBAR -->
    <div class="toolbar">
      <div class="results-info">Showing <strong id="showingCount">1–24</strong> of <strong>156</strong> products</div>
      <div class="toolbar-right">

        <!-- Per page -->
        <div class="per-page-wrap">
          <span>Show:</span>
          <select class="per-page-select" onchange="updatePerPage(this.value)">
            <option value="24">24</option>
            <option value="48">48</option>
            <option value="96">96</option>
          </select>
        </div>

        <!-- Sort -->
        <select class="sort-select" onchange="sortProducts(this.value)">
          <option value="popular">Popularity</option>
          <option value="newest">Newest First</option>
          <option value="price-low">Price: Low to High</option>
          <option value="price-high">Price: High to Low</option>
          <option value="rating">Top Rated</option>
          <option value="discount">Highest Discount</option>
        </select>

        <!-- Grid Column Toggle -->
        <div class="grid-toggle">
          <!-- 4 col -->
          <button class="grid-btn active" onclick="setGrid(4,this)" title="4 columns">
            <svg viewBox="0 0 16 16"><rect x="0" y="0" width="6" height="6"/><rect x="9" y="0" width="6" height="6"/><rect x="0" y="9" width="6" height="6"/><rect x="9" y="9" width="6" height="6"/></svg>
          </button>
          <!-- 6 col -->
          <button class="grid-btn" onclick="setGrid(6,this)" title="6 columns">
            <svg viewBox="0 0 16 16"><rect x="0" y="0" width="3" height="6"/><rect x="5" y="0" width="3" height="6"/><rect x="10" y="0" width="3" height="6"/><rect x="0" y="9" width="3" height="6"/><rect x="5" y="9" width="3" height="6"/><rect x="10" y="9" width="3" height="6"/></svg>
          </button>
          <!-- 8 col -->
          <button class="grid-btn" onclick="setGrid(8,this)" title="8 columns">
            <svg viewBox="0 0 16 16"><rect x="0" y="0" width="2" height="7"/><rect x="3" y="0" width="2" height="7"/><rect x="6" y="0" width="2" height="7"/><rect x="9" y="0" width="2" height="7"/><rect x="12" y="0" width="2" height="7"/><rect x="0" y="9" width="2" height="7"/><rect x="3" y="9" width="2" height="7"/><rect x="6" y="9" width="2" height="7"/></svg>
          </button>
          <!-- 12 col / dense -->
          <button class="grid-btn" onclick="setGrid(12,this)" title="12 columns (dense)">
            <svg viewBox="0 0 16 16"><rect x="0" y="0" width="1.5" height="5"/><rect x="2.5" y="0" width="1.5" height="5"/><rect x="5" y="0" width="1.5" height="5"/><rect x="7.5" y="0" width="1.5" height="5"/><rect x="10" y="0" width="1.5" height="5"/><rect x="12.5" y="0" width="1.5" height="5"/><rect x="0" y="7" width="1.5" height="5"/><rect x="2.5" y="7" width="1.5" height="5"/><rect x="5" y="7" width="1.5" height="5"/><rect x="7.5" y="7" width="1.5" height="5"/><rect x="10" y="7" width="1.5" height="5"/><rect x="12.5" y="7" width="1.5" height="5"/></svg>
          </button>
          <!-- List view -->
          <button class="grid-btn" onclick="setList(this)" title="List view">
            <svg viewBox="0 0 16 16"><rect x="0" y="1" width="16" height="3"/><rect x="0" y="6" width="16" height="3"/><rect x="0" y="11" width="16" height="3"/></svg>
          </button>
        </div>

      </div>
    </div>

    <!-- PRODUCT GRID -->
    <div class="product-grid cols-4" id="productGrid">

      <!-- Product 1 -->
      <div class="product-card" data-cat="lips">
        <div class="product-img-wrap">
          <div class="product-img" style="background:linear-gradient(135deg,#f5e6ea,#f0c4cd)">💄</div>
          <span class="product-badge badge-sale">-30%</span>
          <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
          <div class="product-overlay">
            <button class="btn-cart" onclick="addToCart(this)">Add to Cart</button>
            <button class="btn-quick" onclick="openQuickView('💄','SUGAR Cosmetics','Matte as Hell Crayon Lipstick','499','699','30')">Quick View</button>
          </div>
        </div>
        <div class="product-brand">SUGAR Cosmetics</div>
        <div class="product-name">Matte as Hell Crayon Lipstick</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#C84B6C" title="Cherry Red"></div>
          <div class="shade-dot" style="background:#A0304A" title="Wine"></div>
          <div class="shade-dot" style="background:#E8926A" title="Peach"></div>
          <div class="shade-dot" style="background:#8B4A6B" title="Mauve"></div>
          <span class="shade-more">+8</span>
        </div>
        <div class="product-rating"><span class="stars-small">★★★★★</span><span class="rating-num">(2.4k)</span></div>
        <div class="product-price"><span class="price-current">₹499</span><span class="price-mrp">₹699</span><span class="price-off">30% off</span></div>
        <div class="product-desc" style="display:none;">Long-lasting matte crayon lipstick with rich pigment. Comfortable wear for 12+ hours. Available in 12 bold shades perfect for every occasion.</div>
      </div>

      <!-- Product 2 -->
      <div class="product-card" data-cat="face">
        <div class="product-img-wrap">
          <div class="product-img" style="background:linear-gradient(135deg,#fef3e2,#fde0a0)">🌟</div>
          <span class="product-badge badge-sale">-40%</span>
          <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
          <div class="product-overlay">
            <button class="btn-cart" onclick="addToCart(this)">Add to Cart</button>
            <button class="btn-quick" onclick="openQuickView('🌟','Lakmé','9to5 Weightless Foundation','479','799','40')">Quick View</button>
          </div>
        </div>
        <div class="product-brand">Lakmé</div>
        <div class="product-name">9to5 Weightless Mousse Foundation</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#f5d5b0"></div>
          <div class="shade-dot" style="background:#d4a978"></div>
          <div class="shade-dot" style="background:#b08060"></div>
          <div class="shade-dot" style="background:#8b6045"></div>
          <div class="shade-dot" style="background:#6b4030"></div>
          <span class="shade-more">+10</span>
        </div>
        <div class="product-rating"><span class="stars-small">★★★★☆</span><span class="rating-num">(1.8k)</span></div>
        <div class="product-price"><span class="price-current">₹479</span><span class="price-mrp">₹799</span><span class="price-off">40% off</span></div>
        <div class="product-desc" style="display:none;">Buildable coverage foundation with airy mousse texture. SPF 20. Suitable for Indian skin tones. 24-hour wear formula.</div>
      </div>

      <!-- Product 3 -->
      <div class="product-card" data-cat="eyes">
        <div class="product-img-wrap">
          <div class="product-img" style="background:linear-gradient(135deg,#e8e0f5,#c8b0e8)">👁️</div>
          <span class="product-badge badge-new">New</span>
          <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
          <div class="product-overlay">
            <button class="btn-cart" onclick="addToCart(this)">Add to Cart</button>
            <button class="btn-quick" onclick="openQuickView('👁️','Maybelline','Sky High Mascara','649','799','19')">Quick View</button>
          </div>
        </div>
        <div class="product-brand">Maybelline</div>
        <div class="product-name">Sky High Lengthening Mascara</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#1a1a1a"></div>
          <div class="shade-dot" style="background:#4a2060"></div>
        </div>
        <div class="product-rating"><span class="stars-small">★★★★★</span><span class="rating-num">(3.1k)</span></div>
        <div class="product-price"><span class="price-current">₹649</span><span class="price-mrp">₹799</span><span class="price-off">19% off</span></div>
        <div class="product-desc" style="display:none;">Limitless length mascara with flexible fiber brush. Buildable, volumizing formula that doesn't clump.</div>
      </div>

      <!-- Product 4 -->
      <div class="product-card" data-cat="eyes">
        <div class="product-img-wrap">
          <div class="product-img" style="background:linear-gradient(135deg,#1a1a2e,#2d1f3d)">✏️</div>
          <span class="product-badge badge-hot">Hot</span>
          <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
          <div class="product-overlay">
            <button class="btn-cart" onclick="addToCart(this)">Add to Cart</button>
            <button class="btn-quick" onclick="openQuickView('✏️','Faces Canada','Ultime Pro Kohl Kajal','249','399','38')">Quick View</button>
          </div>
        </div>
        <div class="product-brand">Faces Canada</div>
        <div class="product-name">Ultime Pro Kohl Kajal Extra Black</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#1a1a1a"></div>
          <div class="shade-dot" style="background:#2d4a6b"></div>
          <div class="shade-dot" style="background:#4a1a1a"></div>
        </div>
        <div class="product-rating"><span class="stars-small">★★★★★</span><span class="rating-num">(4.2k)</span></div>
        <div class="product-price"><span class="price-current">₹249</span><span class="price-mrp">₹399</span><span class="price-off">38% off</span></div>
        <div class="product-desc" style="display:none;">Extra black, smudge-proof kajal with smooth glide. Waterproof formula. Ophthalmologist tested. 16-hour wear.</div>
      </div>

      <!-- Product 5 -->
      <div class="product-card" data-cat="face">
        <div class="product-img-wrap">
          <div class="product-img" style="background:linear-gradient(135deg,#fde8f0,#fac0d5)">🌸</div>
          <span class="product-badge badge-new">New</span>
          <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
          <div class="product-overlay">
            <button class="btn-cart" onclick="addToCart(this)">Add to Cart</button>
            <button class="btn-quick" onclick="openQuickView('🌸','NYX Professional','Powder Blush','699','899','22')">Quick View</button>
          </div>
        </div>
        <div class="product-brand">NYX Professional</div>
        <div class="product-name">Professional Powder Blush & Contour</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#f0a0b0"></div>
          <div class="shade-dot" style="background:#d4786a"></div>
          <div class="shade-dot" style="background:#e8c090"></div>
          <div class="shade-dot" style="background:#b87858"></div>
        </div>
        <div class="product-rating"><span class="stars-small">★★★★☆</span><span class="rating-num">(892)</span></div>
        <div class="product-price"><span class="price-current">₹699</span><span class="price-mrp">₹899</span><span class="price-off">22% off</span></div>
        <div class="product-desc" style="display:none;">Finely milled powder blush that delivers buildable, natural-looking color. Long-wearing formula with mirror-perfect finish.</div>
      </div>

      <!-- Product 6 -->
      <div class="product-card" data-cat="lips">
        <div class="product-img-wrap">
          <div class="product-img" style="background:linear-gradient(135deg,#e8f0e0,#b8d898)">💚</div>
          <span class="product-badge badge-sale">-25%</span>
          <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
          <div class="product-overlay">
            <button class="btn-cart" onclick="addToCart(this)">Add to Cart</button>
            <button class="btn-quick" onclick="openQuickView('💚','L\'Oréal Paris','Color Riche Lipstick','449','599','25')">Quick View</button>
          </div>
        </div>
        <div class="product-brand">L'Oréal Paris</div>
        <div class="product-name">Color Riche Satin Lipstick</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#C84B6C"></div>
          <div class="shade-dot" style="background:#f08060"></div>
          <div class="shade-dot" style="background:#d4a090"></div>
          <div class="shade-dot" style="background:#8b2d2d"></div>
          <span class="shade-more">+16</span>
        </div>
        <div class="product-rating"><span class="stars-small">★★★★☆</span><span class="rating-num">(1.5k)</span></div>
        <div class="product-price"><span class="price-current">₹449</span><span class="price-mrp">₹599</span><span class="price-off">25% off</span></div>
        <div class="product-desc" style="display:none;">Classic satin-finish lipstick enriched with floral oils for soft, smooth lips. Rich pigment in one swipe.</div>
      </div>

      <!-- Product 7 -->
      <div class="product-card" data-cat="face">
        <div class="product-img-wrap">
          <div class="product-img" style="background:linear-gradient(135deg,#fff0e0,#ffd090)">☀️</div>
          <span class="product-badge badge-hot">Hot</span>
          <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
          <div class="product-overlay">
            <button class="btn-cart" onclick="addToCart(this)">Add to Cart</button>
            <button class="btn-quick" onclick="openQuickView('☀️','Lakmé','Sun Expert SPF50','399','499','20')">Quick View</button>
          </div>
        </div>
        <div class="product-brand">Lakmé</div>
        <div class="product-name">Sun Expert Ultra Matte SPF 50 PA+++</div>
        <div class="product-shades"></div>
        <div class="product-rating"><span class="stars-small">★★★★★</span><span class="rating-num">(5.6k)</span></div>
        <div class="product-price"><span class="price-current">₹399</span><span class="price-mrp">₹499</span><span class="price-off">20% off</span></div>
        <div class="product-desc" style="display:none;">Lightweight matte sunscreen with broad spectrum SPF 50 PA+++ protection. Non-greasy formula perfect for Indian summers.</div>
      </div>

      <!-- Product 8 -->
      <div class="product-card" data-cat="nails">
        <div class="product-img-wrap">
          <div class="product-img" style="background:linear-gradient(135deg,#f0e8f8,#d0b0f0)">💅</div>
          <span class="product-badge badge-new">New</span>
          <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
          <div class="product-overlay">
            <button class="btn-cart" onclick="addToCart(this)">Add to Cart</button>
            <button class="btn-quick" onclick="openQuickView('💅','SUGAR','Nail Couture Ultra Shine','299','399','25')">Quick View</button>
          </div>
        </div>
        <div class="product-brand">SUGAR Cosmetics</div>
        <div class="product-name">Nail Couture Ultra Shine Nail Polish</div>
        <div class="product-shades">
          <div class="shade-dot" style="background:#c84b8c"></div>
          <div class="shade-dot" style="background:#4b6cc8"></div>
          <div class="shade-dot" style="background:#c8944b"></div>
          <div class="shade-dot" style="background:#4bc890"></div>
          <div class="shade-dot" style="background:#c84b4b"></div>
          <span class="shade-more">+20</span>
        </div>
        <div class="product-rating"><span class="stars-small">★★★★★</span><span class="rating-num">(1.1k)</span></div>
        <div class="product-price"><span class="price-current">₹299</span><span class="price-mrp">₹399</span><span class="price-off">25% off</span></div>
        <div class="product-desc" style="display:none;">High-shine nail polish with chip-resistant formula. 5-free formula. Salon-like finish at home. Long-lasting 7-day wear.</div>
      </div>

    </div>

    <!-- PAGINATION -->
    <div class="pagination-wrap">
      <div style="font-size:13px; color:var(--muted); font-weight:300;">Page <strong style="color:var(--dark);">1</strong> of 7</div>
      <div class="pagination">
        <a href="#" class="page-btn disabled">‹</a>
        <a href="#" class="page-btn active">1</a>
        <a href="#" class="page-btn">2</a>
        <a href="#" class="page-btn">3</a>
        <span class="page-dots">…</span>
        <a href="#" class="page-btn">7</a>
        <a href="#" class="page-btn">›</a>
      </div>
      <button class="load-more-btn" onclick="loadMore(this)">Load More Products</button>
    </div>

  </main>
</div>

<!-- COMPARE BAR -->
<div class="compare-bar" id="compareBar">
  <div style="display:flex; align-items:center; gap:20px;">
    <span class="compare-label">Compare:</span>
    <div class="compare-items" id="compareItems"></div>
  </div>
  <div style="display:flex; gap:8px;">
    <button class="compare-clear" onclick="clearCompare()">Clear</button>
    <button class="btn-compare">Compare Now →</button>
  </div>
</div>

<!-- QUICK VIEW MODAL -->
<div class="modal-overlay" id="quickModal" onclick="closeModal(event)">
  <div class="modal-box" style="position:relative;">
    <button class="modal-close" onclick="document.getElementById('quickModal').classList.remove('open')">✕</button>
    <div class="modal-inner">
      <div class="modal-img-side" id="modalImg">💄</div>
      <div class="modal-info-side">
        <div class="modal-brand" id="modalBrand">SUGAR Cosmetics</div>
        <div class="modal-name" id="modalName">Matte as Hell Crayon Lipstick</div>
        <div class="modal-price-row">
          <span class="modal-price" id="modalPrice">₹499</span>
          <span class="modal-mrp" id="modalMrp">₹699</span>
          <span class="modal-off" id="modalOff">30% off</span>
        </div>
        <div class="modal-section">
          <div class="modal-section-label">Select Shade</div>
          <div class="modal-shades">
            <div class="modal-shade active" style="background:#C84B6C" onclick="selectShade(this)"></div>
            <div class="modal-shade" style="background:#A0304A" onclick="selectShade(this)"></div>
            <div class="modal-shade" style="background:#E8926A" onclick="selectShade(this)"></div>
            <div class="modal-shade" style="background:#8B4A6B" onclick="selectShade(this)"></div>
            <div class="modal-shade" style="background:#D4A56A" onclick="selectShade(this)"></div>
          </div>
        </div>
        <div class="modal-section">
          <div class="modal-section-label">Quantity</div>
          <div class="modal-qty">
            <button class="qty-btn" onclick="changeQty(-1)">−</button>
            <input class="qty-val" id="modalQty" value="1" readonly>
            <button class="qty-btn" onclick="changeQty(1)">+</button>
          </div>
        </div>
        <button class="modal-add-btn" onclick="addToCartModal()">Add to Cart</button>
        <button class="modal-view-btn">View Full Details →</button>
      </div>
    </div>
  </div>
</div>

<script>
// Grid cols
function setGrid(n, btn) {
  const grid = document.getElementById('productGrid');
  grid.className = 'product-grid cols-' + n;
  document.querySelectorAll('.grid-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
function setList(btn) {
  const grid = document.getElementById('productGrid');
  grid.className = 'product-grid list-view';
  document.querySelectorAll('.grid-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  // Add list-view specific elements
  document.querySelectorAll('.product-card').forEach(card => {
    if (!card.querySelector('.product-info')) {
      const info = card.querySelector('.product-img-wrap').nextElementSibling;
      const div = document.createElement('div');
      div.className = 'product-info';
      let children = [];
      let el = card.querySelector('.product-img-wrap').nextElementSibling;
      while (el) {
        children.push(el);
        el = el.nextElementSibling;
      }
      children.forEach(c => {
        if (!c.classList.contains('product-actions-list')) div.appendChild(c);
      });
      card.insertBefore(div, card.querySelector('.product-overlay') || null);

      // Actions
      if (!card.querySelector('.product-actions-list')) {
        const acts = document.createElement('div');
        acts.className = 'product-actions';
        acts.innerHTML = `
          <div class="product-price" style="margin-bottom:10px;">${card.querySelector('.product-price') ? card.querySelector('.product-price').innerHTML : ''}</div>
          <button class="btn-list-cart" onclick="addToCart(this)">Add to Cart</button>
          <button class="btn-list-wish">♡ Wishlist</button>
        `;
        card.appendChild(acts);
      }
    }
  });
}

// Filter collapsible
function toggleFilter(header) {
  const body = header.nextElementSibling;
  const toggle = header.querySelector('.filter-toggle');
  body.classList.toggle('collapsed');
  toggle.classList.toggle('open');
}

// Category tabs
function filterCat(btn, cat) {
  document.querySelectorAll('.cat-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  const cards = document.querySelectorAll('.product-card');
  cards.forEach(card => {
    if (cat === 'all' || card.dataset.cat === cat) {
      card.style.display = '';
    } else {
      card.style.display = 'none';
    }
  });
}

// Active filter tags
const activeTags = new Set();
function addFilterTag(name) {
  if (activeTags.has(name)) { activeTags.delete(name); } else { activeTags.add(name); }
  renderTags();
}
function toggleSwatch(el, name) {
  el.classList.toggle('active');
  if (el.classList.contains('active')) { activeTags.add(name); } else { activeTags.delete(name); }
  renderTags();
}
function renderTags() {
  const container = document.getElementById('filterTagsContainer');
  const wrapper = document.getElementById('activeFilters');
  container.innerHTML = '';
  if (activeTags.size === 0) { wrapper.style.display = 'none'; return; }
  wrapper.style.display = 'block';
  activeTags.forEach(tag => {
    const el = document.createElement('div');
    el.className = 'filter-tag';
    el.innerHTML = `${tag} <span class="remove" onclick="removeTag('${tag}')">✕</span>`;
    container.appendChild(el);
  });
}
function removeTag(name) {
  activeTags.delete(name);
  // Uncheck matching checkbox
  document.querySelectorAll('.filter-checkbox').forEach(cb => {
    if (cb.closest('.filter-option')?.querySelector('.filter-label')?.textContent.trim() === name) cb.checked = false;
  });
  renderTags();
}
function clearAllFilters() {
  activeTags.clear();
  document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);
  document.querySelectorAll('.swatch-filter').forEach(s => s.classList.remove('active'));
  renderTags();
}

// Wishlist
function toggleWish(btn) {
  btn.classList.toggle('active');
  btn.textContent = btn.classList.contains('active') ? '♥' : '♡';
  btn.style.color = btn.classList.contains('active') ? 'var(--rose)' : '';
}

// Add to cart
function addToCart(btn) {
  const count = document.getElementById('cartCount');
  count.textContent = parseInt(count.textContent) + 1;
  const orig = btn.textContent;
  btn.textContent = '✓ Added!';
  btn.style.background = 'var(--rose)'; btn.style.color = '#fff';
  setTimeout(() => { btn.textContent = orig; btn.style.background = ''; btn.style.color = ''; }, 1500);
}

// Load More
function loadMore(btn) {
  btn.textContent = 'Loading...'; btn.classList.add('loading');
  setTimeout(() => { btn.textContent = 'Load More Products'; btn.classList.remove('loading'); }, 1500);
}

// Sort (visual only)
function sortProducts(val) {
  console.log('Sort:', val);
}

// Quick View Modal
function openQuickView(icon, brand, name, price, mrp, off) {
  document.getElementById('modalImg').textContent = icon;
  document.getElementById('modalBrand').textContent = brand;
  document.getElementById('modalName').textContent = name;
  document.getElementById('modalPrice').textContent = '₹' + price;
  document.getElementById('modalMrp').textContent = '₹' + mrp;
  document.getElementById('modalOff').textContent = off + '% off';
  document.getElementById('modalQty').value = 1;
  document.getElementById('quickModal').classList.add('open');
}
function closeModal(e) {
  if (e.target.id === 'quickModal') document.getElementById('quickModal').classList.remove('open');
}
function selectShade(el) {
  document.querySelectorAll('.modal-shade').forEach(s => s.classList.remove('active'));
  el.classList.add('active');
}
function changeQty(delta) {
  const input = document.getElementById('modalQty');
  const val = Math.max(1, Math.min(10, parseInt(input.value) + delta));
  input.value = val;
}
function addToCartModal() {
  const count = document.getElementById('cartCount');
  count.textContent = parseInt(count.textContent) + parseInt(document.getElementById('modalQty').value);
  document.getElementById('quickModal').classList.remove('open');
}

// Pagination
document.querySelectorAll('.page-btn:not(.disabled)').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    if (this.textContent === '‹' || this.textContent === '›') return;
    document.querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});

// Sidebar mobile
function toggleSidebar() {
  const sb = document.getElementById('sidebar');
  const ov = document.getElementById('sidebarOverlay');
  sb.classList.toggle('open');
  ov.style.display = sb.classList.contains('open') ? 'block' : 'none';
}

// Staggered animation on scroll
const observer = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.style.animationPlayState = 'running'; });
}, { threshold: 0.05 });
document.querySelectorAll('.product-card').forEach(card => {
  card.style.animationPlayState = 'paused';
  observer.observe(card);
});
</script>
</body>
</html>