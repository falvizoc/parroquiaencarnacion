User-agent: *
Allow: /

# Disallow admin panel
Disallow: /admin
Disallow: /admin/*

# Disallow Livewire endpoints
Disallow: /livewire/*

# Sitemap
Sitemap: {{ url('/sitemap.xml') }}
