import Alpine, { Alpine as IAlpine } from 'alpinejs';
// @ts-ignore
import collapse from '@alpinejs/collapse';
// @ts-ignore
import persist from '@alpinejs/persist';
// @ts-ignore
import intersect from '@alpinejs/intersect';

declare global {
    interface Window {
        Alpine: IAlpine;
    }
}

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(persist);
Alpine.plugin(intersect);

Alpine.start();