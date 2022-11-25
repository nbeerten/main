<div style="background-color: #171717; width: 100%; height: 100%; padding: 16px; color: white;">
    <table style="background-color: #171717; width: 100%;">
        <thead>
            <tr>
                <td style="background-color: #000; font-size: 16px;">Name</td>
                <td style="background-color: #000; font-size: 16px;">Email</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding-right: 16px; font-size: 16px;">{{ $name }}</td>
                <td style="font-size: 16px;">{{ $email }}</td>
            </tr>
        </tbody>
    </table>
    <h1 style="margin-bottom: 0; margin-top: 16px;">{{ $subject }}</h1>
    <p style="margin-top: 8px; color: #d1d5db;">{!! $message !!}</p>
  </div>