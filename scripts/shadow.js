document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('header');
    const targetSection = document.getElementById('hero-section'); // The section that triggers the shadow

    if (!header || !targetSection) {
        console.warn("Header or target section not found. Dynamic shadow will not work.");
        return; // Exit if elements aren't found
    }

    // Function to check if the header is over the target section
    function checkShadowVisibility() {
        if (window.scrollY < targetSection.offsetHeight) {
            header.classList.add('header-shadow');
        } else {
            header.classList.remove('header-shadow');
        }
    }

    // Add a scroll event listener to the window
    window.addEventListener('scroll', checkShadowVisibility);

    // Also call it once on load in case the page loads scrolled or the section is initially in view
    checkShadowVisibility();
});