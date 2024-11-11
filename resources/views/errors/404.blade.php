<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Página no Encontrada</title>
</head>
<body>
    <section class="contenedor">
        <div class="conte2">
            <div class="conte3">
                <h2 class="error">
                    <span class="sronly">Error</span>404
                </h2>
                <p class="p1">Lo sentimos, no podemos encontrar esta página</p>
                <p class="p2">Pero no te preocupes, en nuestra página de inicio encontrarás muchas otras cosas.</p>
                <a href="{{ route('welcome') }}" class="link">Volver</a>
            </div>
        </div>
    </section>
</body>
</html>

<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }

    .contenedor {
        display: flex;
        align-items: center;
        height: 100%;
        padding: 60px;
    }

    .conte2 {
        width: 100%;
        display: flex;
        dlex-direction: column;
        align-items: center;
        justify-content: center;
        padding-left: 20px;
        padding-right: 20px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 10px;
        margin-bottom: 20px;

    }

    .conte3 {
        max-width: 448px;
        text-align: center;

    }

    .error {
        margin-bottom: 32px;
        font-weight: 800;
        font-size: 128px;
        line-height: 1;
        color: #4b5563
    }

    .sronly {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }

    .p1 {
        font-size: 24px;
        line-height: 32px;
        font-weight: 600;

        color: #4b5563;
    }

    .p2 {
        margin-top: 16px;
        margin-bottom: 32px;
        color: #9ca3af
        font-size: 16px;
        line-height: 24px;
        color: #4b5563;
    }

    .link {

        padding-left: 32px;
        padding-right: 32px;
        border-radius: 4px;
        background-color: #2563eb;
        color: #ffffff;
        line-height: 24px;
        font-weight: 600;
        text-decoration: none;
    }

    @media (min-width: 768px) {
        .p1 {
            font-size: 30px;
            line-height: 36px;
        }
    }
</style>
