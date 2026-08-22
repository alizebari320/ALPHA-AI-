{{-- Auth Background Effects - Neon Grid Design System --}}
<div class="fx-grid" aria-hidden="true"></div>
<div class="fx-floor" aria-hidden="true"></div>
<div class="fx-horizon" aria-hidden="true"></div>
<div class="fx-scan" aria-hidden="true"></div>
<div class="fx-noise" aria-hidden="true"></div>

{{-- Gradient Glow Orbs --}}
<div class="fx-glow fx-glow-cyan top-1/4 -left-48 w-96 h-96" aria-hidden="true"></div>
<div class="fx-glow fx-glow-pink top-1/3 -right-56 w-[22rem] h-[22rem]" aria-hidden="true"></div>
<div class="fx-glow fx-glow-violet bottom-20 left-1/2 -translate-x-1/2 w-96 h-96" aria-hidden="true"></div>

{{-- Mouse-following cursor halo --}}
<div class="fx-cursor" id="fx-cursor" aria-hidden="true" style="transition: transform 0.15s ease-out;"></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cursor = document.getElementById('fx-cursor');
    if (!cursor) return;
    let raf = null;
    document.addEventListener('mousemove', e => {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(() => {
            cursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
            cursor.classList.add('is-live');
        });
    });
    document.addEventListener('mouseleave', () => cursor.classList.remove('is-live'));
});
</script>
