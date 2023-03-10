import Alpine, { Alpine as IAlpine, AlpineComponent as TAlpineComponent } from 'alpinejs';
// @ts-ignore
import collapse from '@alpinejs/collapse';
// @ts-ignore
import persist from '@alpinejs/persist';

import { TMASignsData } from './pages/TMASigns';

declare global {
    interface Window {
        Alpine: IAlpine;
    }
}

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(persist);

Alpine.data('TMASignsData', function(this: TAlpineComponent<TMASignsData>) {
    return {
        text: this.$persist('').using(sessionStorage),
        subtext: this.$persist('').using(sessionStorage),
        size: this.$persist(2).using(sessionStorage),
        subtextlocation: this.$persist('bottom').using(sessionStorage),
        offsetText: this.$persist(0).using(sessionStorage),
        offsetSubtext: this.$persist(0).using(sessionStorage),
        outlineModifier: this.$persist(0).using(sessionStorage)
    } satisfies TMASignsData;
});

Alpine.start();