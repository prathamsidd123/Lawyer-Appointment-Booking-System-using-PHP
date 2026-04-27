<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sarvaiya Associate | Legal Excellence</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
  --navy: #050e24;
  --deep-blue: #0a1f4e;
  --royal: #1340a0;
  --gold: #f5c518;
  --gold-light: #ffe270;
  --crimson: #c0392b;
  --teal: #0d9488;
  --purple: #7c3aed;
  --emerald: #059669;
  --white: #ffffff;
  --gray-100: #f8fafc;
  --gray-200: #e2e8f0;
  --gray-600: #64748b;
  --text: #1e293b;
  --shadow-gold: 0 0 30px rgba(245,197,24,0.4);
  --shadow-blue: 0 20px 60px rgba(10,31,78,0.3);
  --font-display: 'Playfair Display', serif;
  --font-body: 'DM Sans', sans-serif;
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }

body {
  font-family: var(--font-body);
  background: var(--navy);
  color: var(--white);
  cursor: auto;
}

#particles-canvas {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  z-index: 0;
  pointer-events: none;
}

nav {
  position: fixed;
  top: 0; width: 100%;
  z-index: 9000;
  padding: 0 5%;
  background: rgba(5,7,13,0.93);
  backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(197,160,40,0.2);
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 80px;
  animation: navSlide 0.8s cubic-bezier(0.16,1,0.3,1) both;
}

@keyframes navSlide {
  from { transform: translateY(-100%); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

.logo {
  font-family: var(--font-display);
  font-size: 22px;
  font-weight: 900;
  color: var(--gold);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 10px;
  letter-spacing: 0.5px;
  filter: drop-shadow(0 0 8px rgba(245,197,24,0.6));
  transition: filter 0.3s;
}
.logo:hover { filter: drop-shadow(0 0 20px rgba(245,197,24,1)); }

.logo-icon {
  width: 38px; height: 38px;
  background: linear-gradient(135deg, var(--gold), #c9a227);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--navy);
  font-size: 18px;
  animation: rotateLogo 6s ease-in-out infinite;
}
@keyframes rotateLogo {
  0%,100% { transform: rotate(0deg) scale(1); }
  25% { transform: rotate(5deg) scale(1.05); }
  75% { transform: rotate(-5deg) scale(1.05); }
}

nav ul { display: flex; gap: 6px; list-style: none; align-items: center; }

nav a {
  color: rgba(255,255,255,0.8);
  text-decoration: none;
  font-size: 17.5px;
  font-weight: 500;
  padding: 7px 14px;
  border-radius: 8px;
  transition: all 0.3s;
  position: relative;
}
nav a::after {
  content: '';
  position: absolute;
  bottom: 0; left: 50%;
  width: 0; height: 2px;
  background: var(--gold);
  border-radius: 2px;
  transition: width 0.3s, left 0.3s;
}
nav a:hover::after { width: 80%; left: 10%; }
nav a:hover { color: var(--gold); background: rgba(245,197,24,0.08); }

.btn-login {
  border: 1.5px solid var(--gold) !important;
  color: var(--gold) !important;
  border-radius: 30px !important;
  padding: 7px 18px !important;
}
.btn-login:hover { background: rgba(245,197,24,0.15) !important; }

.btn-register {
  background: linear-gradient(135deg, var(--gold), #c9a227) !important;
  color: var(--navy) !important;
  font-weight: 700 !important;
  border-radius: 30px !important;
  padding: 7px 20px !important;
  box-shadow: 0 4px 15px rgba(245,197,24,0.4);
}
.btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(245,197,24,0.6) !important; }

.hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 5px; }
.hamburger span { display: block; width: 25px; height: 2px; background: var(--gold); border-radius: 2px; transition: 0.3s; }

/* ===== HERO ===== */
#home {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 120px 10% 80px;
  overflow: hidden;
  z-index: 1;
  background:
    radial-gradient(ellipse at 50% 0%, rgba(197,160,40,0.1) 0%, transparent 55%),
    radial-gradient(ellipse at 80% 90%, rgba(10,15,35,0.8) 0%, transparent 50%),
    linear-gradient(160deg, #07090f 0%, #0b0e18 40%, #060810 100%);
}
#home::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, transparent, var(--gold), transparent);
}
#home::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(197,160,40,0.3), transparent);
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(245,197,24,0.08);
  border: 1px solid rgba(245,197,24,0.25);
  color: var(--gold);
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 3px;
  text-transform: uppercase;
  padding: 7px 20px;
  border-radius: 2px;
  margin-bottom: 28px;
  animation: fadeUp 0.8s 0.2s both;
}
.hero-badge i { animation: pulse 2s infinite; }
@keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }

