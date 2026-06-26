<?php
// Mechanizm bezpiecznej obsługi formularza kontaktowego w PHP
$message_sent = false;
$error_message = "";

if (isset($_POST['submit'])) {
    if (!empty($_POST['website_url'])) {
        $message_sent = true; 
    } else {
        $to = "michauasota@gmail.com";
        $subject = "Nowe zapytanie ze strony SobiVolt - " . htmlspecialchars($_POST['name']);
        
        $name = strip_tags(trim($_POST['name']));
        $phone = strip_tags(trim($_POST['phone']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $message = strip_tags(trim($_POST['message']));
        
        if (!empty($name) && !empty($phone) && !empty($email) && !empty($message)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $body = "Masz nową wiadomość z formularza kontaktowego strony SobiVolt:\n\n".
                        "Imię / Firma: $name\n".
                        "Telefon: $phone\n".
                        "E-mail: $email\n\n".
                        "Treść wiadomości:\n$message\n\n".
                        "--- \nWiadomość wysłana automatycznie z serwera SobiVolt.";
                        
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
    
    <!-- Linkowanie nowego pliku z wyglądami -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

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
                <a href="#o-firmie">O firmie</a>
                <a href="#uslugi">Usługi</a>
                <a href="#galeria">Galeria</a>
                <a href="#kontakt">Kontact</a>
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

    <section id="o-firmie" class="section-container animate-on-scroll">
        <h2 class="section-title">O firmie</h2>
        <div class="about-box">
            <p>Twój zaufany partner w branży elektroinstalacyjnej<br><br>
            W SobiVolt wiemy, że instalacja elektryczna to krwiobieg każdego budynku. Odpowiada za codzienny komfort, ale przede wszystkim – za bezpieczeństwo Twoich bliskich, pracowników i mienia. Dlatego naszą pracę opieramy na bezkompromisowej precyzji, aktualnych normach technicznych oraz bogatym doświadczeniu.<br><br>
            Działamy na terenie całego województwa śląskiego i okolic, obsługując zarówno domy jednorodzinne, mieszkania, jak i obiekty firmowe. Niezależnie od tego, czy potrzebujesz zaprojektować instalację od zera, zmodernizować starą rozdzielnicę, czy pilnie usunąć nagłą awarię w środku nocy – jesteśmy do Twojej dyspozycji!<br><br>
            Posiadamy aktualne Uprawnienia SEP, co stanowi gwarancję, że każda usługa i każdy wykonany przez nas pomiar są w 100% legalne, bezpieczne i poparte rzetelną wiedzą. Stawiamy na solidność, terminowość i czystość w miejscu pracy. Wybierając SobiVolt, wybierasz spokój na lata.</p>
            <div class="sep-badge">Uprawnienia SEP</div>
        </div>
    </section>

    <section id="uslugi" class="section-container">
        <h2 class="section-title">Nasze Usługi</h2>
        <div class="services-grid">
            
            <div class="service-card animate-on-scroll">
                <div class="service-icon">🏢</div>
                <h3>Instalacje od Podstaw</h3>
                <p>Projektujemy instalacje, które wytrzymają lata. Stosujemy nowoczesne rozwiązania, które planujemy z myślą o Twoim komforcie i przyszłym zużyciu energii.</p>
            </div>

            <div class="service-card animate-on-scroll">
                <div class="service-icon">🛠️</div>
                <h3>Remonty i Modernizacje</h3>
                <p>Masz starą instalację? Nie ryzykuj. Wymienimy przewody i zabezpieczenia, aby spełniały obecne normy bezpieczeństwa i bez problemu obsługiwały nowoczesne sprzęty.</p>
            </div>

            <div class="service-card animate-on-scroll">
                <div class="service-icon">⚡</div>
                <h3>Usuwanie Awarii 24/7</h3>
                <p>Prąd nie działa? Nie zostawiamy Cię w ciemności. Szybki dojazd do nagłych usterek w każdej sytuacji, aby przywrócić zasilanie w Twoim domu.</p>
            </div>

            <div class="service-card animate-on-scroll">
                <div class="service-icon">🎛️</div>
                <h3>Wymiana Rozdzielnic</h3>
                <p>Rozdzielnica to serce Twojej instalacji. Dobierzemy i zamontujemy system, który jest bezpieczny, przejrzysty i chroni Twoją elektronikę przed przepięciami.</p>
            </div>

            <div class="service-card animate-on-scroll">
                <div class="service-icon">💡</div>
                <h3>Montaż Oświetlenia</h3>
                <p>Wydobądź piękno wnętrza dzięki światłu. Montujemy lampy, taśmy LED i osprzęt z chirurgiczną precyzją.</p>
            </div>

            <div class="service-card animate-on-scroll">
                <div class="service-icon">🍳</div>
                <h3>Płyty Indukcyjne</h3>
                <p>Profesjonalny montaż z zachowaniem wymogów gwarancyjnych. Podłączymy Twoją płytę szybko, bezpiecznie i wystawimy wymagany wpis do karty gwarancyjnej.</p>
            </div>

            <div class="service-card animate-on-scroll">
                <div class="service-icon">🛡️</div>
                <h3>Monitoring i Alarm</h3>
                <p>Śpij spokojnie. Projektujemy i instalujemy okablowanie pod systemy zabezpieczeń, które faktycznie chronią Twój dobytek</p>
            </div>

            <div class="service-card animate-on-scroll">
                <div class="service-icon">📐</div>
                <h3>Pomiary Elektryczne</h3>
                <p>Nie daj się zaskoczyć ubezpieczycielowi. Wykonujemy rzetelne pomiary i wystawiamy kompletne protokoły niezbędne przy odbiorach i przeglądach.</p>
            </div>
            
            <div class="service-card animate-on-scroll">
                <div class="service-icon">❄️</div>
                <h3>Montaż Klimatyzacji</h3>
                <p>Kompleksowa instalacja układów Split i Multi-Split. Przeprowadzamy rygorystyczne próby szczelności, próżniowanie obwodu chłodniczego oraz doprowadzamy dedykowany obwód zasilania z osobnym zabezpieczeniem nadmiarowo-prądowym.</p>
            </div>
        </div>
    </section>

    <section id="galeria" class="gallery-section">
        <div class="container">
            <h2 class="section-title">Nasze Realizacje</h2>
            <p class="section-subtitle">Zobacz przykłady naszych ostatnich prac instalacyjnych, pomiarowych i wykończeniowych.</p>

            <div class="gallery-grid">
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

    <footer class="site-footer">
        <div class="footer-container">
            
            <div class="footer-col animate-on-scroll">
                <h4>Kontakt</h4>
                <p><strong>SobiVolt</strong></p>
                <p>Turza Śląska, woj. Śląskie</p>
                <p>Telefon: +48 731 892 091</p>
                <p>E-Mail: voltixsobina@gmail.com</p>
            </div>

            <div class="footer-col animate-on-scroll">
                <h4>Godziny otwarcia</h4>
                <p>Poniedziałek – Piątek:<br> 7:30 – 16:30</p>
                <p>Sobota – Niedziela:<br> Dyżur (Awarie 24/7)</p>
            </div>

            <div class="footer-col animate-on-scroll">
                <h4>Znajdź nas</h4>
                <div class="social-links">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://youtube.com/@SobiVolt" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" title="X / Twitter"><i class="fab fa-x-twitter"></i></a>
                </div>
            </div>

        </div>
        
        <div class="footer-bottom">
            <p>© 2026 SobiVolt. Wszelkie prawa zastrzeżone.</p>
        </div>
    </footer>

    <div id="lightbox" class="lightbox">
        <span class="lightbox-close">×</span>
        <img class="lightbox-content" id="lightbox-img" alt="Powiększone zdjęcie">
        <div id="lightbox-caption" class="lightbox-caption"></div>
    </div>

    <!-- Linkowanie nowego pliku z animacjami i mechaniką -->
    <script src="script.js"></script>
</body>
</html>