<div class="container">
    <img src="{{ $message->embed(base_path('public/logo.jpg')) }}" />
    <p>Dear {{ $first_name }}, thank you for your mail, one of our agents will get across to you shortly. Below is the content of your mail</p>
    <p>Content: </p>
    <table>
        <tr>
            <th>Message: </th>
            <td>{{ $mail_message }}</td>
        </tr>
    </table>
</div>

<style>
    table {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    tr, td {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        padding: 8px 20px;
    }

    table td {
        font-size: 15px;
        width: 500px;
    }

    .container {
        width: 700px;
    }
</style>