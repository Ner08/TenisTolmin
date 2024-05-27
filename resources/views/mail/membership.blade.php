<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Novi član - Teniški klub Tolmin</title>
    <style>
        body {
            font-family: Trebuchet, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #555;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .email-header h1 {
            margin: 0;
            color: #3b3b3b;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }
        .email-body p strong {
            color: #333;
        }
        .email-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 14px;
            color: #999;
        }

        /* Dark Mode Styles */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #292929;
                color: #e0e0e0;
            }
            .email-container {
                background-color: #1e1e1e;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            }
            .email-header h1 {
                color: #e0e0e0;
            }
            .email-body p {
                color: #e0e0e0;
            }
            .email-body p strong {
                color: #ffffff;
            }
            .email-footer {
                color: #aaaaaa;
                border-top: 1px solid #333;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Prošnja včlanitve - TK Tolmin</h1>
        </div>
        <div class="email-body">
            <p><strong>Ime:</strong> {{ $name ?? 'John doe' }}</p>
            <p><strong>Email:</strong> {{ $email  ?? 'example@email.ocm'}}</p>
            <p><strong>Telefonska številka:</strong> {{ $telephone ?? 'Ni bila podana' }}</p>
            <p><strong>Vrsta članarine:</strong> {{ $membershipType ?? 'Odrasel' }}</p>
        </div>
        <div class="email-footer">
            <p>Ta e-pošta je bila poslana samodejno s spletne strani Teniškega kluba Tolmin.</p>
        </div>
    </div>
</body>
</html>