#home h1 {
  font-family: var(--font-display);
  font-size: clamp(38px, 6vw, 80px);
  font-weight: 900;
  line-height: 1.1;
  margin-bottom: 24px;
  animation: fadeUp 0.8s 0.4s both;
}

.title-gradient {
  background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 50%, #c9a227 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  display: block;
}

#home p {
  font-size: clamp(15px, 2vw, 20px);
  color: rgba(255,255,255,0.55);
  max-width: 600px;
  margin: 0 auto 40px;
  line-height: 1.7;
  animation: fadeUp 0.8s 0.6s both;
}

.hero-btns {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
  animation: fadeUp 0.8s 0.8s both;
}

.hero-btn-primary {
  background: linear-gradient(135deg, var(--gold), #c9a227);
  color: #07090f;
  font-weight: 700;
  font-size: 14px;
  padding: 14px 34px;
  border-radius: 2px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  box-shadow: 0 6px 28px rgba(197,160,40,0.35);
  transition: all 0.3s;
  border: none;
  cursor: pointer;
  letter-spacing: 0.8px;
  text-transform: uppercase;
}
.hero-btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 40px rgba(197,160,40,0.55);
}

.hero-btn-secondary {
  background: transparent;
  color: rgba(255,255,255,0.85);
  font-weight: 600;
  font-size: 14px;
  padding: 13px 34px;
  border-radius: 2px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  border: 1px solid rgba(197,160,40,0.35);
  transition: all 0.3s;
  cursor: pointer;
  letter-spacing: 0.8px;
  text-transform: uppercase;
}
.hero-btn-secondary:hover {
  border-color: var(--gold);
  color: var(--gold);
  transform: translateY(-3px);
  background: rgba(197,160,40,0.05);
}

.float-shape {
  position: absolute;
  border-radius: 50%;
  opacity: 0.03;
  animation: floatAnim 8s ease-in-out infinite;
}
.shape1 { width: 500px; height: 500px; background: var(--gold); top: -150px; right: -150px; animation-delay: 0s; }
.shape2 { width: 300px; height: 300px; background: var(--gold); bottom: 0; left: -100px; animation-delay: 2s; }
.shape3 { width: 200px; height: 200px; background: var(--gold); top: 40%; right: 5%; animation-delay: 4s; }

@keyframes floatAnim {
  0%,100% { transform: translate(0,0) scale(1); }
  33% { transform: translate(20px,-30px) scale(1.05); }
  66% { transform: translate(-15px,20px) scale(0.95); }
}

section { position: relative; z-index: 1; }

.section-label {
  display: inline-flex;
  align-items: center;
  /* gap: 90px; */
  font-size: 30px;
  font-weight: 1000;
  letter-spacing: 6px;
  text-transform:uppercase;
  margin-bottom: 70px;
  padding: 12px 16px;
  border-radius: 2px;
  background: rgba(197,160,40,0.08);
  color: var(--gold);
  border: 1px solid rgba(197,160,40,0.2);
}

.section-title {
  font-family: var(--font-display);
  font-size: clamp(28px, 4vw, 48px);
  font-weight: 900;
  line-height: 1.2;
  margin-bottom: 16px;
  color: #f0e6c8;
}

.section-sub {
  font-size: 16px;
  line-height: 1.7;
  max-width: 560px;
  margin: 0 auto 60px;
  opacity: 0.45;
}

/* ===== CATEGORIES ===== */
#categories {
  padding: 250px 10%;
  text-align: center;
  background:
    linear-gradient(180deg, #060810 0%, #0b0d16 100%);
  border-top: 1px solid rgba(197,160,40,0.1);
  position: relative;
}
#categories::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(197,160,40,0.4), transparent);
}

.cat-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 10x;
  margin-top: 50px;
  border: 1px solid rgba(197,160,40,0.15);
  border-radius: 4px;
  overflow: hidden;
  background: rgba(197,160,40,0.08);
}

