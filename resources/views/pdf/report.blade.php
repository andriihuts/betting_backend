<!DOCTYPE html>
<html>
<head>
    <title>Logbook Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Logbook Report</h2>
    <p>From: {{ $from }} - To: {{ $to }}</p>

    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>MRN</th>
                <th>Date of Birth</th>
                <th>Procedure Date</th>
                <th>Procedure Type</th>
                <th>Hospital</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logbooks as $logbook)
            <tr>
                <td>{{ $logbook->patient_name }}</td>
                <td>{{ $logbook->mrn }}</td>
                <td>{{ $logbook->dob }}</td>
                <td>{{ $logbook->procedure_date }}</td>
                <td>{{ $logbook->procedure_type->procedure_type ?? 'N/A' }}</td>
                <td>{{ $logbook->hospital->hospital_name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
