<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TECNOGAR | Tienda de Electrodomésticos</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS for Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom Styles -->
    <style>
        .bg-hero {
            background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
                        url('https://cloudfront-us-east-1.images.arcpublishing.com/elcomercio/FQWM7OLBTJAD5KTGLIFY6K3XJI.jpg') no-repeat center center/cover;
            height: 100vh;
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 720px;
        }

        .title-gradient {
            background: linear-gradient(to right, #f97316, #3b82f6, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 1.25rem;
            color: #e5e7eb;
        }

        .button-primary {
            background-color: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .button-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="font-poppins bg-gray-900 text-white">
    <!-- Hero Section -->
    <section class="bg-hero flex items-center justify-center">
        <div class="glass text-center" data-aos="zoom-in">
            <h1 class="title-gradient mb-6">TECNOGAR</h1>
            <p class="subtitle mb-8">
                En TECNOGAR te ofrecemos una experiencia moderna y confiable en la compra de electrodomésticos. Contamos con una gran variedad de productos de calidad para el hogar y la oficina: cocinas, refrigeradoras, televisores, lavadoras, microondas, licuadoras, ventiladores y mucho más.
            </p>
            <a href="{{ route('login') }}" class="button-primary inline-block">Ingresar al Sistema</a>
        </div>
    </section>

    <!-- Initialize AOS -->
    <script>
        AOS.init();
    </script>
</body>
</html>