.cat-card {
  position: relative;
  padding: 100px 32px 56px;
  text-align: left;
  cursor: pointer;
  transition: all 0.35s;
  animation: fadeUp 0.7s both;
  background: #0b0d16;
}
.cat-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: var(--gold);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s;
}
.cat-card:hover::before { transform: scaleX(1); }
.cat-card:hover { background: #10121d; }

.cat-card:nth-child(1) { animation-delay: 0.1s; }
.cat-card:nth-child(2) { animation-delay: 0.2s; }
.cat-card:nth-child(3) { animation-delay: 0.3s; }
.cat-card:nth-child(4) { animation-delay: 0.4s; }

.cat-icon-wrap {
  width: 50px; height: 50px;
  border: 1px solid rgba(197,160,40,0.25);
  border-radius: 2px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  margin-bottom: 22px;
  color: var(--gold);
  transition: background 0.3s;
}
.cat-card:hover .cat-icon-wrap { background: rgba(197,160,40,0.08); }

.cat-card h3 {
  font-family: var(--font-display);
  font-size: 30px;
  font-weight: 700;
  margin-bottom: 10px;
  color: #f0e6c8;
}

.cat-card p { font-size: 13.5px; color: rgba(255,255,255,0.4); line-height: 1.65; }

.cat-arrow {
  position: absolute;
  bottom: 28px; right: 28px;
  width: 28px; height: 28px;
  border: 1px solid rgba(197,160,40,0.2);
  border-radius: 2px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(197,160,40,0.4);
  font-size: 11px;
  transition: all 0.3s;
}
.cat-card:hover .cat-arrow {
  background: var(--gold);
  color: #0b0d16;
  border-color: var(--gold);
}

/* ===== LAWYERS ===== */
#lawyers {
  padding: 190px 8%;
  text-align: center;
  background:
    linear-gradient(160deg, #0d0f1a 0%, #0a0c14 50%, #0e1020 100%);
  border-top: 1px solid rgba(197,160,40,0.1);
  position: relative;
  overflow: hidden;
}
#lawyers::before {
  content: 'JUSTICE';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-family: var(--font-display);
  font-size: 220px;
  font-weight: 900;
  color: rgba(197,160,40,0.018);
  letter-spacing: 30px;
  pointer-events: none;
  white-space: nowrap;
}

.lawyers-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
  gap: 20px;
}

.lawyer-card {
  background: #0d0f1a;
  border: 1px solid rgba(197,160,40,0.1);
  border-radius: 4px;
  padding: 20px 28px;
  text-align: center;
  transition: all 0.4s;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  animation: fadeUp 0.7s both;
}

.lawyer-card:nth-child(1) { animation-delay: 0.1s; }
.lawyer-card:nth-child(2) { animation-delay: 0.2s; }
.lawyer-card:nth-child(3) { animation-delay: 0.3s; }

.lawyer-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, transparent, var(--gold), transparent);
  opacity: 0;
  transition: opacity 0.4s;
}
.lawyer-card:hover::before { opacity: 1; }
.lawyer-card:hover {
  background: #111325;
  border-color: rgba(197,160,40,0.3);
  transform: translateY(-6px);
  box-shadow: 0 20px 60px rgba(0,0,0,0.6), 0 0 30px rgba(197,160,40,0.05);
}

.lawyer-avatar {
  width: 88px; height: 88px;
  border-radius: 50%;
  margin: 0 auto 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 34px;
  background: rgba(197,160,40,0.05);
  border: 1px solid rgba(197,160,40,0.25);
  color: var(--gold);
  position: relative;
  transition: transform 0.4s, border-color 0.4s;
}
.lawyer-card:hover .lawyer-avatar { transform: scale(1.06); border-color: rgba(197,160,40,0.5); }

.lawyer-badge {
  position: absolute;
  bottom: 0; right: 0;
  width: 24px; height: 24px;
  background: var(--emerald);
  border-radius: 50%;
  border: 2px solid #0d0f1a;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 8px;
}

.lawyer-card h3 {
  font-family: var(--font-display);
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 6px;
  color: #f0e6c8;
}
.lawyer-spec {
  font-size: 11px;
  color: var(--gold);
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin-bottom: 6px;
}
.lawyer-exp { font-size: 13px; color: rgba(255,255,255,0.35); margin-bottom: 14px; }

.stars { display: flex; justify-content: center; gap: 3px; margin-bottom: 8px; }
.stars i { color: var(--gold); font-size: 12px; }

