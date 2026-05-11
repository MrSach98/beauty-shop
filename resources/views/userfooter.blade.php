
<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div class="footer-top">
      <div>
        <div class="footer-brand-name">Glow<em>Nova</em></div>
        <div class="footer-brand-desc">India ka premium beauty destination. Authentic, curated, and delivered with love. Har skin type ke liye, har budget mein.</div>
        <div class="footer-socials">
          <a href="#" class="social-btn">📘</a>
          <a href="#" class="social-btn">📸</a>
          <a href="#" class="social-btn">▶️</a>
          <a href="#" class="social-btn">🐦</a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Shop</h4>
        <ul>
          <li><a href="#">Skincare</a></li>
          <li><a href="#">Makeup</a></li>
          <li><a href="#">Haircare</a></li>
          <li><a href="#">Fragrance</a></li>
          <li><a href="#">Body Care</a></li>
          <li><a href="#">Organic</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Help</h4>
        <ul>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">Return Policy</a></li>
          <li><a href="#">Shipping Info</a></li>
          <li><a href="#">FAQs</a></li>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Skin Quiz</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Blog & Tips</a></li>
          <li><a href="#">Sell on GlowNova</a></li>
          <li><a href="#">Affiliate Program</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms & Conditions</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-copy">© 2025 GlowNova Beauty Pvt. Ltd. All rights reserved.</div>
      <div class="payment-logos">
        <span class="pay-badge">UPI</span>
        <span class="pay-badge">Visa</span>
        <span class="pay-badge">Mastercard</span>
        <span class="pay-badge">RuPay</span>
        <span class="pay-badge">COD</span>
        <span class="pay-badge">EMI</span>
      </div>
    </div>
  </div>
</footer>

<script>
  // Hero Slider
  let currentSlide = 0;
  const slides = document.querySelectorAll('.hero-slide');
  const dots = document.querySelectorAll('.dot');

  function goToSlide(n) {
    slides[currentSlide].classList.remove('active');
    dots[currentSlide].classList.remove('active');
    currentSlide = n;
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
  }

  setInterval(() => {
    goToSlide((currentSlide + 1) % slides.length);
  }, 5000);

  // Scroll Animations
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) e.target.classList.add('visible');
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

  // Newsletter button
  document.querySelector('.newsletter-btn').addEventListener('click', function() {
    const input = document.querySelector('.newsletter-input');
    if (input.value.includes('@')) {
      this.textContent = '✓ Subscribed!';
      this.style.background = '#5a9e6a';
      input.value = '';
      setTimeout(() => { this.textContent = 'Subscribe'; this.style.background = ''; }, 3000);
    } else {
      input.style.borderColor = 'var(--rose)';
      setTimeout(() => input.style.borderColor = '', 2000);
    }
  });

  // Add to Cart buttons
  document.querySelectorAll('.prod-btn:not(.wish)').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const badge = document.querySelector('.cart-badge');
      badge.textContent = parseInt(badge.textContent) + 1;
      this.textContent = '✓ Added!';
      this.style.background = 'var(--rose)';
      this.style.color = '#fff';
      setTimeout(() => {
        this.textContent = 'Add to Cart';
        this.style.background = '';
        this.style.color = '';
      }, 1500);
    });
  });

  // Wishlist buttons
  document.querySelectorAll('.prod-btn.wish').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      this.style.color = this.style.color === 'var(--rose)' ? '' : 'var(--rose)';
      this.textContent = this.textContent === '♡' ? '♥' : '♡';
    });
  });

  // Nav wishlist
  document.querySelectorAll('.nav-icon').forEach(icon => {
    if (icon.textContent.trim() === '♡') {
      icon.addEventListener('click', function(e) {
        e.preventDefault();
        this.textContent = this.textContent === '♡' ? '♥' : '♡';
      });
    }
  });
</script>
</body>
</html>