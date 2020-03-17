<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
      <loc>{{ env('APP_URL') }}</loc>
      <changefreq>daily</changefreq>
      <priority>1</priority>
  </url>
  <url>
      <loc>{{ env('APP_URL') }}/koncerter</loc>
      <changefreq>daily</changefreq>
      <priority>1</priority>
  </url>
  <url>
      <loc>{{ env('APP_URL') }}/om-bandmate</loc>
      <changefreq>monthly</changefreq>
      <priority>0.4</priority>
  </url>
  <url>
      <loc>{{ env('APP_URL') }}/privatlivspolitik</loc>
      <changefreq>monthly</changefreq>
      <priority>0.4</priority>
  </url>
</urlset>
