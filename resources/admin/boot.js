import './Bits/underscoreGuard';
import AdvancedTestimonialCarousel from "./Bits/AdvancedTestimonialCarousel";

window.AdvancedTestimonialCarousel = new AdvancedTestimonialCarousel();

// Restore WordPress's Underscore so core screens (Themes, Media, Customizer...) keep working.
if (typeof window.__atcPrevUnderscore !== 'undefined') {
    window._ = window.__atcPrevUnderscore;
} else {
    try { delete window._; } catch (e) { window._ = undefined; }
}
delete window.__atcPrevUnderscore;
