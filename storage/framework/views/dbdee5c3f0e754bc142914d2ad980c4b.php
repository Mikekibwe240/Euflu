<!DOCTYPE html>
<html lang="fr" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="if(localStorage.getItem('darkMode') === null){localStorage.setItem('darkMode', false)}; $watch('darkMode', value => { if(value){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}}); if(darkMode){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'EUFLU'); ?></title>
    <!-- Police Bundesliga (Open Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        html, body {
            background: #18181b !important;
            font-family: 'Open Sans', Arial, Helvetica, sans-serif !important;
            color: #fff !important;
        }
        body {
            font-size: 1.05rem;
            letter-spacing: 0.01em;
        }
        .dark html, .dark body {
            background: #18181b !important;
            color: #f4f4f5 !important;
        }
        /* Header Bundesliga */
        .bundesliga-header {
            background: #23272a !important;
            color: #fff !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            box-shadow: 0 2px 8px 0 rgba(0,0,0,0.12);
        }
        .bundesliga-logo {
            color: #e2001a !important;
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: 0.1em;
        }
        .bundesliga-menu a {
            color: #fff !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: color 0.2s, background 0.2s;
        }
        .bundesliga-menu a:hover, .bundesliga-menu a.active {
            color: #00ff29 !important;
            background: rgba(34,197,94,0.08);
        }
        /* Accent Bundesliga (utiliser Tailwind pour text-[#E2001A], bg-[#E2001A], border-[#E2001A]) */
        /* Dark mode corrections */
        .dark .bg-white { background-color: #18181b !important; }
        .dark .border-gray-200 { border-color: #333 !important; }
        .dark .shadow-lg, .dark .shadow-xl, .dark .shadow-2xl { box-shadow: 0 4px 32px 0 rgba(0,0,0,0.7) !important; }
        .dark .text-gray-700, .dark .text-gray-500, .dark .text-gray-800, .dark .text-gray-900 {
            color: #e5e7eb !important;
        }
        /* Harmonisation des liens et boutons */
        a, button {
            transition: color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        a, .btn, button {
            border-radius: 0.5rem;
            font-weight: 600;
        }
        a:hover, .btn:hover, button:hover {
            box-shadow: 0 2px 8px 0 rgba(226,0,26,0.08);
        }
    </style>
</head>
<body class="min-h-screen bg-[#18181b] text-white font-sans transition-colors duration-300">
<nav class="bg-[#23272a] shadow sticky top-0 z-50 border-b-4 border-[#6fcf97] bundesliga-header">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 flex items-center justify-between h-16">
        <div class="flex items-center gap-2 min-w-[160px]">
            <div class="flex items-center justify-center h-12 w-12 bg-white rounded-full border-2 border-[#E2001A] shadow-md">
                <img src="/storage/img_euflu/fecofa.png" alt="Logo Fecofa" class="h-10 w-10 object-contain" />
            </div>
            <span class="bundesliga-logo ml-2 align-middle flex items-center" style="line-height:1;">EUFLU</span>
        </div>
        <div class="bundesliga-menu hidden md:flex gap-4 font-bold uppercase text-white text-sm tracking-wider flex-1 justify-center">
            <a href="/" class="px-2 py-1">Accueil</a>
            <a href="/classement" class="px-2 py-1">Classement</a>
            <a href="/matchs" class="px-2 py-1">Fixation et Résultats</a>
            <a href="/equipes" class="px-2 py-1">Equipes</a>
            <a href="/joueurs" class="px-2 py-1">Joueurs</a>
            <a href="/buteurs" class="px-2 py-1">Buteurs</a>
            <a href="/articles" class="px-2 py-1">Actualités</a>
            <a href="/reglements" class="px-2 py-1">Reglements</a>
        </div>
        <div class="md:hidden flex items-center">
            <button id="nav-toggle" class="text-white focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>
    <div id="nav-menu" class="md:hidden fixed inset-0 bg-black/80 z-50 hidden">
        <div class="flex flex-col gap-2 mt-24 mx-6 bg-[#23272a] rounded-lg p-6 shadow-lg">
            <a href="/" class="px-2 py-2 text-white font-bold text-lg" onclick="document.getElementById('nav-menu').classList.add('hidden')">Accueil</a>
            <a href="/classement" class="px-2 py-2 text-white font-bold text-lg" onclick="document.getElementById('nav-menu').classList.add('hidden')">Classement</a>
            <a href="/matchs" class="px-2 py-2 text-white font-bold text-lg" onclick="document.getElementById('nav-menu').classList.add('hidden')">Fixation et Résultats</a>
            <a href="/equipes" class="px-2 py-2 text-white font-bold text-lg" onclick="document.getElementById('nav-menu').classList.add('hidden')">Equipes</a>
            <a href="/joueurs" class="px-2 py-2 text-white font-bold text-lg" onclick="document.getElementById('nav-menu').classList.add('hidden')">Joueurs</a>
            <a href="/buteurs" class="px-2 py-2 text-white font-bold text-lg" onclick="document.getElementById('nav-menu').classList.add('hidden')">Buteurs</a>
            <a href="/articles" class="px-2 py-2 text-white font-bold text-lg" onclick="document.getElementById('nav-menu').classList.add('hidden')">Actualités</a>
            <a href="/reglements" class="px-2 py-2 text-white font-bold text-lg" onclick="document.getElementById('nav-menu').classList.add('hidden')">Reglements</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.getElementById('nav-toggle');
            const navMenu = document.getElementById('nav-menu');
            navToggle.addEventListener('click', function() {
                navMenu.classList.toggle('hidden');
            });
            navMenu.addEventListener('click', function(e) {
                if (e.target === navMenu) navMenu.classList.add('hidden');
            });
        });
    </script>
</nav>
<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>
<footer class="mt-16 border-t pt-8 text-center text-gray-500 dark:text-gray-400">
    <div class="mb-2 flex justify-center gap-4">
        <a href="#" class="hover:text-[#E2001A]"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="#" class="hover:text-[#E2001A]"><i class="fab fa-twitter fa-lg"></i></a>
        <a href="#" class="hover:text-[#E2001A]"><i class="fab fa-instagram fa-lg"></i></a>
    </div>
    <div>© <?php echo e(date('Y')); ?> EUFLU. Tous droits réservés.</div>
</footer>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/layouts/public.blade.php ENDPATH**/ ?>