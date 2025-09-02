/*  ALPHA – Next-Gen AI Directory  |  alpha.js  */

(function () {
  "use strict";

  /* ---------- 1.  CURSOR  ---------- */
  const cursor      = document.querySelector(".cursor");
  const cursorDot   = document.querySelector(".cursor-dot");

  function moveCursor(e) {
    if (window.innerWidth <= 768) return;
    cursor.style.left = cursorDot.style.left = e.clientX + "px";
    cursor.style.top  = cursorDot.style.top  = e.clientY + "px";
  }
  function addHover(el) {
    el.addEventListener("mouseenter", () => cursor.classList.add("hover"));
    el.addEventListener("mouseleave", () => cursor.classList.remove("hover"));
  }
  if (cursor && cursorDot) {
    document.addEventListener("mousemove", moveCursor);
    document.querySelectorAll("a, button, .category-header, .tool-link")
            .forEach(addHover);
  }

  /* ---------- 2.  SMOOTH SCROLL  ---------- */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener("click", e => {
      e.preventDefault();
      const tgt = document.querySelector(anchor.getAttribute("href"));
      if (tgt) tgt.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  });

  /* ---------- 3.  NAV SHRINK ON SCROLL  ---------- */
  const nav = document.querySelector("nav");
  window.addEventListener("scroll", () =>
    nav.classList.toggle("scrolled", window.scrollY > 50)
  );

  /* ---------- 4.  CATEGORY EXPAND / COLLAPSE  ---------- */
  /* ---------- 5.  SCROLL-TRIGGERED ANIMATIONS  ---------- */
  function revealOnScroll() {
    const reveals = document.querySelectorAll('.reveal-on-scroll');
    const windowHeight = window.innerHeight;
    reveals.forEach(el => {
      const elementTop = el.getBoundingClientRect().top;
      if (elementTop < windowHeight - 100) {
        el.classList.add('revealed');
      } else {
        el.classList.remove('revealed');
      }
    });
  }
  window.addEventListener('scroll', revealOnScroll);
  window.addEventListener('resize', revealOnScroll);
  document.addEventListener('DOMContentLoaded', revealOnScroll);

  /* ---------- 6.  MODERN SCROLL ANIMATION (FADE/SLIDE) ---------- */
  let lastScrollY = window.scrollY;
  let tickingScroll = false;
  function modernScrollAnim() {
    if (!tickingScroll) {
      window.requestAnimationFrame(() => {
        const direction = window.scrollY > lastScrollY ? 'down' : 'up';
        document.body.classList.remove('scroll-up', 'scroll-down');
        document.body.classList.add(direction === 'down' ? 'scroll-down' : 'scroll-up');
        lastScrollY = window.scrollY;
        tickingScroll = false;
      });
      tickingScroll = true;
    }
  }
  window.addEventListener('scroll', modernScrollAnim);
  document.querySelectorAll(".category-header").forEach(header => {
    header.addEventListener("click", () => {
      const parent = header.parentElement;
      const wasOpen = parent.classList.contains("expanded");

      // close all
      document.querySelectorAll(".category").forEach(c => c.classList.remove("expanded"));

      if (!wasOpen) {
        parent.classList.add("expanded");
        parent.querySelectorAll(".tool").forEach((tool, idx) => {
          tool.style.opacity = 0;
          tool.style.transform = "translateX(-20px)";
          setTimeout(() => {
            tool.style.transition = "all .4s ease";
            tool.style.opacity = 1;
            tool.style.transform = "translateX(0)";
          }, idx * 50);
        });
      }
    });
  });

  /* ---------- 5.  HERO PARTICLES  ---------- */
  const pContainer = document.getElementById("hero-particles");
  if (pContainer) {
    for (let i = 0; i < 50; i++) {
      const dot = document.createElement("div");
      dot.className = "particle";
      dot.style.left = Math.random() * 100 + "%";
      dot.style.animationDelay = Math.random() * 10 + "s";
      dot.style.animationDuration = 10 + Math.random() * 10 + "s";
      pContainer.appendChild(dot);
    }
  }

  /* ---------- 6.  INTERSECTION OBSERVER (fade-in)  ---------- */
  const io = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = 0;
          entry.target.style.transform = "translateY(40px)";
          setTimeout(() => {
            entry.target.style.transition = "all .8s ease";
            entry.target.style.opacity = 1;
            entry.target.style.transform = "translateY(0)";
          }, 100);
          io.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.1, rootMargin: "0px 0px -50px 0px" }
  );
  document.querySelectorAll(".category").forEach(el => io.observe(el));

  /* ---------- 7.  DYNAMIC HERO SUBTITLE TYPEWRITER  ---------- */
  const subtitle = document.querySelector(".hero-subtitle");
  if (subtitle) {
    const text = subtitle.textContent.trim();
    subtitle.textContent = "";
    let i = 0;
    const type = () => {
      if (i < text.length) {
        subtitle.textContent += text[i++];
        setTimeout(type, 50);
      }
    };
    setTimeout(type, 1000);
  }

  /* ---------- 8.  MAGNETIC BUTTON EFFECT  ---------- */
  document.querySelectorAll(".tool-link, .cta-button").forEach(btn => {
    btn.addEventListener("mousemove", e => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      btn.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px) scale(1.05)`;
    });
    btn.addEventListener("mouseleave", () => {
      btn.style.transform = "";
    });
  });

  /* ---------- 9.  ROTATING GRADIENT BACKGROUND  ---------- */
  let angle = 0;
  function rotateGradient() {
    angle = (angle + 0.3) % 360;
    const bg = document.querySelector(".bg-animation");
    if (bg) bg.style.background = `linear-gradient(${angle}deg, var(--bg-primary), var(--bg-secondary))`;
    requestAnimationFrame(rotateGradient);
  }
  rotateGradient();
})();