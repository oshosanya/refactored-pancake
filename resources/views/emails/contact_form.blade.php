<div class="container">
    <img src="{{ $message->embed(base_path('public/logo.jpg')) }}" />
    <p>You have received a mail from the contact form on www.primeracredit.com</p>
    <p>Content: </p>
    <table>
        <tr>
            <th>First Name: </th>
            <td>{{ $first_name }}</td>
        </tr>
        <tr>
            <th>Last Name: </th>
            <td>{{ $last_name }}</td>
        </tr>
        <tr>
            <th>Email: </th>
            <td>{{ $email_address }}</td>
        </tr>
        <tr>
            <th>Phone Number: </th>
            <td>{{ $phone_number }}</td>
        </tr>
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