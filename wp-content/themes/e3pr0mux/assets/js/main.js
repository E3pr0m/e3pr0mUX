/* E3pr0mUX — main.js */
(function () {
  'use strict';

  /* ── Cursor ─────────────────────────────────────── */
  const cursor = document.getElementById('cursor');
  if (cursor) {
    document.addEventListener('mousemove', e => {
      cursor.style.left = e.clientX + 'px';
      cursor.style.top  = e.clientY + 'px';
    });
    document.querySelectorAll('a, button, .service-item, .work-item, .e3-portfolio-archive-item').forEach(el => {
      el.addEventListener('mouseenter', () => cursor.classList.add('expand'));
      el.addEventListener('mouseleave', () => cursor.classList.remove('expand'));
    });
  }

  /* ── Hero title fluid fit ────────────────────────── */
  function fitTitle() {
    const el = document.getElementById('hero-word');
    if (!el) return;
    const hero  = el.closest('.hero') || el.closest('#hero');
    if (!hero) return;
    const pl    = parseFloat(getComputedStyle(hero).paddingLeft);
    const pr    = parseFloat(getComputedStyle(hero).paddingRight);
    const avail = hero.clientWidth - pl - pr;
    el.style.fontSize = '100px';
    const ratio = avail / el.scrollWidth;
    el.style.fontSize = (100 * ratio * 0.97) + 'px';
  }
  fitTitle();
  window.addEventListener('resize', fitTitle);

  /* ── Manifesto scroll reveal ─────────────────────── */
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.25 });

  document.querySelectorAll('.manifesto-line').forEach((el, i) => {
    el.style.transitionDelay = (i * 0.12) + 's';
    observer.observe(el);
  });

  /* ── Nav: scroll opacity + burger ───────────────── */
  const nav = document.getElementById('e3-nav');
  if (nav) {
    window.addEventListener('scroll', () => {
      nav.style.borderBottomColor = window.scrollY > 20
        ? 'rgba(240,237,232,.12)'
        : 'rgba(240,237,232,.06)';
    }, { passive: true });
  }

  const burger = document.getElementById('e3-burger');
  if (burger) {
    burger.addEventListener('click', () => {
      const menu    = document.querySelector('.e3-nav__menu');
      const cta     = document.querySelector('.e3-nav__cta');
      const expanded = burger.getAttribute('aria-expanded') === 'true';
      burger.setAttribute('aria-expanded', !expanded);
      if (menu) menu.classList.toggle('is-open');
      if (cta)  cta.classList.toggle('is-open');
    });
  }

  /* ── Portfolio filter (archive) ──────────────────── */
  const filterBtns = document.querySelectorAll('.e3-filter-btn');
  if (filterBtns.length) {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('is-active'));
        btn.classList.add('is-active');

        const filter = btn.dataset.filter;
        document.querySelectorAll('.e3-portfolio-archive-item').forEach(item => {
          if (filter === '*') {
            item.classList.remove('is-hidden');
          } else {
            const cats = (item.dataset.cats || '').split(' ');
            item.classList.toggle('is-hidden', !cats.includes(filter));
          }
        });
      });
    });
  }

  /* ── Logo scramble ────────────────────────────────── */
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$%&';
  function scramble(el, original, iter) {
    if (iter >= original.length * 2) { el.textContent = original; return; }
    el.textContent = original.split('').map((c, i) => {
      if (i < Math.floor(iter / 2)) return c;
      if (c === ' ') return ' ';
      return chars[Math.floor(Math.random() * chars.length)];
    }).join('');
    requestAnimationFrame(() => scramble(el, original, iter + 1));
  }

  document.querySelectorAll('.e3-nav__logo').forEach(el => {
    const orig = el.textContent;
    el.addEventListener('mouseenter', () => scramble(el, orig, 0));
  });

  /* ── Smooth anchor scroll ─────────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (!target) return;
      e.preventDefault();
      const navH = (document.getElementById('e3-nav') || { offsetHeight: 72 }).offsetHeight;
      window.scrollTo({ top: target.getBoundingClientRect().top + window.scrollY - navH, behavior: 'smooth' });
    });
  });

})();