.lawyer-rating { font-size: 14px; font-weight: 700; margin-bottom: 22px; color: rgba(255,255,255,0.85); }
.lawyer-rating span { color: rgba(255,255,255,0.3); font-weight: 400; font-size: 12px; }

.book-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 26px;
  border-radius: 2px;
  font-weight: 700;
  font-size: 12px;
  letter-spacing: 1px;
  text-transform: uppercase;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s;
  background: transparent;
  color: var(--gold);
  border: 1px solid rgba(197,160,40,0.4);
}
.book-btn:hover {
  background: var(--gold);
  color: #0d0f1a;
  border-color: var(--gold);
  box-shadow: 0 6px 24px rgba(197,160,40,0.3);
}

/* ===== ABOUT ===== */
#about {
  padding: 150px 5%;
  background:
    radial-gradient(ellipse at 20% 60%, rgba(197,160,40,0.04) 0%, transparent 55%),
    linear-gradient(180deg, #080a12 0%, #0b0d17 100%);
  border-top: 1px solid rgba(197,160,40,0.1);
  border-bottom: 1px solid rgba(197,160,40,0.1);
  text-align: center;
  position: relative;
}
#about::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(197,160,40,0.35), transparent);
}

.about-inner {
  max-width: 960px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 60px;
}

.about-left { text-align: center; width: 100%; }

.about-left .section-title { margin-bottom: 20px; }

.about-left > p {
  color: rgba(255,255,255,0.5);
  line-height: 1.85;
  font-size: 15.5px;
  margin-bottom: 40px;
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
}

.about-features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1px;
  width: 100%;
  border: 1px solid rgba(197,160,40,0.12);
  border-radius: 4px;
  overflow: hidden;
  background: rgba(197,160,40,0.08);
}

