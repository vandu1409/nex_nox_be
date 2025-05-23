<!DOCTYPE html>
<html>
<head>
    <title>Login Success</title>
</head>
<body>
<script>
    // Gửi token về parent window
    window.opener.postMessage({
        token: "{{ $token }}"
    }, "http://localhost:5173"); // FE origin

    // Đóng popup sau khi gửi
    window.close();
</script>
<p>Đăng nhập thành công! Đang chuyển hướng...</p>
</body>
</html>
