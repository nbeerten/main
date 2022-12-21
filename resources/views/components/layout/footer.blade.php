<footer>
    <div class="links">
        <div>
            <h4>Pages</h4>
            <ul class="no-standard">
                <li><a href="/">Homepage</a></li>
                <li><a href="/posts">Posts</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
        <div>
            <h4>Miscellaneous</h4>
            <ul class="no-standard">
                <li><a href="https://status.nilsbeerten.nl/">Status Page</a></li>
                <li><a href="https://trackmania.exchange/ms?authorid=41263"><x-heroicon-m-arrow-top-right-on-square /> Trackmania Maps</a></li>
            </ul>
        </div>
        <div>
            <h4>Info</h4>
            <p><x-md>
                **Fonts:** [Mona Sans & Hubot Sans](https://github.com/mona-sans), [Jetbrains Mono](https://www.jetbrains.com/lp/mono/). <br>
                **Icons:** [heroicons](https://heroicons.com/), [simpleicons](https://simpleicons.org/).
            </x-md></p>
        </div>
        <div>
            <h4>Statistics</h4>
            <p class="visitor-count">
                <span>Visitors of this page:</span>
                <span><x-heroicon-s-eye style="font-size: 1.25rem;" /> <span id="goatcounterstats"></span></span>
            </p>
        </div>
    </div>
    <div class="bottom">
        <div class="copyright">
            <p x-data="{ year: new Date().getFullYear() }"><span class="year"><span x-text="year">2022</span></span> <span class="name">Nils Beerten</span></p>
        </div>
        <div class="socials">
            <a rel="me" href="https://mastodon.social/@nbeerten" target="_blank" aria-label="mastodon: @nbeerten@mastodon.social">
                <tool-tip role="tooltip" tip-position="block-start">@nbeerten@mastodon.social</tool-tip>
                <x-simpleicon-mastodon />
            </a>
            <a rel="me" href="https://trackmania.social/@nbert" target="_blank" aria-label="mastodon: @nbert@trackmania.social">
                <tool-tip role="tooltip" tip-position="block-start">@nbert@trackmania.social</tool-tip>
                <x-simpleicon-mastodon />
            </a>
            <a href="https://twitter.com/nbertn" target="_blank" aria-label="twitter: @nbertn">
                <tool-tip role="tooltip" tip-position="block-start">@nbertn</tool-tip>
                <x-simpleicon-twitter />
            </a>
            <a href="https://youtube.com/channel/UC-bj0JxjTzxnL2LSQMEx6MA" target="_blank" aria-label="youtube: nbert">
                <tool-tip role="tooltip" tip-position="block-start">nbert</tool-tip>
                <x-simpleicon-youtube />
            </a>
            <a href="https://github.com/nbeerten" target="_blank" aria-label="github: nbeerten">
                <tool-tip role="tooltip" tip-position="block-start">nbeerten</tool-tip>
                <x-simpleicon-github />
            </a>
            <a href="https://discord.com/invite/TdRSgYjJ7S" target="_blank" aria-label="discord: nbert#2620">
                <tool-tip role="tooltip" tip-position="inline-start">nbert#2620</tool-tip>
                <x-simpleicon-discord />
            </a>
        </div>
    </div>
</footer>