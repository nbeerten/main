import Alpine from 'alpinejs';

window.Alpine = Alpine

Alpine.start()

addEventListener('DOMContentLoaded', () => polyfill());
addEventListener('load', () => goatcounterstats());

/**
 * Fetches the number of page views from GoatCounter, and then displays it in all HTMLElements with
 * the id 'goatcounterstats'
 * 
 * @returns Promise resolving to void.
 */
async function goatcounterstats(): Promise<void> {
    let url = 'https://nilsbeerten.goatcounter.com/counter/' + encodeURI(location.pathname) + '.json';

    fetch(url)
        .then((response) => { return response.json() })
        .then((json) => {
            const elements: NodeListOf<HTMLElement> = document.querySelectorAll('#goatcounterstats') as NodeListOf<HTMLElement>;
            elements.forEach(element => element.textContent = json.count);
            return;
        })
        .catch(() => {
            const elements: NodeListOf<HTMLElement> = document.querySelectorAll('#goatcounterstats') as NodeListOf<HTMLElement>;
            elements.forEach(element => element.textContent = '0');
            return;
        });
}

/**
 * If the browser doesn't support the `:has()` pseudo-class, then add the `has_tool-tip` class to all
 * elements with the `tool-tip` child element, and add the `has_heroicons` class to all elements with
 * the `heroicons` child element
 * 
 * @returns Promise resolving to void.
 */
async function polyfill(): Promise<void> {
    if (!CSS.supports('selector(:has(*))')) {
        const elements = document.querySelectorAll('tool-tip') as NodeListOf<HTMLElement>;
            if(elements == null) return;
        elements.forEach(tooltip => {
            tooltip = tooltip.parentElement as HTMLElement;
            if(tooltip == null) return;
            
            tooltip.classList.add('has_tool-tip')
        })

        const tooltip_styles: HTMLStyleElement = document.createElement('style');
        tooltip_styles.textContent = `
          .has_tool-tip {
            position: relative;
          }
          .has_tool-tip:is(:hover, :focus-visible, :active) > tool-tip {
            opacity: 1;
            transition-delay: 200ms;
          }
        `;
        document.head.appendChild(tooltip_styles)

        document.querySelectorAll('.heroicons').forEach(heroicons => {
            heroicons = heroicons.parentElement as HTMLElement;
                if(heroicons == null) return;
            heroicons.classList.add('has_heroicons');
        })

        const heroicons_styles: HTMLStyleElement = document.createElement('style');
        heroicons_styles.textContent = `
          .has_heroicons {
            display: flex;
            flex-direction: row;
            gap: 0.5em;
          }
        `;

        document.head.appendChild(heroicons_styles);
    }
}

/**
 * Function to change a number of CSS variables to accurate values. Used in the hero sections for nice scroll-linked animations
 * to change blur and opacity. The `setinterval` of `1000 / 60` is the calculation for the interval between frames for a 
 * framerate of 60fps (1000 milliseconds per second, 60 frames per second => 1000ms / 60fps = 1000 / 60 ≈ 16.67 )
 */
addEventListener("DOMContentLoaded", () => {
    if(matchMedia("(pointer: coarse)").matches || matchMedia("(prefers-reduced-motion: reduce)").matches) return;
    const root = document.documentElement;
    const body = document.body;
    addEventListener("scroll", () => {
        var positionFactor = (root.scrollTop||body.scrollTop) / ( (root.scrollHeight||body.scrollHeight) - root.clientHeight );

        root.style.setProperty('--scrollposition-y-px', (root.scrollTop||body.scrollTop) + "px");
        root.style.setProperty('--scrollposition-y-p', `calc(${positionFactor} * 100%)`);
        root.style.setProperty('--scrollposition-y', positionFactor.toFixed(4));
    });
});