<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team - Library Book Tracking System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Section */
        .header {
            text-align: center;
            padding: 80px 0 60px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease-out 0.3s forwards;
        }

        .header h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.2rem;
            color: #64748b;
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Team Grid */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            padding-bottom: 40px;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.6s forwards;
        }

        .team-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(50px);
        }

        .team-card:nth-child(1) { animation: slideUpCard 0.8s ease-out 0.9s forwards; }
        .team-card:nth-child(2) { animation: slideUpCard 0.8s ease-out 1.0s forwards; }
        .team-card:nth-child(3) { animation: slideUpCard 0.8s ease-out 1.1s forwards; }
        .team-card:nth-child(4) { animation: slideUpCard 0.8s ease-out 1.2s forwards; }
        .team-card:nth-child(5) { animation: slideUpCard 0.8s ease-out 1.3s forwards; }
        .team-card:nth-child(6) { animation: slideUpCard 0.8s ease-out 1.4s forwards; }
        .team-card:nth-child(7) { animation: slideUpCard 0.8s ease-out 1.5s forwards; }

        .team-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .team-card:hover::before {
            transform: scaleX(1);
        }

        .team-card:hover {
            transform: translateY(-20px) scale(1.02);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 24px;
            object-fit: cover;
            border: 4px solid #f8fafc;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        .team-card:hover .profile-image {
            transform: scale(1.1);
            border-color: #667eea;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
        }

        .member-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .member-role {
            font-size: 1rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 20px;
        }

        .social-link {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .social-link:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

       /* SIMPLIFIED CONTACT SECTION STYLES */
.contact-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 60px 40px;
    text-align: center;
    margin: 60px auto;
    max-width: 600px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    opacity: 0;
    transform: translateY(50px);
    animation: slideUpCard 0.8s ease-out 1.7s forwards;
}

.contact-icon {
    font-size: 4rem;
    color: #667eea;
    margin-bottom: 24px;
    display: block;
}

.contact-section h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.contact-section p {
    font-size: 1.2rem;
    color: #64748b;
    margin-bottom: 40px;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 24px;
    max-width: 400px;
    margin: 0 auto;
}

.contact-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 20px 30px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 16px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.contact-item:hover {
    background: rgba(102, 126, 234, 0.2);
    border-color: #667eea;
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
}

.contact-item i {
    font-size: 1.5rem;
    color: #667eea;
    width: 32px;
}

.contact-item a {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-item a:hover {
    color: #667eea;
}

/* Responsive */
@media (max-width: 768px) {
    .contact-section {
        margin: 40px 20px;
        padding: 40px 24px;
    }
    
    .contact-item {
        padding: 16px 24px;
    }
    
    .contact-item a {
        font-size: 1.1rem;
    }
}

        /* Animations */
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUpCard {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 60px 0 40px;
            }

            .header h1 {
                font-size: 2.5rem;
            }

            .team-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .team-card {
                padding: 30px 24px;
            }
        .profile-image {
                width: 100px;
                height: 100px;
            }

            .contact-section {
                margin: 40px 20px;
                padding: 40px 24px;
            }

            .contact-section h2 {
                font-size: 2rem;
            }

            .main-social-links {
                gap: 20px;
            }

            .main-social-link {
                width: 52px;
                height: 52px;
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 16px;
            }

            .team-card {
                padding: 24px 20px;
            }

            .contact-section {
                padding: 32px 20px;
            }

            .main-social-links {
                flex-direction: column;
                align-items: center;
                gap: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1>Our Team</h1>
            <p>Meet the passionate students behind the Library Book Tracking System. We're dedicated to making library management seamless and efficient.</p>
        </header>

        <!-- Team Members Grid -->
        <section class="team-grid">
            <!-- Team Member 1 -->
            <div class="team-card">
                <img src="images/photo_2026-05-14_11-57-16.jpg" alt="Dawit Negasa" class="profile-image">
                <h3 class="member-name">Dawit Negasa</h3>
            </div>

            <!-- Team Member 2 -->
            <div class="team-card">
                <img src="images/photo_2026-05-14_11-57-02.jpg" alt="Dinaol Geleta" class="profile-image">
                <h3 class="member-name">Dinaol Geleta</h3>
            </div>

            <!-- Team Member 3 -->
            <div class="team-card">
                <img src="images/Lech.png" alt="Lechisa" class="profile-image">
                <h3 class="member-name">Lechisa Takela</h3>
            </div>

            <!-- Team Member 4 -->
            <div class="team-card">
                <img src="images/photo_2026-05-14_11-57-12.jpg" alt="Bona Chala" class="profile-image">
                <h3 class="member-name">Bona Chala</h3>
            </div>

            <!-- Team Member 5 -->
            <div class="team-card">
                <img src="images/photo_2026-05-14_11-57-09.jpg" alt="Bikila Kalbesa" class="profile-image">
                <h3 class="member-name">Bikila Kalbesa</h3>
            </div>

            <!-- Team Member 6 -->
            <div class="team-card">
                <img src="images/file_00000000a57471fdbd16849a0b82a352.png" alt="Alex Patel" class="profile-image">
                <h3 class="member-name">Birtukan Demeksa</h3>
            </div>

            <!-- Team Member 7 -->
            <div class="team-card">
                <img src="images/file_00000000492c71fd836877ee6e947b08.png" alt="Damme Tadela" class="profile-image">
                <h3 class="member-name">Damme Tadela</h3>
            </div>
        </section>
        <!-- CONTACT US SECTION -->
<section class="contact-section">
    <i class="fas fa-phone contact-icon"></i>
    <h2>Get In Touch</h2>
    <p>Questions about our Library Book Tracking System? Contact our team directly for support, demos, or collaboration.</p>
    
    <div class="contact-info">
        <div class="contact-item">
            <i class="fas fa-phone"></i>
            <a href="tel:+251996812331">+251 99 681 2331</a>
        </div>
        <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <a href="mailto:team@library.et">team@library.et</a>
        </div>
    </div>
</section>
    <script>
        // Simple scroll animation trigger
        window.addEventListener('scroll', () => {
            const cards = document.querySelectorAll('.team-card, .contact-section');
            cards.forEach((card, index) => {
                const cardTop = card.getBoundingClientRect().top;
                const cardVisible = 150;
                
                if (cardTop < window.innerHeight - cardVisible) {
                    card.style.animationPlayState = 'running';
                }
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Preload images for smooth loading
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.profile-image');
            images.forEach(img => {
                img.style.opacity = '1';
            });
        });
    </script>
</body>
</html>