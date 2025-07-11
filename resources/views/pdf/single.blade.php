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
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="text-align: center; margin-bottom: 20px;">Patient Procedure Report</h2>

        <div style="margin-bottom: 12px;">
            <strong>Patient Name:</strong>
            <span>{{ $logbook->patient_name }}</span>
        </div>

        <div style="margin-bottom: 12px;">
            <strong>MRN:</strong>
            <span>{{ $logbook->mrn ?? 'N/A' }}</span>
        </div>

        <div style="margin-bottom: 12px;">
            <strong>Date of Birth:</strong>
            <span>{{ $logbook->dob ?? 'N/A' }}</span>
        </div>

        <div style="margin-bottom: 12px;">
            <strong>Procedure Date:</strong>
            <span>{{ $logbook->procedure_date }}</span>
        </div>

        <div style="margin-bottom: 12px;">
            <strong>Procedure Type:</strong>
            <span>{{ $logbook->procedure_type->procedure_type ?? 'N/A' }}</span>
        </div>

        <div style="margin-bottom: 12px;">
            <strong>Hospital:</strong>
            <span>{{ $logbook->hospital->hospital_name ?? 'N/A' }}</span>
        </div>

        <div style="margin-bottom: 12px;">
            <strong>Notes:</strong>
            <span>{{ $logbook->notes ?? 'N/A' }}</span>
        </div>

        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 16px; margin-top: 40px; align-items: center; width: 100%;">
            @foreach ($logbook->images as $image)
                @php
                    $imagePath = public_path('storage/' . $image->image_url);
                @endphp

                @if (file_exists($imagePath))
                    <div style="padding: 6px; margin-bottom: 10px; margin: auto; align-self: center; width: 100%;">
                        <img 
                            src="{{ $imagePath }}" 
                            alt="Image"
                            style="width: 150px; height: auto; display: block; width: 100%; max-width: 600px;"
                        />
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</body>
</html>
