<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Road Segment Data Display</title>
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;family=Noto+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script id="tailwind-config">
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            "primary": "#10b981", // Emerald 500 for a fresh look
            "primary-dark": "#059669",
            "primary-light": "#ecfdf5",
            "background-base": "#f8fafc", // Very light slate/white
            "surface": "#ffffff",
            "surface-highlight": "#f1f5f9",
            "border-light": "#e2e8f0",
            "text-main": "#1e293b", // Slate 800
            "text-muted": "#64748b", // Slate 500
          },
          fontFamily: {
            "display": ["Spline Sans", "sans-serif"],
            "body": ["Spline Sans", "sans-serif"]
          },
          borderRadius: {
            "DEFAULT": "0.75rem",
            "lg": "1rem",
            "xl": "1.5rem",
            "2xl": "2rem",
            "full": "9999px"
          },
          boxShadow: {
            'soft': '0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02)',
            'card': '0 0 0 1px rgba(226, 232, 240, 1), 0 2px 4px rgba(0,0,0,0.02)',
          }
        },
      },
    }
  </script>
  <style>
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>

<body class="bg-background-base text-text-main font-display min-h-screen flex flex-col overflow-x-hidden antialiased selection:bg-primary selection:text-white">
  <header class="sticky top-0 z-50 w-full border-b border-border-light bg-surface/80 backdrop-blur-md">
    <div class="px-6 lg:px-10 py-4 flex items-center justify-between">
      <div class="flex items-center gap-8">
        <div class="flex items-center gap-2 text-primary">
          <div class="bg-primary/10 p-1.5 rounded-lg">
            <span class="material-symbols-outlined text-3xl">add_road</span>
          </div>
          <h2 class="text-text-main text-xl font-bold tracking-tight">PUPR</h2>
        </div>
        <nav class="hidden md:flex items-center gap-8 pl-4">
          @php
            $currentRoute = Route::currentRouteName();
          @endphp
          <a class="text-sm font-semibold px-3 py-1.5 rounded-full transition-colors {{ $currentRoute === 'landingpage' ? 'text-primary bg-primary-light' : 'text-text-muted hover:text-primary' }}" href="/">Beranda</a>
          <a class="text-sm font-medium px-3 py-1.5 rounded-full transition-colors {{ $currentRoute === 'jembatan' ? 'text-primary bg-primary-light' : 'text-text-muted hover:text-primary' }}" href="{{ route('jembatan') }}">Jembatan</a>
          <a class="text-sm font-medium px-3 py-1.5 rounded-full transition-colors href="#">Reports</a>
          <a class="text-sm font-medium px-3 py-1.5 rounded-full transition-colors href="#">Settings</a>
        </nav>
      </div>
      <div class="flex items-center gap-6">
        <div class="hidden lg:flex items-center bg-surface-highlight border border-transparent hover:border-border-light rounded-full px-4 h-10 w-64 focus-within:border-primary focus-within:bg-white focus-within:shadow-soft transition-all duration-300">
          <span class="material-symbols-outlined text-text-muted text-[20px]">search</span>
          <input class="bg-transparent border-none text-sm text-text-main placeholder-text-muted focus:ring-0 w-full h-full" placeholder="Search ID or Region..." type="text" />
        </div>
        <button class="relative text-text-muted hover:text-primary transition-colors p-2 hover:bg-surface-highlight rounded-full">
          <span class="material-symbols-outlined">notifications</span>
          <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-surface"></span>
        </button>
        <div class="h-10 w-10 rounded-full bg-cover bg-center border-2 border-white shadow-sm cursor-pointer ring-2 ring-transparent hover:ring-primary/20 transition-all" data-alt="User profile avatar image showing a person smiling" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuArmfQJt5-eRKu2lLRoPSNFpn7bKtWEJu2Rj8swMobdAZzEQkmcLKZC_e902-tuC02hoVDK1MxlpbCE6VCKOu0h3BABSPN5xJKuHRARwTgsekID464BUt9gdzDyyUG8wSFqA7aurinMTcjk8EM4296SZa2P8oQqdj93WbQEyONL1F4dQvgZklrrdCFIyHrYjVc9yIlsipseMMUuiePRSpvJFmaucy-0aSA7ZK-5T07E97-FQqocJX2bjPRiBYH1LG1Ygx0q4jw9BxqO");'>
        </div>
      </div>
    </div>
  </header>
  <main class="flex-1 flex justify-center py-8 px-4 lg:px-8">
    <div class="w-full max-w-[1400px] flex flex-col gap-8">
      @yield('content')
    </div>
  </main>
</body>

</html>