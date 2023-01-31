addEventListener('DOMContentLoaded', () => polyfill());

/**
 * If the browser doesn't support the `:has()` pseudo-class, then add the `has_tool-tip` class to all
 * elements with the `tool-tip` child element, and add the `has_heroicons` class to all elements with
 * the `heroicons` child element
 * 
 * @returns Promise resolving to void.
 */
async function polyfill(): Promise<void> {
    if (!CSS.supports('selector(:has(*))')) {

        document.querySelectorAll('tool-tip').forEach(tooltip => {
            tooltip = tooltip.parentElement as HTMLElement;
                if(tooltip == null) return;
            tooltip.classList.add('has_tool-tip')
        });

        document.querySelectorAll('.heroicons').forEach(heroicons => {
            heroicons = heroicons.parentElement as HTMLElement;
                if(heroicons == null) return;
            heroicons.classList.add('has_heroicons');
        });

        const StyleSheet = new CSSStyleSheet();

        StyleSheet.insertRule(`
            .has_tool-tip {
                position: relative;
            }
        `, 0);
        StyleSheet.insertRule(`
            .has_tool-tip:is(:hover, :focus-visible, :active) > tool-tip {
                opacity: 1;
                transition-delay: 200ms;
            }
        `, 0);
        StyleSheet.insertRule(`
            .has_heroicons {
                display: flex;
                flex-direction: row;
                gap: 0.5em;
            }
        `, 0);

        document.adoptedStyleSheets = [StyleSheet];
    }
}