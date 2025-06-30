
<!DOCTYPE html>
<html lang="fr" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="if(localStorage.getItem('darkMode') === null){localStorage.setItem('darkMode', false)}; $watch('darkMode', value => { if(value){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}}); if(darkMode){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>
        label, .form-label {
            color: #1a202c !important;
        }
        .dark label, .dark .form-label {
            color: #f3f4f6 !important;
        }
        input, select, textarea {
            color: #1a202c !important;
        }
        .dark input, .dark select, .dark textarea {
            color: #f3f4f6 !important;
            background-color: #1f2937 !important;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-lg flex flex-col">
            <div class="p-6 text-2xl font-extrabold text-blue-700 dark:text-blue-300 tracking-tight border-b border-gray-200 dark:border-gray-700">
                <span class="">EUFLU</span>
            </div>
            <nav class="flex-1 mt-6 space-y-2 px-4">
                <a href="/admin" class="block py-2.5 px-4 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 font-medium transition text-gray-800 dark:text-gray-100">Dashboard</a>
                <a href="/admin/saisons" class="block py-2.5 px-4 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 font-medium transition text-gray-800 dark:text-gray-100">Saisons</a>
                <a href="/admin/equipes" class="block py-2.5 px-4 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 font-medium transition text-gray-800 dark:text-gray-100">Équipes</a>
                <a href="/admin/joueurs" class="block py-2.5 px-4 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 font-medium transition text-gray-800 dark:text-gray-100">Joueurs</a>
                <a href="/admin/transferts" class="block py-2.5 px-4 rounded-lg hover:bg-green-100 dark:hover:bg-green-900 font-medium transition text-green-800 dark:text-green-200">Transferts</a>
                <a href="/admin/matchs" class="block py-2.5 px-4 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 font-medium transition text-gray-800 dark:text-gray-100">Matchs</a>
                <a href="/admin/articles" class="block py-2.5 px-4 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 font-medium transition text-gray-800 dark:text-gray-100">Articles</a>
                <a href="/admin/reglements" class="block py-2.5 px-4 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 font-medium transition text-gray-800 dark:text-gray-100">Règlements</a>
                <a href="/admin/users" class="block py-2.5 px-4 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 font-medium transition text-gray-800 dark:text-gray-100">Utilisateurs</a>
                
            </nav>
        </aside>
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="flex items-center justify-between bg-white dark:bg-gray-800 shadow px-8 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="text-lg font-semibold text-gray-800 dark:text-white"><?php echo $__env->yieldContent('header', 'Tableau de bord'); ?></div>
                <div class="flex items-center gap-4">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 transition">
                        <span x-show="!darkMode">🌙</span>
                        <span x-show="darkMode">☀️</span>
                    </button>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                            <span class="inline-block w-9 h-9 rounded-full bg-blue-200 dark:bg-blue-700 flex items-center justify-center text-xl text-blue-800 dark:text-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </span>
                            <span class="hidden md:inline text-gray-700 dark:text-gray-200 font-medium"><?php echo e(auth()->user()->name ?? 'Profil'); ?></span>
                            <svg class="w-4 h-4 ml-1 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded shadow-lg py-2 z-50 border border-gray-200 dark:border-gray-700" x-cloak>
                            <a href="/admin/profile" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-900 font-medium rounded transition flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Profil
                            </a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-900 font-medium rounded transition flex items-center gap-2">
                                    <svg class="w-5 h-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" /></svg>
                                    Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/layouts/admin.blade.php ENDPATH**/ ?>