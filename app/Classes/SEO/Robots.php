<?php

namespace App\Classes\SEO;

readonly class Robots
{
    /**
     * 	There are no restrictions for indexing or serving. This rule is the default value and has no effect if explicitly listed.
     */
    public const ALL = 'all';

    /**
     * Do not show this page, media, or resource in search results.
     */
    public const NOINDEX = 'noindex';

    /**
     * 	Do not follow the links on this page.
     */
    public const NOFOLLOW = 'nofollow';

    /**
     * 	Equivalent to noindex, nofollow.
     */
    public const NONE = 'none';

    /**
     * Do not show a cached link in search results.
     */
    public const NOARCHIVE = 'noarchive';

    /**
     * Do not show a sitelinks search box in the search results for this page.
     */
    public const NOSITELINKSSEARCHBOX = 'nositelinkssearchbox';

    /**
     * 	Do not show a text snippet or video preview in the search results for this page. A static image thumbnail (if available) may still be visible, when it results in a better user experience.
     */
    public const NOSNIPPET = 'nosnippet';

    /**
     * Do not show a cached link in search results. If you don't specify this rule, Google may generate a cached page and users may access it through the search results.
     */
    public const INDEXIFEMBEDDED = 'indexifembedded';

    /**
     * Don't offer translation of this page in search results.
     */
    public const NOTRANSLATE = 'notranslate';

    /**
     * Do not index images on this page.
     */
    public const NOIMAGEINDEX = 'noimageindex';
}
