document.addEventListener("DOMContentLoaded", function () {
  const fadeElements = document.querySelectorAll(".fade-in");
  fadeElements.forEach(el => {
    el.style.opacity = 0;
    el.style.transform = "translateY(20px)";
  });

  window.addEventListener("scroll", function () {
    fadeElements.forEach(el => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight - 100) {
        el.style.transition = "all 0.6s ease-out";
        el.style.opacity = 1;
        el.style.transform = "translateY(0)";
      }
    });
  });
});
