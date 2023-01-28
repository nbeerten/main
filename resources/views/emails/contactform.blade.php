<x-mail::message>
<x-mail::table>
| {{ now()->isoFormat('ddd DD-MM-YYYY, HH:mm') }} | []()          |
|:----------------------------------------------- | -------------:|
| Name                                            | {{ $name }}   |
| Email                                           | {{ $email }}  |
</x-mail::table>

---

# {{ $subject }}

{{ $message }}
 
</x-mail::message>