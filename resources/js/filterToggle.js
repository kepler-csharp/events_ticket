// ─── FILTER TOGGLE JS ───────────────────────────────────
document.querySelectorAll('.filter-group input[type="checkbox"]').forEach(cb => {
    const label = document.querySelector('label[for="' + cb.id + '"]');
    if (!label) return;

    // Restore state on page load (e.g. after back navigation)
    if (cb.checked) label.classList.add('filter-active');

    label.addEventListener('click', () => {
        // Let browser toggle the checkbox first (next tick)
        console.log("clicked")
        setTimeout(() => {
            label.classList.toggle('filter-active', cb.checked);
        }, 0);
    });
});