.about-feat {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 12px;
  padding: 30px 35px;
  background: #0b0d17;
  transition: background 0.3s;
}
.about-feat:hover { background: #0f1120; }

.feat-icon {
  width: 48px; height: 48px;
  border: 1px solid rgba(197,160,40,0.2);
  border-radius: 2px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  font-size: 18px;
}
.feat-icon.gold { background: rgba(197,160,40,0.06); color: var(--gold); }
.feat-icon.teal { background: rgba(13,148,136,0.06); color: #5eead4; border-color: rgba(13,148,136,0.2); }
.feat-icon.purple { background: rgba(124,58,237,0.06); color: #c4b5fd; border-color: rgba(124,58,237,0.2); }

.about-feat h4 { font-size: 16px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #f0e6c8; }
.about-feat p { font-size: 15px; color: rgba(255,255,255,0.4); line-height: 1.65; margin: 0; }

.about-stats-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 1px;
  width: 100%;
  border: 1px solid rgba(197,160,40,0.12);
  border-radius: 4px;
  overflow: hidden;
  background: rgba(197,160,40,0.08);
}

.about-stat-card {
  background: #0b0d17;
  padding: 40px 20px;
  text-align: center;
  transition: background 0.3s;
  position: relative;
}
.about-stat-card::after {
  content: '';
  position: absolute;
  bottom: 0; left: 25%; right: 25%;
  height: 1px;
  background: var(--gold);
  transform: scaleX(0);
  transition: transform 0.4s;
}
.about-stat-card:hover { background: #0f1120; }
.about-stat-card:hover::after { transform: scaleX(1); }

.about-stat-num {
  font-family: var(--font-display);
  font-size: 46px;
  font-weight: 900;
  background: linear-gradient(135deg, var(--gold), var(--gold-light));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  line-height: 1;
  display: block;
}
.about-stat-label { font-size: 12px; color: rgba(255,255,255,0.35); margin-top: 10px; letter-spacing: 0.5px; line-height: 1.5; }

/* ===== CONTACT ===== */
#contact {
  padding: 185px 8%;
  background:
    radial-gradient(ellipse at 75% 25%, rgba(197,160,40,0.05) 0%, transparent 55%),
    linear-gradient(180deg, #0b0d17 0%, #07090f 100%);
  text-align: center;
  position: relative;
}
#contact::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(197,160,40,0.3), transparent);
}

.contact-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1px;
  max-width: 960px;
  margin: 0 auto;
  border: 1px solid rgba(197,160,40,0.12);
  border-radius: 4px;
  overflow: hidden;
  background: rgba(197,160,40,0.08);
}

.contact-item {
  display: flex;
  flex-direction: column;
  gap: 14px;
  align-items: center;
  padding: 60px 20px;
  background: #0b0d17;
  transition: background 0.3s;
  text-align: center;
}
.contact-item:hover { background: #0f1120; }

.contact-item-icon {
  width: 50px; height: 50px;
  border: 1px solid rgba(197,160,40,0.2);
  border-radius: 2px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 19px;
  flex-shrink: 0;
}
.ci-loc { background: rgba(197,160,40,0.06); color: var(--gold); }
.ci-phone { background: rgba(13,148,136,0.06); color: #5eead4; border-color: rgba(13,148,136,0.2); }
.ci-mail { background: rgba(124,58,237,0.06); color: #c4b5fd; border-color: rgba(124,58,237,0.2); }
.ci-time { background: rgba(192,57,43,0.06); color: #fca5a5; border-color: rgba(192,57,43,0.2); }

.contact-item h4 {
  font-size: 15px;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 700;
}
.contact-item p { font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.65); line-height: 1.65; }

/* ===== FOOTER ===== */
footer {
  background: #040509;
  padding: 60px 8% 30px;
  border-top: 1px solid rgba(197,160,40,0.15);
  position: relative;
  z-index: 1;
}
footer::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(197,160,40,0.5), transparent);
}
.footer-inner {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr;
  gap: 40px;
  margin-bottom: 40px;
}
.footer-brand .logo { font-size: 20px; margin-bottom: 14px; display: inline-flex; }
.footer-brand p { font-size: 13.5px; color: rgba(255,255,255,0.3); line-height: 1.8; max-width: 280px; }
.footer-col h4 {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 1px solid rgba(197,160,40,0.15);
}
.footer-col a {
  display: block;
  font-size: 13.5px;
  color: rgba(255,255,255,0.35);
  text-decoration: none;
  margin-bottom: 10px;
  transition: color 0.3s;
}
.footer-col a:hover { color: var(--gold); }
.footer-bottom {
  border-top: 1px solid rgba(255,255,255,0.05);
  padding-top: 24px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}
.footer-bottom p { font-size: 12px; color: rgba(255,255,255,0.2); letter-spacing: 0.5px; text-align: center; }

.scroll-top {
  position: fixed;
  bottom: 28px;
  right: 28px;
  z-index: 8000;
  display: none;
  align-items: center;
  gap: 8px;
  padding: 10px 18px;
  background: linear-gradient(135deg, var(--gold), #c9a227);
  color: #07090f;
  border: none;
  border-radius: 2px;
  font-family: var(--font-body);
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  cursor: pointer;
  box-shadow: 0 6px 24px rgba(197,160,40,0.4);
  transition: all 0.3s;
}
.scroll-top:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(197,160,40,0.55); }

.reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.8s, transform 0.8s cubic-bezier(0.16,1,0.3,1); }
.reveal.active { opacity: 1; transform: translateY(0); }

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(40px); }
  to { opacity: 1; transform: translateY(0); }
}

.toast {
  position: fixed;
  bottom: 90px; right: 28px;
  background: rgba(8,10,18,0.97);
  color: rgba(255,255,255,0.9);
  padding: 14px 22px;
  border-radius: 2px;
  font-size: 13px;
  font-weight: 600;
  z-index: 9999;
  transform: translateX(200px);
  opacity: 0;
  transition: all 0.4s;
  display: flex;
  align-items: center;
  gap: 10px;
  border: 1px solid rgba(197,160,40,0.25);
  border-left: 3px solid var(--gold);
  box-shadow: 0 10px 40px rgba(0,0,0,0.5);
  letter-spacing: 0.3px;
}
.toast.show { transform: translateX(0); opacity: 1; }
.toast i { color: var(--gold); }

@media(max-width: 900px) {
  .footer-inner { grid-template-columns: 1fr 1fr; }
  .footer-brand { grid-column: 1 / -1; }
}
@media(max-width: 768px) {
  nav ul { display: none; flex-direction: column; position: absolute; top: 80px; left: 0; right: 0; background: rgba(4,5,9,0.99); padding: 20px; gap: 10px; border-bottom: 1px solid rgba(197,160,40,0.15); }
  nav ul.open { display: flex; }
  .hamburger { display: flex; }
  .footer-inner { grid-template-columns: 1fr; }
  .scroll-top { padding: 9px 14px; }
}
@media(max-width: 480px) { .hero-stats { gap: 20px; } }


</style>
</head>
<body>

