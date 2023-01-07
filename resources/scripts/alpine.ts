import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import persist from '@alpinejs/persist';
import intersect from '@alpinejs/intersect'

window.Alpine = Alpine

Alpine.plugin(collapse);
Alpine.plugin(persist);
Alpine.plugin(intersect);

Alpine.start();