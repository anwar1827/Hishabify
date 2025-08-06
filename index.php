<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hishabify - Smart Mobile Shop</title>
  <link rel="stylesheet" href="assets/css/style1.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <!-- ✅ HEADER -->
  <header class="header">
    <div class="logo">📱 Hishabify</div>
    <nav class="nav">
      <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
    <div class="menu-toggle">☰</div>
  </header>

  <!-- ✅ HERO SECTION -->
  <section id="home" class="hero">
    <h1>Welcome to Hishabify</h1>
    <p>The smartest mobile shop management system for your business.</p>
    <a href="#features" class="btn">🚀 Explore Features</a>
    <a href="login.php" class="btn secondary">🔐 Login Now</a>
  </section>

  <!-- ✅ FEATURES SECTION -->
  <section id="features" class="features">
    <h2>✨ Why Customers Love Us</h2>
    <div class="feature-boxes">
      <div class="feature">🔍 Track All Products</div>
      <div class="feature">🧾 Instant Invoicing</div>
      <div class="feature">📦 Category-wise View</div>
      <div class="feature">🔐 Warranty Tracking</div>
      <div class="feature">📈 Transparent Reporting</div>
      <div class="feature">💬 SMS & Contact Info Save</div>
    </div>
  </section>

  <!-- ✅ SALES CHART -->
  <section class="sales-chart">
    <h2>📊 Sales Overview (Last 6 Months)</h2>
    <canvas id="salesChart" width="400" height="150"></canvas>
  </section>

  <!-- ✅ ABOUT US -->
  <section id="about" class="about">
    <h2>About Hishabify</h2>
    <p>Hishabify is your digital partner for mobile shop management. We help you simplify product handling, sales, reporting, and performance tracking with ease.</p>
    <p><strong>Mission:</strong> Make shop management effortless.</p>
    <p><strong>Vision:</strong> Empower every mobile shop to go digital.</p>
  </section>

  <!-- ✅ FOOTER -->
  <footer class="footer">
    <div class="footer-content">
      <p>📧 Email: support@hishabify.com | 📞 Phone: 017XXXXXXXX</p>
      <p>📍 Address: Dhanmondi, Dhaka, Bangladesh</p>
      <div class="social-icons">
        <a href="#">🌐</a>
        <a href="#">📘</a>
        <a href="#">📷</a>
      </div>
    </div>
    <p>&copy; <?= date('Y') ?> Hishabify. All rights reserved.</p>
  </footer>

  <script src="assets/js/script.js"></script>
  <script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
        datasets: [{
          label: 'Sales (৳)',
          data: [12000, 19000, 3000, 5000, 22000, 24000],
          borderWidth: 1,
          backgroundColor: '#00c3ff'
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