<canvas id="particles-canvas"></canvas>

<div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toast-msg">Done!</span></div>

<nav id="navbar">
  <a class="logo" href="#home">
    <div class="logo-icon"><i class="fas fa-balance-scale"></i></div>
    Sarvaiya Associate
  </a>
  <div class="hamburger" id="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
  <ul id="navMenu">
    <li><a href="#home" onclick="closeMenu()">Home</a></li>
    <li><a href="#categories" onclick="closeMenu()">Services</a></li>
    <li><a href="#lawyers" onclick="closeMenu()">Lawyers</a></li>
    <li><a href="#about" onclick="closeMenu()">About</a></li>
    <li><a href="#contact" onclick="closeMenu()">Contact</a></li>
    <li><a class="btn-login" href="law-appointment/login.php">Login</a></li>
    <li><a class="btn-register" href="law-appointment/register.php">Register</a></li>
  </ul>
</nav>

<section id="home">
  <div class="float-shape shape1"></div>
  <div class="float-shape shape2"></div>
  <div class="float-shape shape3"></div>
  <div>
    <h1>
      Find Your Perfect<br>
      <span class="title-gradient">Legal Expert</span>
      Instantly
    </h1>
    <p>Book certified legal professionals anytime, anywhere.</p>
    <div class="hero-btns">
      <a class="hero-btn-primary" href="law-appointment/user/search_lawyer.php">
        <i class="fas fa-search"></i> Find Lawyers
      </a>
      <a class="hero-btn-secondary" href="#lawyers">
        <i class="fas fa-calendar-check"></i> Book Appointment
      </a>
    </div>
  </div>
</section>

<section id="categories">
  <div class="reveal">
    <div class="section-label">Practice Areas</div>
    <h2 class="section-title">Choose Your Services</h2>
    <p class="section-sub">From civil disputes to corporate compliance and cover every legal need.</p>
  </div>

  <div class="cat-grid reveal">
    <div class="cat-card">
      <div class="cat-icon-wrap"><i class="fas fa-balance-scale"></i></div>
      <h3>IPR Law</h3>
      <p>Trademark, Copyright, Patents, Property and industrial designs.</p>
      <div class="cat-arrow"><i class="fas fa-arrow-right"></i></div>
    </div>
    <div class="cat-card">
      <div class="cat-icon-wrap"><i class="fas fa-building-columns"></i></div>
      <h3>Business Registration</h3>
      <p>Company registrations, Public Limited Companies, Private Limited Companies, One Person Companies, Partnership Firms.</p>
      <div class="cat-arrow"><i class="fas fa-arrow-right"></i></div>
    </div>
    <div class="cat-card">
      <div class="cat-icon-wrap"><i class="fas fa-file-signature"></i></div>
      <h3>Government Compliance</h3>
      <p>ISO certifications, PAN services, GST registration and regulatory compliance support.</p>
      <div class="cat-arrow"><i class="fas fa-arrow-right"></i></div>
    </div>
    <div class="cat-card">
      <div class="cat-icon-wrap"><i class="fas fa-gavel"></i></div>
      <h3>Legal Disputes</h3>
      <p>Cheque bounce cases, litigation support, court representation and dispute resolution.</p>
      <div class="cat-arrow"><i class="fas fa-arrow-right"></i></div>
    </div>
  </div>
</section>

