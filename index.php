<?php
// Mechanizm bezpiecznej obsługi formularza kontaktowego w PHP
$message_sent = false;
$error_message = "";

if (isset($_POST['submit'])) {
    // --- PUŁAPKA NA BOTY (HONEYPOT) ---
    // Jeśli ukryte pole zostało wypełnione, przerywamy wysyłkę (to bot)
    if (!empty($_POST['website_url'])) {
        $message_sent = true; // Udajemy sukces przed botem
    } else {
        // --- WŁAŚCIWA WYSYŁKA DLA PRAWDZIWYCH UŻYTKOWNIKÓW ---
        $to = "michauasota@gmail.com";
        $subject = "Nowe zapytanie ze strony SobiVolt - " . htmlspecialchars($_POST['name']);
        
        // Filtrowanie i czyszczenie danych wejściowych
        $name = strip_tags(trim($_POST['name']));
        $phone = strip_tags(trim($_POST['phone']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $message = strip_tags(trim($_POST['message']));
        
        if (!empty($name) && !empty($phone) && !empty($email) && !empty($message)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Formatowanie treści wiadomości
                $body = "Masz nową wiadomość z formularza kontaktowego strony SobiVolt:\n\n".
                        "Imię / Firma: $name\n".
                        "Telefon: $phone\n".
                        "E-mail: $email\n\n".
                        "Treść wiadomości:\n$message\n\n".
                        "--- \nWiadomość wysłana automatycznie z serwera SobiVolt.";
                        
                // Nagłówki
                $headers = "From: no-reply@sobivolt.pl\r\n";
                $headers .= "Reply-To: $email\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                
                if(mail($to, $subject, $body, $headers)) {
                    $message_sent = true;
                } else {
                    $error_message = "Wystąpił problem z serwerem pocztowym. Spróbuj zadzwonić bezpośrednio.";
                }
            } else {
                $error_message = "Podany adres e-mail jest nieprawidłowy.";
            }
        } else {
            $error_message = "Proszę wypełnić wszystkie pola formularza.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SobiVolt - Kompleksowe Usługi Elektryczne i Instalacyjne</title>
	
	<meta name="description" content="Kompleksowe usługi elektryczne w województwie śląskim. Instalacje, awarie 24/7, pomiary, modernizacje i biały montaż. Szybki dojazd, uprawnienia SEP.">
	<meta name="keywords" content="elektryk śląsk, usługi elektryczne, instalacje elektryczne, pogotowie elektryczne, pomiary elektryczne, SobiVolt, wymiana rozdzielnicy">
	<meta name="author" content="SobiVolt">
	
	<link rel="icon" type="image/png" href="favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<style>
        /* Oficjalna paleta barw SobiVolt */
        :root {
            --bg-dark: #121212;
            --bg-card: #161616;
            --accent-yellow: #ffcc00;
            --text-white: #ffffff;
            --text-gray: #aaaaaa;
            --border-gray: #262626;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-white);
            overflow-x: hidden;
        }

        /* Pływający pasek szybkiego kontaktu (Inspiracja: Benden) */
        .sticky-contact {
            position: fixed;
            left: 0;
            top: 35%;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sticky-item {
            background-color: var(--accent-yellow);
            color: var(--bg-dark);
            padding: 12px 18px;
            margin-bottom: 3px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.3s ease, background-color 0.3s;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }

        .sticky-item:hover {
            transform: translateX(8px);
            background-color: #f1c40f;
        }

        /* Nawigacja / Header */
        header {
            background-color: rgba(18, 18, 18, 0.98);
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid var(--border-gray);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo-img {
            height: 55px; /* Dopasowanie wysokości logo w menu */
            width: auto;
            display: block;
        }
		
		.logo-text {
			color: var(--text-white);
			font-size: 32px;
			font-weight: 800;
			margin-left: 12px;
			letter-spacing: 0.5px;
		}

		.text-yellow {
			color: var(--accent-yellow);
		}
		
        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            color: var(--text-white);
            text-decoration: none;
            margin-left: 30px;
            font-weight: 600;
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--accent-yellow);
        }

        /* Sekcja Główna / Hero */
        .hero {
            padding: 160px 20px;
            text-align: center;
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.9)), url('https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
        }

        .hero h1 {
            font-size: 52px;
            font-weight: 800;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .hero h1 span {
            color: var(--accent-yellow);
        }

        .hero p {
            font-size: 22px;
            color: var(--text-gray);
            margin-bottom: 35px;
        }

        .btn-cta {
            background-color: var(--accent-yellow);
            color: var(--bg-dark);
            padding: 16px 40px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.3s, transform 0.2s;
            display: inline-block;
        }

        .btn-cta:hover {
            background-color: #e6b800;
            transform: translateY(-2px);
        }

        /* Główny pasek wyróżników z wizytówki */
        .features-bar {
            background-color: var(--accent-yellow);
            color: var(--bg-dark);
            padding: 22px 20px;
            text-align: center;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 3px;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        /* Kontenery sekcji */
        .section-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 90px 20px;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 55px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 70px;
            height: 4px;
            background-color: var(--accent-yellow);
            margin: 15px auto 0;
        }

        /* Sekcja: O firmie */
        .about-box {
            background-color: var(--bg-card);
            border: 1px solid var(--border-gray);
            padding: 45px;
            border-radius: 8px;
            text-align: center;
            max-width: 850px;
            margin: 0 auto;
        }

        .about-box p {
            font-size: 17px;
            line-height: 1.8;
            color: var(--text-gray);
            margin-bottom: 25px;
        }

        .sep-badge {
            display: inline-block;
            border: 2px solid var(--accent-yellow);
            color: var(--accent-yellow);
            padding: 12px 28px;
            font-weight: 800;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 15px;
        }

        /* Sekcja: Nasze Usługi (Siatka 8 kafelków z ikonami) */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .service-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-gray);
            padding: 35px 25px;
            border-radius: 6px;
            text-align: center;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-yellow);
        }

        .service-icon {
            font-size: 45px;
            color: var(--accent-yellow);
            margin-bottom: 22px;
            display: inline-block;
        }

        .service-card h3 {
            margin-bottom: 15px;
            font-size: 21px;
            font-weight: 700;
            color: var(--text-white);
        }

        .service-card p {
            color: var(--text-gray);
            font-size: 15px;
            line-height: 1.6;
        }

        /* --- GALERIA REALIZACJI --- */
        .gallery-section {
            padding: 80px 20px;
            background-color: #121212; /* Ciemne tło, by zdjęcia lepiej się odznaczały */
        }

        .gallery-section .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            color: var(--text-white);
            font-size: 36px;
            margin-bottom: 10px;
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-gray);
            margin-bottom: 50px;
            font-size: 16px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            aspect-ratio: 4 / 3; /* Zapewnia identyczne proporcje wszystkich kafelków */
            background-color: #1a1a1a;
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Elegancko przycina zdjęcia poziome i pionowe */
            transition: transform 0.5s ease;
        }

        .gallery-overlay {
            position: absolute;
            bottom: -100%;
            left: 0;
            width: 100%;
            padding: 25px 15px;
            background: linear-gradient(to top, rgba(0,0,0,0.95), transparent);
            color: var(--accent-yellow);
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: bottom 0.4s ease;
        }

        /* Efekty po najechaniu myszką */
        .gallery-item:hover img {
            transform: scale(1.08);
        }

        .gallery-item:hover .gallery-overlay {
            bottom: 0;
        }
        }

        /* Sekcja: Kontakt + Layout Formularza */
        .contact-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }

        .contact-info h3, .contact-form-container h3 {
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .contact-method {
            margin-bottom: 20px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .contact-method span {
            color: var(--accent-yellow);
            font-weight: 700;
        }

        /* Integracja Mapy Google */
        .map-container {
            width: 100%;
            height: 320px;
            border-radius: 6px;
            border: 1px solid var(--border-gray);
            overflow: hidden;
            margin-top: 35px;
        }

        /* Style pól formularza */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-gray);
            font-size: 14px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 14px;
            background-color: var(--bg-dark);
            border: 1px solid var(--border-gray);
            color: var(--text-white);
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-yellow);
            box-shadow: 0 0 8px rgba(255, 204, 0, 0.2);
        }

        textarea.form-control {
            resize: vertical;
        }

        .btn-submit {
            background-color: var(--accent-yellow);
            color: var(--bg-dark);
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            width: 100%;
        }
		.checkbox-group {
			display: flex;
			align-items: flex-start;
			gap: 12px;
			margin-bottom: 25px;
		}

		.checkbox-group input[type="checkbox"] {
			margin-top: 4px;
			width: 18px;
			height: 18px;
			accent-color: var(--accent-yellow);
			cursor: pointer;
		}

		.checkbox-group label {
			font-size: 13px !important;
			color: var(--text-gray) !important;
			line-height: 1.5;
			margin-bottom: 0 !important;
			font-weight: 400 !important;
		}

		.checkbox-group a {
			color: var(--accent-yellow);
			text-decoration: none;
		}

		.checkbox-group a:hover {
			text-decoration: underline;
		}
		
        .btn-submit:hover {
            background-color: #e6b800;
        }
        
        .btn-submit:active {
            transform: scale(0.99);
        }

        /* Komunikaty formularza */
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
        }

        .alert-success {
            background-color: #1e4620;
            color: #a3cfbb;
            border: 1px solid #1e4620;
        }

        .alert-danger {
            background-color: #4c1d1d;
            color: #f8d7da;
            border: 1px solid #4c1d1d;
        }

        /* Pasek informacyjny dolny (Z wizytówki: Szybki dojazd, Grupy docelowe) */
        .bottom-info-bar {
            background-color: #0d0d0d;
            border-top: 1px solid var(--border-gray);
            padding: 30px 20px;
        }

        .bottom-bar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .bottom-info-item {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bottom-info-item span {
            color: var(--accent-yellow);
            font-size: 20px;
        }

        /* --- NOWA STOPKA --- */
        .site-footer {
            background-color: #0d0d0d;
            color: #d1d1d1;
            padding: 60px 20px 20px;
            font-size: 15px;
            border-top: 1px solid var(--border-gray);
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-col h4 {
            color: var(--text-white);
            font-size: 18px;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--accent-yellow);
            display: inline-block;
            padding-bottom: 8px;
        }

        .footer-col p {
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .footer-col strong {
            color: var(--accent-yellow);
            font-size: 16px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Magiczne przyciski Social Media */
        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background-color: transparent;
            color: var(--accent-yellow);
            border: 2px solid var(--accent-yellow);
            border-radius: 50%;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background-color: var(--accent-yellow);
            color: #0d0d0d;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(255, 204, 0, 0.3);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #1a1a1a;
            font-size: 13px;
            color: #777;
        }

        /* Poprawka dla telefonów, żeby tekst był wyśrodkowany */
        @media (max-width: 768px) {
            .footer-col {
                text-align: center;
            }
            .footer-col h4 {
                margin-left: auto;
                margin-right: auto;
            }
            .social-links {
                justify-content: center;
            }
        }

        /* Responsywność strony (RWD) */
        @media (max-width: 992px) {
            .contact-layout { grid-template-columns: 1fr; gap: 40px; }
            .hero h1 { font-size: 40px; }
        }

        @media (max-width: 768px) {
            .nav-container { flex-direction: column; gap: 20px; padding: 20px; }
            nav a { margin: 0 10px; font-size: 14px; }
            .hero { padding: 100px 20px; }
            .hero h1 { font-size: 32px; }
            .hero p { font-size: 18px; }
            .features-bar { font-size: 16px; letter-spacing: 1.5px; }
			/* Pływający widget na mobile - same ikony */
			.sticky-contact { 
				display: flex; /* Przywraca widoczność całego widgetu */
			}
			
			.sticky-item span {
				display: none; /* Ukrywa tekst, zostawiając same ikony/emoji */
			}

			.sticky-item {
				padding: 12px 15px; /* Robi z przycisków zgrabne kafelki */
				font-size: 22px; /* Powiększa ikony, by łatwiej było w nie kliknąć palcem */
				border-top-right-radius: 8px; /* Zwiększa zaokrąglenie */
				border-bottom-right-radius: 8px;
			}
            .bottom-bar-container { flex-direction: column; gap: 15px; text-align: center; }
        }
		
		/* --- LIGHTBOX (POWIĘKSZANIE ZDJĘĆ) --- */
        .lightbox {
            display: none; /* Domyślnie ukryte */
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.92); /* Mocno przyciemnione tło */
            align-items: center;
            justify-content: center;
        }

        .lightbox-content {
            max-width: 90%;
            max-height: 90vh;
            border: 2px solid var(--accent-yellow); /* Żółta ramka SobiVolt */
            border-radius: 4px;
            box-shadow: 0 0 30px rgba(0,0,0,0.8);
            animation: zoomIn 0.3s ease; /* Płynne powiększenie */
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 40px;
            color: #fff;
            font-size: 50px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
            line-height: 1;
        }

        .lightbox-close:hover {
            color: var(--accent-yellow);
        }

        @keyframes zoomIn {
            from {transform: scale(0.8); opacity: 0;}
            to {transform: scale(1); opacity: 1;}
        }

        /* Poprawka dla mobilnych */
        @media (max-width: 768px) {
            .lightbox-close {
                top: 10px;
                right: 20px;
                font-size: 40px;
            }
        }
    </style>
</head>
<body>

    <!-- Pływający widget boczny (Benden) -->
	<div class="sticky-contact">
		<a href="tel:+48731892091" class="sticky-item">📞 <span>731 892 091</span></a>
		<a href="#kontakt" class="sticky-item">✉️ <span>Napisz wiadomość</span></a>
	</div>

    <header>
        <div class="nav-container">
            <a href="#" class="logo-link">
				<img src="SobiVoltLogo.png" alt="SobiVolt Logo" class="logo-img">
				<span class="logo-text">Sobi<span class="text-yellow">Volt</span></span>
			</a>
            <nav>
                <a href="#o-nas">O firmie</a>
                <a href="#uslugi">Usługi</a>
                <a href="#galeria">Galeria</a>
                <a href="#kontakt">Kontakt</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <h1>Kompleksowe <span>Usługi Elektryczne</span></h1>
        <p>Profesjonalne wykonawstwo dla domów, mieszkań i firm.</p>
        <a href="#kontakt" class="btn-cta">Darmowa Wycena</a>
    </section>

    <div class="features-bar">
        Solidnie • Terminowo • Fachowo
    </div>

    <section id="o-nas" class="section-container">
        <h2 class="section-title">O firmie</h2>
        <div class="about-box">
            <p>Twój zaufany partner w branży elektroinstalacyjnej

				W SobiVolt wiemy, że instalacja elektryczna to krwiobieg każdego budynku. Odpowiada za codzienny komfort, ale przede wszystkim – za bezpieczeństwo Twoich bliskich, pracowników i mienia. Dlatego naszą pracę opieramy na bezkompromisowej precyzji, aktualnych normach technicznych oraz bogatym doświadczeniu.

				Działamy na terenie całego województwa śląskiego i okolic, obsługując zarówno domy jednorodzinne, mieszkania, jak i obiekty firmowe. Niezależnie od tego, czy potrzebujesz zaprojektować instalację od zera, zmodernizować starą rozdzielnicę, czy pilnie usunąć nagłą awarię w środku nocy – jesteśmy do Twojej dyspozycji!

				Posiadamy aktualne Uprawnienia SEP, co stanowi gwarancję, że każda usługa i każdy wykonany przez nas pomiar są w 100% legalne, bezpieczne i poparte rzetelną wiedzą. Stawiamy na solidność, terminowość i czystość w miejscu pracy. Wybierając SobiVolt, wybierasz spokój na lata.</p>
            <div class="sep-badge">Uprawnienia SEP</div>
        </div>
    </section>

    <section id="uslugi" class="section-container">
        <h2 class="section-title">Nasze Usługi</h2>
        <div class="services-grid">
            
            <div class="service-card">
                <div class="service-icon">🏢</div>
                <h3>Instalacje od Podstaw</h3>
                <p>Projektujemy instalacje, które wytrzymają lata. Stosujemy nowoczesne rozwiązania, które planujemy z myślą o Twoim komforcie i przyszłym zużyciu energii.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">🛠️</div>
                <h3>Remonty i Modernizacje</h3>
                <p>Masz starą instalację? Nie ryzykuj. Wymienimy przewody i zabezpieczenia, aby spełniały obecne normy bezpieczeństwa i bez problemu obsługiwały nowoczesne sprzęty.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">⚡</div>
                <h3>Usuwanie Awarii 24/7</h3>
                <p>Prąd nie działa? Nie zostawiamy Cię w ciemności. Szybki dojazd do nagłych usterek w każdej sytuacji, aby przywrócić zasilanie w Twoim domu.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">🎛️</div>
                <h3>Wymiana Rozdzielnic</h3>
                <p>Rozdzielnica to serce Twojej instalacji. Dobierzemy i zamontujemy system, który jest bezpieczny, przejrzysty i chroni Twoją elektronikę przed przepięciami.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">💡</div>
                <h3>Montaż Oświetlenia</h3>
                <p>Wydobądź piękno wnętrza dzięki światłu. Montujemy lampy, taśmy LED i osprzęt z chirurgiczną precyzją.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">🍳</div>
                <h3>Płyty Indukcyjne</h3>
                <p>Profesjonalny montaż z zachowaniem wymogów gwarancyjnych. Podłączymy Twoją płytę szybko, bezpiecznie i wystawimy wymagany wpis do karty gwarancyjnej.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">🛡️</div>
                <h3>Monitoring i Alarm</h3>
                <p>Śpij spokojnie. Projektujemy i instalujemy okablowanie pod systemy zabezpieczeń, które faktycznie chronią Twój dobytek</p>
            </div>

            <div class="service-card">
                <div class="service-icon">📐</div>
                <h3>Pomiary Elektryczne</h3>
                <p>Nie daj się zaskoczyć ubezpieczycielowi. Wykonujemy rzetelne pomiary i wystawiamy kompletne protokoły niezbędne przy odbiorach i przeglądach.</p>
            </div>
			
			<div class="service-card">
                <div class="service-icon">❄️</div>
                <h3>Montaż Klimatyzacji</h3>
                <p>Kompleksowa instalacja układów Split i Multi-Split. Przeprowadzamy rygorystyczne próby szczelności, próżniowanie obwodu chłodniczego oraz doprowadzamy dedykowany obwód zasilania z osobnym zabezpieczeniem nadmiarowo-prądowym.</p>
            </div>
        </div>
    </section>

    <!-- Sekcja Galerii -->
    <section id="galeria" class="gallery-section">
        <div class="container">
            <h2 class="section-title">Nasze Realizacje</h2>
            <p class="section-subtitle">Zobacz przykłady naszych ostatnich prac instalacyjnych, pomiarowych i wykończeniowych.</p>

            <div class="gallery-grid">
                <!-- Kategoria 1: Rozdzielnice, Automatyka i Pomiary -->
                <div class="gallery-item">
                    <img src="rozdzielnia.jpeg" alt="Kompleksowa rozdzielnica elektryczna">
                    <div class="gallery-overlay"><span>Montaż i szycie rozdzielnicy</span></div>
                </div>
                <div class="gallery-item">
                    <img src="bezpieczniki.jpeg" alt="Nowoczesna rozdzielnica mieszkaniowa">
                    <div class="gallery-overlay"><span>Aparatura modułowa w praktyce</span></div>
                </div>
                <div class="gallery-item">
                    <img src="okablowanie_bezpiecznikow.jpeg" alt="Okablowanie bezpieczników">
                    <div class="gallery-overlay"><span>Precyzyjne układanie przewodów</span></div>
                </div>
                <div class="gallery-item">
                    <img src="pomiar.jpeg" alt="Pomiary elektryczne">
                    <div class="gallery-overlay"><span>Diagnostyka i pomiary sieci</span></div>
                </div>

                <!-- Kategoria 2: Oświetlenie, Biały Montaż i Smart Home -->
                <div class="gallery-item">
                    <img src="schody_lampy_wewn.jpeg" alt="Oświetlenie schodów">
                    <div class="gallery-overlay"><span>Efektowny żyrandol klatki schodowej</span></div>
                </div>
                <div class="gallery-item">
                    <img src="schody_lampy_zewn.jpeg" alt="Oświetlenie schodów z góry">
                    <div class="gallery-overlay"><span>Precyzyjny montaż na wysokościach</span></div>
                </div>
                <div class="gallery-item">
                    <img src="kuchnia_lampy.jpeg" alt="Oświetlenie w kuchni">
                    <div class="gallery-overlay"><span>Oświetlenie wyspy kuchennej</span></div>
                </div>
                <div class="gallery-item">
                    <img src="pokoj_lampy.jpeg" alt="Oświetlenie sufitowe LED">
                    <div class="gallery-overlay"><span>Oprawy wpuszczane LED</span></div>
                </div>
                <div class="gallery-item">
                    <img src="przelacznik.jpeg" alt="Przełącznik Somfy">
                    <div class="gallery-overlay"><span>Systemy Smart Home (Somfy)</span></div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontakt" class="section-container">
        <h2 class="section-title">Kontakt</h2>
        <div class="contact-layout">
            
            <div class="contact-info">
                <h3>Skontaktuj się</h3>
                <div class="contact-method">📞 Telefon: <span>731 892 091</span></div>
                <div class="contact-method">✉️ E-mail: <span>voltixsobina@gmail.com</span></div>
                <div class="contact-method">📍 Obszar: <span>Woj. śląskie i okolice</span></div>
                
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d653634.457813084!2d18.435427187123985!3d50.22295679589332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4711436ff4b58b43%3A0x28692cb1f2d66cf7!2stwojew%C3%B3dztwo%20%C5%9Bl%C4%85skie!5e0!3m2!1spl!2spl!4s2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <div class="contact-form-container">
                <h3>Napisz Wiadomość</h3>
                
                <?php if ($message_sent): ?>
                    <div class="alert alert-success">Wiadomość została wysłana! Odpowiemy tak szybko, jak to możliwe.</div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <form action="#kontakt" method="POST">
					<div style="display:none;" aria-hidden="true">
						<label for="website_url">Proszę zostawić to pole puste</label>
						<input type="text" id="website_url" name="website_url" tabindex="-1" autocomplete="off">
					</div>

					<div class="form-group">
						<label for="name">Imię, Nazwisko lub Nazwa firmy</label>
						<input type="text" id="name" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
					</div>
                    <div class="form-group">
                        <label for="phone">Numer telefonu</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adres e-mail</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Treść wiadomości (krótki opis prac)</label>
                        <textarea id="message" name="message" rows="5" class="form-control" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
					<div class="form-group checkbox-group">
						<input type="checkbox" id="rodo" name="rodo" required>
						<label for="rodo">Wyrażam zgodę na przetwarzanie moich danych osobowych podanych w formularzu w celu obsługi zapytania przez SobiVolt. <a href="#">Polityka prywatności</a>.</label>
					</div>
                    <button type="submit" name="submit" class="btn-submit">Wyślij zgłoszenie</button>
                </form>
            </div>

        </div>
    </section>

    

    <!-- Rozbudowana Stopka -->
    <footer class="site-footer">
        <div class="footer-container">
            
            <!-- Kolumna 1: Kontakt -->
            <div class="footer-col">
                <h4>Kontakt</h4>
                <p><strong>SobiVolt</strong></p>
                <p>Czyżowice, woj. śląskie</p>
                <p>Telefon: 0731 892 091</p>
                <p>E-Mail: voltixsobina@gmail.com</p>
            </div>

            <!-- Kolumna 2: Godziny otwarcia -->
            <div class="footer-col">
                <h4>Godziny otwarcia</h4>
                <p>Poniedziałek – Piątek:<br> 7:30 – 16:30</p>
                <p>Sobota – Niedziela:<br> Dyżur (Awarie 24/7)</p>
            </div>

            <!-- Kolumna 3: Social Media (Magiczne przyciski) -->
            <div class="footer-col">
                <h4>Znajdź nas</h4>
                <div class="social-links">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://youtube.com/@MiguUczyciel" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" title="X / Twitter"><i class="fab fa-x-twitter"></i></a>
                </div>
            </div>

        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 SobiVolt. Wszelkie prawa zastrzeżone.</p>
        </div>
    </footer>

    <div id="lightbox" class="lightbox">
        <span class="lightbox-close">&times;</span>
        <img class="lightbox-content" id="lightbox-img" alt="Powiększone zdjęcie">
    </div>
	
	<script>
        document.addEventListener("DOMContentLoaded", function() {
            const lightbox = document.getElementById("lightbox");
            const lightboxImg = document.getElementById("lightbox-img");
            const galleryItems = document.querySelectorAll(".gallery-item img");
            const closeBtn = document.querySelector(".lightbox-close");

            // Otwieranie zdjęcia po kliknięciu
            galleryItems.forEach(img => {
                img.parentElement.addEventListener("click", function() {
                    lightbox.style.display = "flex";
                    lightboxImg.src = img.src;
                });
            });

            // Zamykanie krzyżykiem
            closeBtn.addEventListener("click", function() {
                lightbox.style.display = "none";
            });

            // Zamykanie kliknięciem w ciemne tło (poza zdjęciem)
            lightbox.addEventListener("click", function(e) {
                if (e.target !== lightboxImg) {
                    lightbox.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>