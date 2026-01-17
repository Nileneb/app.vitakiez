<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pflege-WG Rechtsfinder</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        @layer theme {

            :root,
            :host {
                --font-sans: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                --font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            }
        }

        /* Inline landing styles (based on restored styles.css) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation - oben sticky */
        nav {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 15px 0;
        }

        nav .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        nav .brand img.logo {
            height: 36px;
            width: auto;
            display: block;
        }

        nav .brand .brand-name {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1em;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 0 25px;
        }

        nav ul li a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 1em;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #764ba2;
        }

        /* Hero Header - clean ohne Overlay */
        header.hero-section {
            position: relative;
            color: white;
            padding: 0;
            text-align: center;
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 8px solid #667eea;
        }

        .hero-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        header.hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(102, 126, 234, 0.3);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 80px 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        header.hero-section h1 {
            font-size: 4em;
            margin-bottom: 20px;
            font-weight: 700;
            letter-spacing: -1px;
            text-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
            animation: fadeInDown 1s;
            line-height: 1.2;
        }

        header.hero-section p {
            font-size: 1.3em;
            margin-bottom: 35px;
            font-weight: 400;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 1s;
            line-height: 1.5;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 16px 40px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1em;
            transition: all 0.3s ease;
            animation: fadeIn 1.5s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
            background: #667eea;
            color: white;
        }

        /* Sections */
        section {
            padding: 80px 0;
        }

        section h2 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 50px;
            color: #667eea;
        }

        .vision {
            background: #f8f9fa;
        }

        .vision-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            font-size: 1.2em;
            line-height: 1.8;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-top: 50px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        /* Pricing */
        .pricing {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .pricing h2 {
            color: white;
        }

        .pricing-card {
            background: white;
            color: #333;
            padding: 50px;
            border-radius: 15px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .price {
            font-size: 3em;
            color: #667eea;
            font-weight: bold;
            margin: 20px 0;
        }

        .pricing-features {
            list-style: none;
            margin: 30px 0;
        }

        .pricing-features li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .pricing-features li:before {
            content: "✓ ";
            color: #667eea;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Team */
        .team-profile {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .team-profile h3 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 30px;
            border: 5px solid #667eea;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }

        .credentials {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .credentials ul {
            list-style: none;
        }

        .credentials li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
        }

        .credentials li:before {
            content: "🎓";
            position: absolute;
            left: 0;
        }

        /* Waitlist Form */
        .waitlist {
            background: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-tabs {
            display: flex;
            margin-bottom: 30px;
        }

        .tab-button {
            flex: 1;
            padding: 15px;
            background: white;
            border: 2px solid #667eea;
            cursor: pointer;
            font-size: 1.1em;
            transition: all 0.3s;
        }

        .tab-button.active {
            background: #667eea;
            color: white;
        }

        .tab-content {
            display: none;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #667eea;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .submit-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .submit-button:hover {
            transform: translateY(-2px);
        }

        /* Success Message */
        .success-message {
            display: none;
            background: #22c55e;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
        }

        /* Footer */
        footer {
            background: #111827;
            color: white;
            text-align: center;
            padding: 40px 0;
        }

        /* Statistics */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin: 50px 0;
        }

        .stat-box {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2.5em;
            color: #667eea;
            font-weight: bold;
        }

        .stat-label {
            color: #666;
            margin-top: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header.hero-section {
                min-height: 70vh;
            }

            header.hero-section h1 {
                font-size: 2.5em;
            }

            header.hero-section p {
                font-size: 1.1em;
            }

            .cta-button {
                padding: 14px 35px;
                font-size: 0.95em;
            }

            nav ul li {
                margin: 0 15px;
            }

            nav ul li a {
                font-size: 0.95em;
            }

            nav .container {
                flex-direction: column;
                gap: 10px;
            }

            nav ul {
                justify-content: center;
            }

            .form-tabs {
                flex-direction: column;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @vite(['/resources/css/app.css', '/resources/js/app.js'])
</head>

<body>
    <!-- Combined Navigation -->
    <nav>
        <div class="container">
            <div class="brand">
                <img src="{{ asset('images/logo.svg') }}" alt="VitaKiez" class="logo" />
            </div>
            <ul>
                <li><a href="#vision">Vision</a></li>
                <li><a href="#konzept">Konzept</a></li>
                <li><a href="#preise">Preise</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#waitlist">Warteliste</a></li>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/dashboard') }}"
                                style="border: 2px solid #667eea; padding: 8px 16px; border-radius: 5px;">Dashboard</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #667eea; cursor: pointer; text-decoration: underline; padding: 0; font: inherit;">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Log in</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}"
                                    style="border: 2px solid #667eea; padding: 8px 16px; border-radius: 5px;">Register</a></li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <!-- Hero Header -->
    <header class="hero-section">
        <img src="{{ asset('images/hero-header-optimized.jpg') }}" alt="VitaKiez - Gemütliches Wohnen im Alter"
            class="hero-image" loading="eager" />
        <div class="hero-content">
            <div class="container">
                <h1>VitaKiez</h1>
                <p>
                    Wohnen mit Herz und professioneller Betreuung in
                    Berlin-Neukölln
                </p>
                <a href="#waitlist" class="cta-button">Jetzt Platz sichern</a>
            </div>
        </div>
    </header>



    <!-- Vision Section -->
    <section id="vision" class="vision">
        <div class="container">
            <h2>Unsere Vision</h2>
            <div class="vision-content">
                <p>
                    Wir schaffen ein neues Konzept des Zusammenlebens für
                    aktive Senior:innen in Berlin. Statt klassischer
                    Altenheim-Atmosphäre bieten wir ein
                    <strong>familiäres Wohnumfeld</strong>
                    mit professioneller Gesundheitsförderung und
                    individueller Betreuung.
                </p>
                <p>
                    Unser Fokus liegt auf
                    <strong>Prävention und Lebensqualität</strong> – damit
                    Sie oder Ihre Angehörigen so lange wie möglich
                    selbstbestimmt und aktiv leben können.
                </p>
            </div>

            <div class="stats">
                <div class="stat-box">
                    <div class="stat-number">2-3</div>
                    <div class="stat-label">
                        Bewohner:innen<br />Familiärer Rahmen
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">1:3</div>
                    <div class="stat-label">
                        Betreuungsschlüssel<br />Intensive Zuwendung
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">
                        Qualifizierte Präsenz<br />Sicherheit & Geborgenheit
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">
                        Individuelle Betreuung<br />Keine Massenabfertigung
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Konzept Section -->
    <section id="konzept">
        <div class="container">
            <h2>Unser Alleinstellungsmerkmal</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👨‍👩‍👧</div>
                    <h3>Familiärer Rahmen</h3>
                    <p>
                        Maximal 2-3 Bewohner:innen in einer großzügigen
                        Wohngemeinschaft. Kein anonymes Heim, sondern ein
                        echtes Zuhause mit persönlicher Atmosphäre.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💪</div>
                    <h3>Gesundheitsförderung</h3>
                    <p>
                        Präventive Betreuung durch B.A. Pflege &
                        Gesundheitsförderung. Unser Ziel: Selbstständigkeit
                        erhalten und Pflegebedürftigkeit vorbeugen.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🌸</div>
                    <h3>Palliative Care</h3>
                    <p>
                        Spezialisierung in palliativer Versorgung gibt
                        Sicherheit für alle Lebensphasen. Würdevolles Leben
                        bis zuletzt.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👤</div>
                    <h3>Enger Betreuungsschlüssel</h3>
                    <p>
                        1 qualifizierte Betreuungskraft für max. 3 Personen
                        – im klassischen Heim oft 1:20 oder schlechter. Bei
                        uns steht der Mensch im Mittelpunkt.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🏡</div>
                    <h3>Leben in Berlin-Neukölln</h3>
                    <p>
                        Zentrale Lage mit perfekter Infrastruktur: Ärzte,
                        Geschäfte, Kultur und Parks in unmittelbarer Nähe.
                        Urbanes Leben statt Isolation.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🤝</div>
                    <h3>Professioneller Pflegedienst</h3>
                    <p>
                        Zusätzlich zum Mitbewohner arbeiten wir mit einem
                        ambulanten Pflegedienst zusammen – beste Versorgung
                        rund um die Uhr.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Zielgruppe Section -->
    <section style="background: #f8f9fa">
        <div class="container">
            <h2>Für wen ist VitaKiez?</h2>
            <div class="team-profile">
                <h3>Unsere Zielgruppe: Aktive Senior:innen</h3>
                <p style="margin-bottom: 20px; font-size: 1.1em">
                    Wir richten uns an
                    <strong>selbstständige, aktive Rentner:innen</strong>
                    (Pflegegrad 0-2), die Wert auf ein qualitätsvolles
                    Wohnumfeld mit professioneller Unterstützung legen.
                </p>

                <div class="credentials">
                    <h4>
                        Ideal für Sie, wenn:
                    </h4>
                    <ul>
                        <li>
                            Sie weitgehend selbstständig sind, aber
                            Sicherheit schätzen
                        </li>
                        <li>
                            Sie Einsamkeit vermeiden und Gemeinschaft suchen
                        </li>
                        <li>
                            Sie aktiv bleiben möchten mit professioneller
                            Förderung
                        </li>
                        <li>Sie zentral in Berlin wohnen möchten</li>
                        <li>
                            Sie individuelle Betreuung statt
                            Massenabfertigung wünschen
                        </li>
                        <li>
                            Ihre Familie Sicherheit und beste Versorgung für
                            Sie möchte
                        </li>
                    </ul>
                </div>

                <p style="font-style: italic; color: #666;">
                    <strong>Wichtig:</strong> Wir sind keine klassische
                    Pflegeeinrichtung, sondern eine Wohngemeinschaft mit
                    Fokus auf Gesundheitsförderung und Prävention. Unser
                    Ziel ist es, dass Sie so lange wie möglich
                    selbstbestimmt leben können.
                </p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="preise" class="pricing">
        <div class="container">
            <h2>Transparente Preisgestaltung</h2>
            <div class="pricing-card">
                <h3 style="text-align: center;">
                    Monatliche Kosten
                </h3>
                <div class="price">2.800 - 3.200€</div>
                <p style="color: #666; margin-bottom: 30px;">
                    Miete + Betreuungspauschale + Nebenkosten
                </p>

                <ul class="pricing-features">
                    <li>Eigenes möbliertes Zimmer</li>
                    <li>Nutzung aller Gemeinschaftsräume</li>
                    <li>24/7 qualifizierte Präsenzkraft vor Ort</li>
                    <li>Professioneller ambulanter Pflegedienst</li>
                    <li>Individuelle Gesundheitsförderung</li>
                    <li>Alle Nebenkosten (Strom, Wasser, Internet)</li>
                    <li>Gemeinschaftliche Aktivitäten</li>
                    <li>Zentrale Lage in Berlin-Neukölln</li>
                </ul>

                <p style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                    <strong>Pflegekassen-Leistungen:</strong> Je nach
                    Pflegegrad können Sie zusätzliche Leistungen der
                    Pflegekasse in Anspruch nehmen (z.B. Pflegegeld,
                    Verhinderungspflege, Wohngruppenzuschlag).
                </p>

                <p style="margin-top: 20px; text-align: center; font-size: 0.9em; color: #666;">
                    <strong>Für Familien/Investoren:</strong> Das flexible
                    Zimmer ist als Kurzzeitpflege oder Notfall-Option
                    buchbar (190€/Tag).
                </p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team">
        <div class="container">
            <h2>Ihr Gründer & Betreuer</h2>
            <div class="team-profile">
                <img src="{{ asset('images/Profilbild.jpg') }}" alt="Gründer" class="profile-image" />
                <h3>Bachelor of Arts - Pflege & Gesundheitsförderung</h3>
                <p style="font-size: 1.1em; margin-bottom: 20px">
                    Mit jahrelanger Erfahrung in der häuslichen Pflege und
                    Spezialisierung auf Palliative Care bringe ich die
                    perfekte Kombination aus Fachkompetenz und Herz mit.
                </p>

                <div class="credentials">
                    <h4 style="margin-bottom: 15px">
                        Qualifikationen & Erfahrung:
                    </h4>
                    <ul>
                        <li>B.A. Pflege und Gesundheitsförderung</li>
                        <li>Schwerpunkt Palliative Care</li>
                        <li>Jahrelange Erfahrung in häuslicher Pflege</li>
                        <li>
                            Kenntnisse in Gesundheitsförderung und
                            Prävention
                        </li>
                        <li>
                            Handwerkliche Fähigkeiten für Wohnraumgestaltung
                        </li>
                    </ul>
                </div>

                <div style="background: #f0f4ff; padding: 20px; border-radius: 10px; margin-top: 20px;">
                    <h4 style="color: #667eea; margin-bottom: 10px;">
                        Meine Motivation:
                    </h4>
                    <p style="font-style: italic">
                        "Ich habe in klassischen Pflegeeinrichtungen
                        gesehen, wie wenig Zeit für den einzelnen Menschen
                        bleibt. Mit VitaKiez möchte ich zeigen, dass es
                        anders geht: Individuelle Betreuung, Würde und
                        Lebensfreude bis ins hohe Alter."
                    </p>
                </div>

                <p style="margin-top: 20px; text-align: center">
                    <strong>Meine Rolle:</strong> Ich lebe als
                    qualifizierter Mitbewohner in der WG, sichere die
                    Qualität der Betreuung und unterstütze im Alltag – nach
                    Definition der Pflegekasse für Pflege-WGs.
                </p>
            </div>
        </div>
    </section>

    <!-- Waitlist Section -->
    <section id="waitlist" class="waitlist">
        <div class="container">
            <h2>Jetzt Platz sichern oder investieren</h2>
            <p style="text-align: center; max-width: 700px; margin: 0 auto 50px; font-size: 1.1em;">
                Tragen Sie sich jetzt unverbindlich in unsere Warteliste
                ein. Wir informieren Sie, sobald wir die passende Immobilie
                gefunden haben und starten können.
            </p>

            <div class="form-container">
                <div class="form-tabs">
                    <button class="tab-button active" data-tab="bewohner">
                        Für Bewohner:innen
                    </button>
                    <button class="tab-button" data-tab="investoren">
                        Für Investoren
                    </button>
                </div>

                <!-- Bewohner Form -->
                <div id="bewohner-form" class="tab-content active">
                    <form>
                        <div class="form-group">
                            <label for="b-name">Ihr Name *</label>
                            <input type="text" id="b-name" name="name" required />
                        </div>

                        <div class="form-group">
                            <label for="b-email">E-Mail-Adresse *</label>
                            <input type="email" id="b-email" name="email" required />
                        </div>

                        <div class="form-group">
                            <label for="b-phone">Telefon</label>
                            <input type="tel" id="b-phone" name="phone" />
                        </div>

                        <div class="form-group">
                            <label for="b-pflegegrad">Pflegegrad (falls vorhanden)</label>
                            <select id="b-pflegegrad" name="pflegegrad">
                                <option value="">Bitte wählen</option>
                                <option value="0">Kein Pflegegrad</option>
                                <option value="1">Pflegegrad 1</option>
                                <option value="2">Pflegegrad 2</option>
                                <option value="3">
                                    Pflegegrad 3 oder höher
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="b-einzug">Gewünschter Einzugstermin</label>
                            <input type="text" id="b-einzug" name="einzug"
                                placeholder="z.B. ab sofort, in 3 Monaten..." />
                        </div>

                        <div class="form-group">
                            <label for="b-nachricht">Nachricht / Besondere Wünsche</label>
                            <textarea id="b-nachricht" name="nachricht" rows="4"></textarea>
                        </div>

                        <button type="submit" class="submit-button">
                            Unverbindlich auf Warteliste eintragen
                        </button>

                        <div id="b-success" class="success-message">
                            ✓ Vielen Dank! Wir haben Ihre Anfrage erhalten
                            und melden uns zeitnah bei Ihnen.
                        </div>
                    </form>
                </div>

                <!-- Investoren Form -->
                <div id="investoren-form" class="tab-content">
                    <form>
                        <div class="form-group">
                            <label for="i-name">Ihr Name / Firma *</label>
                            <input type="text" id="i-name" name="name" required />
                        </div>

                        <div class="form-group">
                            <label for="i-email">E-Mail-Adresse *</label>
                            <input type="email" id="i-email" name="email" required />
                        </div>

                        <div class="form-group">
                            <label for="i-phone">Telefon</label>
                            <input type="tel" id="i-phone" name="phone" />
                        </div>

                        <div class="form-group">
                            <label for="i-interesse">Investitionsinteresse</label>
                            <select id="i-interesse" name="interesse">
                                <option value="">Bitte wählen</option>
                                <option value="eigenkapital">
                                    Eigenkapital-Beteiligung
                                </option>
                                <option value="darlehen">Darlehen</option>
                                <option value="crowdfunding">
                                    Crowdfunding-Beteiligung
                                </option>
                                <option value="zimmer">
                                    Flexibles Zimmer reservieren
                                </option>
                                <option value="offen">
                                    Offen für Gespräch
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="i-betrag">Möglicher Investitionsbetrag
                                (optional)</label>
                            <input type="text" id="i-betrag" name="betrag" placeholder="z.B. 50.000€" />
                        </div>

                        <div class="form-group">
                            <label for="i-nachricht">Nachricht / Ihre Motivation</label>
                            <textarea id="i-nachricht" name="nachricht" rows="4"></textarea>
                        </div>

                        <button type="submit" class="submit-button">
                            Investoren-Informationen anfordern
                        </button>

                        <div id="i-success" class="success-message">
                            ✓ Vielen Dank! Wir senden Ihnen die
                            Investoren-Unterlagen zeitnah zu.
                        </div>
                    </form>
                </div>
            </div>

            <p style="text-align: center; margin-top: 40px; color: #666; font-size: 0.9em;">
                * Ihre Daten werden vertraulich behandelt und nicht an
                Dritte weitergegeben.
            </p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section style="background: white">
        <div class="container">
            <h2>Häufig gestellte Fragen</h2>
            <div style="max-width: 800px; margin: 0 auto">
                <div class="feature-card" style="margin-bottom: 20px">
                    <h3 style="color: #667eea">
                        Wann startet das Projekt?
                    </h3>
                    <p>
                        Wir befinden uns aktuell in der Finanzierungs- und
                        Immobiliensuche-Phase. Sobald wir die passende
                        Wohnung gefunden haben, rechnen wir mit 3-6 Monaten
                        bis zum Start (Renovierung + Einrichtung).
                    </p>
                </div>

                <div class="feature-card" style="margin-bottom: 20px">
                    <h3 style="color: #667eea">
                        Wie sieht der Alltag aus?
                    </h3>
                    <p>
                        Sie leben selbstbestimmt in Ihrer eigenen WG mit
                        individueller Tagesgestaltung. Der Betreuer
                        unterstützt bei Bedarf, organisiert gemeinsame
                        Aktivitäten und sorgt für Gesundheitsförderung. Der
                        Pflegedienst kommt nach Bedarf.
                    </p>
                </div>

                <div class="feature-card" style="margin-bottom: 20px">
                    <h3 style="color: #667eea">
                        Was passiert bei höherem Pflegebedarf?
                    </h3>
                    <p>
                        Durch unsere Palliative Care Kompetenz können wir
                        auch bei steigendem Pflegebedarf begleiten. Der
                        ambulante Pflegedienst wird dann intensiviert. Unser
                        Ziel ist es, möglichst lange ein Verbleiben in der
                        vertrauten Umgebung zu ermöglichen.
                    </p>
                </div>

                <div class="feature-card" style="margin-bottom: 20px">
                    <h3 style="color: #667eea">
                        Für Investoren: Welche Rendite ist möglich?
                    </h3>
                    <p>
                        Wir kalkulieren mit 8% jährlicher Rendite plus
                        Immobilien-Wertsteigerung. Detaillierte
                        Businesspläne senden wir nach Ihrer
                        Interessensbekundung zu.
                    </p>
                </div>

                <div class="feature-card">
                    <h3 style="color: #667eea">
                        Kann ich die Wohnung vorher besichtigen?
                    </h3>
                    <p>
                        Sobald wir die Immobilie gefunden haben,
                        organisieren wir Besichtigungstermine für alle
                        Interessenten auf der Warteliste. Als Investor
                        bekommen Sie natürlich Vorrang.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
    <!-- Footer -->
    <footer>
        <div class="container">
            <h3 style="margin-bottom: 20px">VitaKiez</h3>
            <p>Wohnen mit Herz und professioneller Betreuung in Berlin</p>
            <p style="margin-top: 20px; font-size: 0.9em">
                Kontakt: info@vitakiez.de | Tel: 015566367968
            </p>
            <p style="margin-top: 20px; font-size: 0.8em; color: #999">
                © 2025 VitaKiez |
                <a href="{{ route('impressum') }}"
                    style="color: #999; text-decoration: underline">Impressum</a>
                |
                <a href="{{ route('datenschutz') }}"
                    style="color: #999; text-decoration: underline">Datenschutz</a>
            </p>
        </div>
    </footer>


</body>

</html>