<section id="lawyers">
  <div class="reveal">
    <div class="section-label">Our Team</div>
    <h2 class="section-title">Meet Our Featured<br>Legal Experts</h2>
    <p class="section-sub">Verified professionals with decades of corporate experience.</p>
  </div>

  <div class="lawyers-grid reveal">
    <div class="lawyer-card">
      <div class="lawyer-avatar">
        <i class="fas fa-user-tie"></i>
        <div class="lawyer-badge"><i class="fas fa-check" style="font-size:8px;color:white;"></i></div>
      </div>
      <h3>Priya Patel</h3>
      <div class="lawyer-spec">Criminal Law</div>
      <div class="lawyer-exp">12+ Years Experience</div>
      <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        <i class="fas fa-star"></i><i class="fas fa-star-hal  f-alt"></i>
      </div>
      <div class="lawyer-rating">4.9 <span>(312 Total Clients)</span></div>
      <a class="book-btn" href="law-appointment/user/book_appointment.php">
        <i class="fas fa-calendar-plus"></i> Book Consultation
      </a>
    </div>
    <div class="lawyer-card">
      <div class="lawyer-avatar">
        <i class="fas fa-user-tie"></i>
        <div class="lawyer-badge"><i class="fas fa-check" style="font-size:8px;color:white;"></i></div>
      </div>
      <h3>Utsav Sarvaiya</h3>
      <div class="lawyer-spec">Ipr Law</div>
      <div class="lawyer-expx">9+ Years Experience</div>
      <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        <i class="fas fa-star"></i><i class="fas fa-star"></i>
      </div>
      <div class="lawyer-rating">5.0<span>(500 Total Clients)</span></div>
      <a class="book-btn" href="law-appointment/user/book_appointment.php" >
        <i class="fas fa-calendar-plus"></i> Book Consultation
      </a>
    </div>
    <div class="lawyer-card">
      <div class="lawyer-avatar">
        <i class="fas fa-user-tie"></i>
        <div class="lawyer-badge"><i class="fas fa-check" style="font-size:8px;color:white;"></i></div>
      </div>
      <h3>Amit Verma</h3>
      <div class="lawyer-spec">legal dispute</div>
      <div class="lawyer-exp">15+ Years Experience</div>
      <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        <i class="fas fa-star"></i><i class="fas fa-star"></i>
      </div>
      <div class="lawyer-rating">4.6 <span>(491 Total Clients)</span></div>
      <a class="book-btn" href="law-appointment/user/book_appointment.php">
        <i class="fas fa-calendar-plus"></i> Book Consultation
      </a>
    </div>
  </div>
</section>

<section id="about">
  <div class="about-inner reveal">
    <div class="about-left">
      <div class="section-label">About Us</div>
      <h2 class="section-title">Best Advocate of Ahmedabad</h2>
      <p>Sarvaiya Associate is one of the leading law firms in Ahmedabad, founded in 2022 by Advocate Utsav S. Sarvaiya, providing reliable and result-oriented legal solutions. We understand that legal matters can be overwhelming, and our experienced team ensures clear guidance and practical advice at every step.</p>
      <div class="about-features">
        <div class="about-feat">
          <div class="feat-icon gold"><i class="fas fa-award"></i></div>
          <div>
            <h4>Bar Council Certified</h4>
            <p>All lawyers are registered with the Bar Council of India and state bar councils.</p>
          </div>
        </div>
        <div class="about-feat">
          <div class="feat-icon teal"><i class="fas fa-eye"></i></div>
          <div>
            <h4>Our Vision</h4>
            <p>This being a two-way process, starts with bringing value to our clients first.</p>
          </div>
        </div>
        <div class="about-feat">
          <div class="feat-icon purple"><i class="fas fa-handshake"></i></div>
          <div>
            <h4>Our Clientele</h4>
            <p>Our entire service is focused on client satisfaction — we take pride in successfully rendered services.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="about-stats-row">
      <div class="about-stat-card">
        <span class="about-stat-num">300+</span>
        <div class="about-stat-label">Trademark Registrations</div>
      </div>
      <div class="about-stat-card">
        <span class="about-stat-num">100+</span>
        <div class="about-stat-label">FSSAI Registrations &amp; Compliance</div>
      </div>
      <div class="about-stat-card">
        <span class="about-stat-num">50+</span>
        <div class="about-stat-label">GST Registrations &amp; Documentation</div>
      </div>
    </div>
  </div>
</section>

