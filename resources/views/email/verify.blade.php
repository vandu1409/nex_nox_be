<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            padding: 24px;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            border: 1px solid #ddd;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Xin chào!</h2>
    <p>Vui lòng nhấn nút bên dưới để xác thực tài khoản của bạn.</p>

    <a href="{{ $url }}" class="button">Xác thực ngay</a>

    <p>Nếu bạn không yêu cầu, vui lòng bỏ qua email này.</p>
</div>
</body>
</html>
