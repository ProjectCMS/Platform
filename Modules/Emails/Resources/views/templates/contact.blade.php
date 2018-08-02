<!DOCTYPE html>
<html>
<head>
    <title>E-mail de contato do site</title>
</head>

<body>
<p><b>Nome:</b> {{ $data->name }}</p>
<p><b>E-mail:</b> {{ $data->email }}</p>
<p><b>Mensagem:</b> <br> {{ $data->message }}</p>
</body>

</html>