<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperar Contraseña</title>
    <style>
        .container {
            padding: 2.5rem;
            font-size: 1.125rem;
            line-height: 1.75rem;
            background: #220042;
            color: #fff
        }
        .saludo {
            font-weight: 600;
            text-transform: capitalize; 

        }
        p {
            margin: 1.25rem 0;
        }
        a {
            background-color: #6e004c;
            border-radius: 0.375rem;
            text-decoration: none;
            color: #fff;
            padding: 15px;
            
        }
        a:hover {
            background-color: #54003a;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); 
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h2> Hola <span class="saludo">{{ $name}} {{ $last_name}}</span></h2>
        <p class="">has solicitado restablecer tu contraseña, visita el siguiente link para poder hacerlo.</p>
        <div>

            <a href="{{ env("FRONTEND_URL")."/auth/confirmar-contrasena/".$user->verification_id}}">Restablecer Contraseña</a>
        </div>
    </div>
    <div>
        <p>Si tu no lo solicitaste, ignora este mensaje.</p>
    </div>
</body>
</html>