<section id="contact">
  <div class="reveal">
    <div class="section-label">Contact Us</div>
    <h2 class="section-title">To Book Your Appointment</h2>
    <p class="section-sub">Have a question or need to book a consultation? We respond within 2 hours.</p>
  </div>

  <div class="contact-cards reveal">
    <div class="contact-item">
      <div class="contact-item-icon ci-loc"><i class="fas fa-location-dot"></i></div>
      <div>
        <h4>Office Location</h4><br>
        <p>B/23, Murlidhar Society, Part-3, Vatva Road, Near Gebanshah Pir, Vatva, Ahmedabad — 382440</p>
      </div>
    </div>
    <div class="contact-item">
      <div class="contact-item-icon ci-phone"><i class="fas fa-phone"></i></div>
      <div>
        <h4>Phone Number</h4><br>
        <p>+91 8155814195</p>
      </div>
    </div>
    <div class="contact-item">
      <div class="contact-item-icon ci-mail"><i class="fas fa-envelope"></i></div>
      <div>
        <h4>Email Address</h4><br>
        <p>Sarvaiyaassociate2022@gmail.com</p>
      </div>
    </div>
    <div class="contact-item">
      <div class="contact-item-icon ci-time"><i class="fas fa-clock"></i></div>
      <div>
        <h4>Working Hours</h4><br>
        <p>Monday – Saturday: 10 AM – 7 PM IST<br>Sunday: Closed</p>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="footer-inner">
    <div class="footer-brand">
      <a class="logo" href="#home">
        <div class="logo-icon"><i class="fas fa-balance-scale"></i></div>
        Sarvaiya Associate
      </a>
      <p>India's most trusted platform for connecting clients with verified legal professionals. Fast, secure, and transparent.</p>
    </div>
    <div class="footer-col">
      <h4>Quick Links</h4>
      <a href="#home">Home</a>
      <a href="#categories">Practice Areas</a>
      <a href="#lawyers">Our Lawyers</a>
      <a href="#about">About Us</a>
    </div>
    <div class="footer-col">
      <h4>Legal</h4>
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Disclaimer</a>
      <a href="#">Refund Policy</a>
      <a href="#contact">Contact</a>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2026 Sarvaiya Associate &nbsp;|&nbsp; Professional Legal Services, Ahmedabad, Gujarat</p>
  </div>
</footer>

<button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <i class="fas fa-arrow-up"></i> Back to Top
</button>




<script>
  
const canvas = document.getElementById('particles-canvas');
const ctx = canvas.getContext('2d');
let particles = [], W, H;

function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
resize();
window.addEventListener('resize', resize);

class Particle {
  constructor() { this.reset(); }
  reset() {
    this.x = Math.random() * W;
    this.y = Math.random() * H;
    this.r = Math.random() * 0.8 + 0.2;
    this.speedX = (Math.random() - 0.5) * 0.25;
    this.speedY = (Math.random() - 0.5) * 0.25;
    this.alpha = Math.random() * 0.18 + 0.04;
    this.color = '197,160,40';
  }
  update() {
    this.x += this.speedX; this.y += this.speedY;
    if (this.x < 0 || this.x > W || this.y < 0 || this.y > H) this.reset();
  }
  draw() {
    ctx.beginPath();
    ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
    ctx.fillStyle = `rgba(${this.color},${this.alpha})`;
    ctx.fill();
  }
}

for (let i = 0; i < 70; i++) particles.push(new Particle());

function connectParticles() {
  for (let a = 0; a < particles.length; a++) {
    for (let b = a+1; b < particles.length; b++) {
      const dx = particles[a].x - particles[b].x;
      const dy = particles[a].y - particles[b].y;
      const dist = Math.sqrt(dx*dx + dy*dy);
      if (dist < 90) {
        ctx.strokeStyle = `rgba(197,160,40,${0.035 * (1 - dist/90)})`;
        ctx.lineWidth = 0.4;
        ctx.beginPath();
        ctx.moveTo(particles[a].x, particles[a].y);
        ctx.lineTo(particles[b].x, particles[b].y);
        ctx.stroke();
      }
    }
  }
}

function animateParticles() {
  ctx.clearRect(0, 0, W, H);
  particles.forEach(p => { p.update(); p.draw(); });
  connectParticles();
  requestAnimationFrame(animateParticles);
}
animateParticles();

const revealEls = document.querySelectorAll('.reveal');
function revealOnScroll() {
  revealEls.forEach(el => {
    if (el.getBoundingClientRect().top < window.innerHeight - 80) el.classList.add('active');
  });
}
window.addEventListener('scroll', revealOnScroll);
revealOnScroll();

const scrollBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
  scrollBtn.style.display = window.scrollY > 400 ? 'flex' : 'none';
});

function toggleMenu() { document.getElementById('navMenu').classList.toggle('open'); }
function closeMenu() { document.getElementById('navMenu').classList.remove('open'); }

function showToast(msg) {
  const toast = document.getElementById('toast');
  document.getElementById('toast-msg').textContent = msg || 'Done!';
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 3000);
}

const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('nav ul li a[href^="#"]');
window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(s => { if (window.scrollY >= s.offsetTop - 100) current = s.id; });
  navLinks.forEach(a => {
    a.style.color = '';
    if (a.getAttribute('href') === '#' + current) a.style.color = 'var(--gold)';
  });
});
</script>
</body>
</html> 
