<?php

namespace App\Classes\SEO;

enum Robots: string
{
    /**
     * 	There are no restrictions for indexing or serving. This rule is the default value and has no effect if explicitly listed.
     */
    case ALL = 'all';

    /**
     * Do not show this page, media, or resource in search results.
     */
    case NOINDEX = 'noindex';

    /**
     * 	Do not follow the links on this page.
     */
    case NOFOLLOW = 'nofollow';

    /**
     * 	Equivalent to noindex, nofollow.
     */
    case NONE = 'none';

    /**
     * Do not show a cached link in search results.
     */
    case NOARCHIVE = 'noarchive';

    /**
     * Do not show a sitelinks search box in the search results for this page.
     */
    case NOSITELINKSSEARCHBOX = 'nositelinkssearchbox';

    /**
     * 	Do not show a text snippet or video preview in the search results for this page. A static image thumbnail (if available) may still be visible, when it results in a better user experience.
     */
    case NOSNIPPET = 'nosnippet';

    /**
     * Do not show a cached link in search results. If you don't specify this rule, Google may generate a cached page and users may access it through the search results.
     */
    case INDEXIFEMBEDDED = 'indexifembedded';

    /**
     * Don't offer translation of this page in search results.
     */
    case NOTRANSLATE = 'notranslate';

    /**
     * Do not index images on this page.
     */
    case NOIMAGEINDEX = 'noimageindex';
}
