// Immediately set the theme based on local storage
const darkMode = localStorage.getItem('darkMode');
const themeClass = darkMode === 'enabled' ? 'dark' : 'light';

// Apply the theme class to the document
document.documentElement.className = themeClass;

// Wait for DOM to be fully loaded before adding event listeners
document.addEventListener("DOMContentLoaded", function() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const lightModeToggle = document.getElementById('light-mode-toggle');

    function toggleMode(isDarkMode) {
        if (isDarkMode) {
            document.documentElement.classList.add('dark');
            darkModeToggle?.classList.remove('activate');
            lightModeToggle?.classList.add('activate');
            localStorage.setItem('darkMode', 'enabled');
        } else {
            document.documentElement.classList.remove('dark');
            lightModeToggle?.classList.remove('activate');
            darkModeToggle?.classList.add('activate');
            localStorage.setItem('darkMode', 'disabled');
        }
    }

    if (darkModeToggle && lightModeToggle) {
        if (themeClass === 'dark') {
            darkModeToggle.classList.remove('activate');
            lightModeToggle.classList.add('activate');
        } else {
            lightModeToggle.classList.remove('activate');
            darkModeToggle.classList.add('activate');
        }

        darkModeToggle.addEventListener('click', () => toggleMode(true));
        lightModeToggle.addEventListener('click', () => toggleMode(false));
    }
});
