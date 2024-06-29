(() => {
    'use strict'

    const getStoredTheme = () => localStorage.getItem('theme')
    const setStoredTheme = theme => localStorage.setItem('theme', theme)

    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme()
        if (storedTheme) {
        return storedTheme
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    }

    const setTheme = theme => {
        if (theme === 'auto') {
        document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
        } else {
        document.documentElement.setAttribute('data-bs-theme', theme)
        }
    }

    setTheme(getPreferredTheme())

    const showActiveTheme = (theme, focus = false) => {
        const themeSwitcher = document.querySelector('#bd-theme')

        if (!themeSwitcher) {
        return
        }

        const themeSwitcherText = document.querySelector('#bd-theme-text')
        const activeThemeIcon = document.querySelector('.theme-icon-active use')
        const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
        const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

        document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
        element.classList.remove('active')
        element.setAttribute('aria-pressed', 'false')
        })

        btnToActive.classList.add('active')
        btnToActive.setAttribute('aria-pressed', 'true')
        activeThemeIcon.setAttribute('href', svgOfActiveBtn)
        const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
        themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)

        if (focus) {
        themeSwitcher.focus()
        }
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const storedTheme = getStoredTheme()
        if (storedTheme !== 'light' && storedTheme !== 'dark') {
        setTheme(getPreferredTheme())
        }
    })

    window.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme())

        document.querySelectorAll('[data-bs-theme-value]')
        .forEach(toggle => {
            toggle.addEventListener('click', () => {
            const theme = toggle.getAttribute('data-bs-theme-value')
            setStoredTheme(theme)
            setTheme(theme)
            showActiveTheme(theme, true)
            })
        })
    })
    })()

    // Function to hide the loading screen
    function hideLoadingScreen() {
        var loadingScreen = document.getElementById('loading-screen');
        loadingScreen.classList.add('fade-out');
        setTimeout(function() {
            loadingScreen.style.display = 'none';
        }, 500); // Match this to the CSS transition duration
    }

    // Set the minimum display time for the loading screen
    var minimumLoadingTime = 2500; // 3 seconds (adjust this to the duration of your GIF animation)

    // Function to set the background color based on the current theme
    function setLoadingScreenBackgroundColor() {
        var loadingScreen = document.getElementById('loading-screen');
        var theme = document.documentElement.getAttribute('data-bs-theme'); // Get the current theme from the attribute

        if (theme === 'dark') {
            loadingScreen.style.backgroundColor = 'rgba(10, 10, 10)'; // Dark theme background color
        } else {
            loadingScreen.style.backgroundColor = 'rgba(255, 255, 255)'; // Light theme background color
        }
    }

    // Show the loading screen when the page starts loading
    document.getElementById('loading-screen').style.display = 'flex';
    setLoadingScreenBackgroundColor();

    // Check if the page has already loaded
    if (document.readyState === 'complete') {
        // If the page has already loaded, set a timeout to hide the loading screen
        setTimeout(hideLoadingScreen, minimumLoadingTime);
    } else {
        // If the page hasn't loaded yet, add an event listener to hide the loading screen after the page loads
        window.addEventListener('load', function () {
            setTimeout(hideLoadingScreen, minimumLoadingTime);
        });
    }

    // Update loading screen background color when the theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', setLoadingScreenBackgroundColor);
    window.addEventListener('DOMContentLoaded', setLoadingScreenBackgroundColor);