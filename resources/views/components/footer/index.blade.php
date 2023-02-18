<footer>
    {{-- <div class="footer-links">
        <x-footer.link-row title="Pages">
            <x-footer.link-item href="/">Homepage</x-footer.link-item>
            <x-footer.link-item href="/contact">Contact</x-footer.link-item>
        </x-footer.link-row>
        <x-footer.link-row title="Miscellaneous">
            <x-footer.link-item href="https://trackmania.exchange/ms?authorid=41263"><x-heroicon-m-arrow-top-right-on-square /> Trackmania Maps</x-footer.link-item>
        </x-footer.link-row>
        <x-footer.link-row title="Info">
            <p><x-md>
                **Fonts:** [Mona Sans & Hubot Sans](https://github.com/mona-sans), [Jetbrains Mono](https://www.jetbrains.com/lp/mono/). <br>
                **Icons:** [heroicons](https://heroicons.com/), [tabler](https://tabler-icons.io/).
            </x-md></p>
        </x-footer.link-row>
        <x-footer.link-row title="Statistics">
            <p class="visitor-count">
                <span>Visitors of this page:</span>
                <span><x-heroicon-s-eye style="font-size: 1.25rem;" /> </span>
            </p>
        </x-footer.link-row>
    </div> --}}
    <div class="footer-bottom">
        <div class="footer-copyright">
            <p><span class="year">{{ now()->format('Y') }}</span> <span class="name">Nils Beerten</span></p>
        </div>
        <div class="footer-socials">
            <a rel="me" href="https://mastodon.social/@nbeerten" target="_blank" aria-label="mastodon: @nbeerten@mastodon.social">
                <tool-tip role="tooltip" tip-position="block-start">@nbeerten@mastodon.social</tool-tip>
                <x-tabler-brand-mastodon />
            </a>
            <a rel="me" href="https://trackmania.social/@nbert" target="_blank" aria-label="mastodon: @nbert@trackmania.social">
                <tool-tip role="tooltip" tip-position="block-start">@nbert@trackmania.social</tool-tip>
                <x-tabler-brand-mastodon />
            </a>
            <a href="https://twitter.com/nbertn" target="_blank" aria-label="twitter: @nbertn">
                <tool-tip role="tooltip" tip-position="block-start">@nbertn</tool-tip>
                <x-tabler-brand-twitter />
            </a>
            <a href="https://youtube.com/channel/UC-bj0JxjTzxnL2LSQMEx6MA" target="_blank" aria-label="youtube: nbert">
                <tool-tip role="tooltip" tip-position="block-start">nbert</tool-tip>
                <x-tabler-brand-youtube />
            </a>
            <a href="https://github.com/nbeerten" target="_blank" aria-label="github: nbeerten">
                <tool-tip role="tooltip" tip-position="block-start">nbeerten</tool-tip>
                <x-tabler-brand-github />
            </a>
            <a href="https://discord.com/invite/TdRSgYjJ7S" target="_blank" aria-label="discord: nbert#2620">
                <tool-tip role="tooltip" tip-position="inline-start">nbert#2620</tool-tip>
                <x-tabler-brand-discord />
            </a>
        </div>
    </div>
</footer>