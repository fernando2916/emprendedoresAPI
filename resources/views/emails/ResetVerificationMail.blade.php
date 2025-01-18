<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperación de código de verificación</title>

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
        .codigo {
            font-weight: 600;
            font-size: 1.25rem;
            line-height: 1.75rem;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1 class="">Nuevo Código de verificación</h1>
    
        <p>
          Hola {{ $name }} {{ $last_name }}, aqui tienes un nuevo código de verificación
        </p>
        <p>Visita el siguiente enlace:</p>
        <a class="" href="{{ env('FRONTEND_URL') . '/auth/activar-cuenta/' . $user->verification_id }}">
          Confirmar cuenta
        </a>
        <p>
          E ingresa el siguiente código de verificaión
          <span class="codigo">
            {{ $verification_code }}
          </span>
          Este código expira en 15 minutos.
        </p>
      </div>
</body>
</html>