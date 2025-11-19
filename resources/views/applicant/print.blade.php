<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Application Print</title>

    <style>
        body {
            font-family: "Noto Sans Bengali", sans-serif;
            padding: 20px;
        }
        .container {
            width: 700px;
            margin: auto;
            border: 1px solid #111;
            padding: 20px;
        }
        h2 { text-align: center; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table td {
            padding: 8px;
            border: 1px solid #333;
        }
    </style>
</head>
<body onload="window.print()">

<div class="container">
    <h2>আবেদনকারীর তথ্য</h2>
    <table>
        <tr>
            <td>আবেদনকারীর নাম</td>
            <td>{{ $applicant->applicant_name }}</td>
        </tr>
        <tr>
            <td>NID নম্বর</td>
            <td>{{ $applicant->nid_no }}</td>
        </tr>
        <tr>
            <td>মোবাইল</td>
            <td>{{ $applicant->phone }}</td>
        </tr>
        <tr>
            <td>বর্তমান ঠিকানা</td>
            <td>{{ $applicant->present_address }}</td>
        </tr>
        <tr>
            <td>স্থায়ী ঠিকানা</td>
            <td>{{ $applicant->permanent_address }}</td>
        </tr>
        <tr>
            <td>এরিয়া (রুট)</td>
            <td>{{ optional($applicant->area)->area_name }}</td>
        </tr>
        <tr>
            <td>ক্যাটাগরি</td>
            <td>{{ optional($applicant->category)->category_name }}</td>
        </tr>
        <tr>
            <td>আবেদনের তারিখ</td>
            <td>{{ $applicant->applicaton_date }}</td>
        </tr>
    </table>
</div>

</body>
</html>
