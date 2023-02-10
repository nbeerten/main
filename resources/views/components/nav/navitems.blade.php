<x-nav.item route="home">
    Home
</x-nav.item>
@if(Request::routeIs('tmasigns'))
<x-nav.item route="tmasigns">
    TMA Signs
</x-nav.item>
@endif
<x-nav.item route="contact">
    Contact
</x-nav.item>