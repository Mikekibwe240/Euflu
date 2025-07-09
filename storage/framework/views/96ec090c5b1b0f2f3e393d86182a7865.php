
<!DOCTYPE html>
<html lang="fr" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: false }"
      x-init="if(localStorage.getItem('darkMode') === null){localStorage.setItem('darkMode', false)}; $watch('darkMode', value => { if(value){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}}); if(darkMode){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin EUFLU'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="min-h-screen bg-bl-dark text-white font-bundesliga transition-colors duration-300">
    <div class="flex h-screen flex-col md:flex-row">
        <!-- Sidebar -->
        <aside class="w-64 max-w-full md:w-64 bg-[#23272a] shadow-lg flex flex-col fixed md:static z-40 h-screen md:h-auto md:min-h-screen top-0 left-0 transition-transform duration-300 md:translate-x-0" :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            <div class="p-6 text-2xl font-extrabold text-bl-accent tracking-tight border-b border-bl-border flex justify-between items-center md:block">
                <span class="tracking-widest">EUFLU</span>
                <button class="md:hidden text-2xl" @click="sidebarOpen = false">&times;</button>
            </div>
            <nav class="flex-1 mt-6 space-y-2 px-4">
                <a href="/admin" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-white">Dashboard</a>
                <a href="/admin/saisons" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-white">Saisons</a>
                <a href="/admin/equipes" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-white">Équipes</a>
                <a href="/admin/joueurs" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-white">Joueurs</a>
                <a href="/admin/transferts" class="block py-2.5 px-4 rounded-lg hover:bg-green-900/30 font-medium transition text-green-400">Transferts</a>
                <a href="/admin/matchs" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-white">Matchs</a>
                <a href="/admin/articles" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-white">Articles</a>
                <a href="/admin/reglements" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-white">Règlements</a>
                <a href="/admin/users" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-white">Utilisateurs</a>
                <a href="/admin/classement" class="block py-2.5 px-4 rounded-lg hover:bg-bl-accent/10 font-medium transition text-bl-accent">Classement équipes</a>
            </nav>
        </aside>
        <div class="flex-1 flex flex-col md:ml-64 pt-24">
            <!-- Header -->
            <header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between bg-[#23272a] shadow px-4 md:px-8 h-24 border-b border-bl-border w-full" style="height:96px;">
                <div class="flex items-center gap-2">
                    <button class="md:hidden text-2xl mr-2" @click="sidebarOpen = true">&#9776;</button>
                    <div class="text-lg font-semibold text-white tracking-widest"><?php echo $__env->yieldContent('header', 'Tableau de bord'); ?></div>
                </div>
                <div class="flex items-center gap-4">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded bg-bl-card text-bl-accent transition">
                        <span x-show="!darkMode">🌙</span>
                        <span x-show="darkMode">☀️</span>
                    </button>
                    <?php if(auth()->guard()->check()): ?>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-bl-accent text-white font-bold hover:bg-bl-dark border border-bl-accent transition focus:outline-none">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-bl-card border border-bl-border rounded-lg shadow-lg z-50">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-b-lg transition">Se déconnecter</button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </header>
            <main class="flex-1 p-4 md:p-8 bg-bl-dark min-h-[calc(100vh-96px)] pt-28 overflow-y-auto">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/layouts/admin.blade.php ENDPATH**/ ?>