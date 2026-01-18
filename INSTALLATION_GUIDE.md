# Global News - Installation & Setup Guide

## 📋 Overview

Global News is a production-ready WordPress news theme inspired by BBC News, complete with breaking news ticker, dark mode, social media integration, and 50 viral demo articles. This guide covers installation and configuration.

---

## 🚀 Installation Steps

### 1. **Install WordPress**

Ensure you have WordPress 5.9+ installed with PHP 8.0+ support.

### 2. **Install the Global News Theme**

1. Log in to WordPress Admin
2. Go to **Appearance → Themes → Add New**
3. Click **Upload Theme**
4. Select `global-news-theme.zip`
5. Click **Install Now**
6. Click **Activate** to activate the theme

### 3. **Install the Demo Content Plugin**

1. Go to **Plugins → Add New → Upload Plugin**
2. Select `global-news-demo-importer.zip`
3. Click **Install Now**
4. Click **Activate**

### 4. **Import Demo Content**

1. Go to **Appearance → Import Demo Content**
2. Click **Import Demo Content**
3. Wait for 50 articles to be imported (includes categories and breaking news tags)

---

## ⚙️ Configuration

### **Basic Settings**

1. **Site Title & Tagline**
   - Go to **Settings → General**
   - Site Title: `Global News`
   - Tagline: `Trusted News From Around the World`

2. **Permalink Settings**
   - Go to **Settings → Permalinks**
   - Select: **Post name**
   - This is important for SEO-friendly URLs

3. **Reading Settings**
   - Blog posts per page: **9** (recommended)
   - This matches the grid layout

### **Create Essential Pages**

Create these pages for a complete site:

**1. Home Page**
- Content: Keep minimal, theme handles layout
- Publish and set as frontpage in **Settings → Reading → Static page**

**2. About Us**
- Add your organization's information
- Include mission, vision, and contact info

**3. Contact Us**
- Use WordPress contact form plugin or similar
- Recommended: **WPForms** or **Contact Form 7**

**4. Privacy Policy**
- Add your privacy policy
- Navigate to **Settings → Privacy**

---

## 🎨 Branding & Customization

### **Logo**
1. Go to **Appearance → Customize**
2. Click **Site Identity**
3. Upload logo: Use `assets/images/logo.svg`
4. Set logo dimensions: **160px × auto**

### **Colors**
The theme uses these brand colors (customizable in style.css):
- **Primary**: Black (#000000)
- **Secondary**: White (#FFFFFF)
- **Accent**: News Red (#C40000)

To change colors, edit:
```
:root {
    --color-primary: #000000;
    --color-secondary: #FFFFFF;
    --color-accent: #C40000;
}
```

### **Menus**
1. Go to **Appearance → Menus**
2. Create a menu called "Main Menu"
3. Add categories and pages to the menu
4. Assign to **Primary Menu** location
5. Enable "Display location" checkbox

### **Featured Content**

The theme displays:
- **Hero Section**: Automatically shows latest post
- **Category Sections**: World, Africa, Business, Technology
- **Breaking News Ticker**: Shows posts marked as "Breaking News"

---

## 📝 Creating & Managing Posts

### **Write a News Article**

1. Go to **Posts → Add New**
2. Fill in:
   - **Title**: Click-worthy headline (60-75 characters)
   - **Content**: Well-structured article (300-600 words)
   - **Excerpt**: 150-160 characters (displays in listings)
   - **Category**: Select relevant category
   - **Tags**: Add 3-5 relevant tags
   - **Featured Image**: 1200×600px recommended

3. **Mark as Breaking News** (optional):
   - Scroll to **Post Meta** section
   - Check "Is Breaking News"
   - This shows in ticker and with badge

4. **SEO Optimization**:
   - Use Yoast SEO or Rank Math plugin
   - Focus keyword in title, content, and meta description
   - Readability score: Aim for "Good" or higher

### **Post Tips for Viral Content**

✓ Use emotional headlines  
✓ Include subheadings every 100-150 words  
✓ Break into short paragraphs (2-3 sentences)  
✓ Add bold text for emphasis  
✓ Use bullet lists when appropriate  
✓ Include high-quality featured image  
✓ Link to related articles  
✓ Add schema markup (theme does this automatically)  

---

## 🌙 Dark Mode

The theme includes automatic dark mode with:
- **Toggle button** in header
- **User preference saved** to browser
- **System preference detection** for first-time visitors

Users can toggle dark/light mode using the 🌙/☀️ button in header.

---

## 🌐 Social Media Integration

### **Configure Social Links**

Edit in **header.php** and **footer.php**:

```php
// Facebook
<a href="https://www.facebook.com/share/1DAqbgWgGS/">Facebook</a>

// WhatsApp
<a href="https://wa.me/255717007449">WhatsApp</a>

// TikTok
<a href="https://www.tiktok.com/@music.lovers395">TikTok</a>

// Email
<a href="mailto:lingendea@gmail.com">Email</a>
```

Replace links with your social media accounts.

### **Share Buttons**

The theme includes share buttons on each article:
- Facebook
- Twitter/X
- WhatsApp
- Email

Users can click to share articles on their preferred platforms.

### **Floating WhatsApp Button**

A floating WhatsApp button appears in bottom-right corner. Edit in **footer.php** to customize the phone number and message.

---

## 💰 Monetization Setup

### **Google AdSense**

1. Apply for Google AdSense
2. Add AdSense code to **header.php** in `<head>` section
3. Recommended ad placements:
   - Above featured section
   - Inside post sidebar
   - Below post content
   - Footer area

### **Ad Placement Hooks**

The theme is ready for ads. Add these to templates:
```php
// Header ads
<?php echo get_option( 'global_news_header_ad' ); ?>

// Sidebar ads
<?php echo get_option( 'global_news_sidebar_ad' ); ?>

// Article ads
<?php echo get_option( 'global_news_article_ad' ); ?>
```

---

## 📱 Mobile & Responsive

The theme is fully responsive and optimized for:
- **Smartphones** (320px+)
- **Tablets** (768px+)
- **Desktops** (1024px+)

Test on multiple devices using:
- Chrome DevTools
- Firefox Developer Tools
- Real device testing

---

## 🔍 SEO Optimization

### **Built-in SEO Features**

✓ Schema.org NewsArticle markup  
✓ Open Graph & Twitter Card meta tags  
✓ Lazy-loaded images  
✓ Mobile-first responsive design  
✓ XML sitemap support (via plugin)  
✓ Proper heading hierarchy  
✓ Alt text support for images  

### **Recommended SEO Plugins**

- **Yoast SEO** (free version)
- **Rank Math** (free version)
- **Google Site Kit**

### **SEO Best Practices**

1. **Keywords**: Research and use 2-3 per article
2. **Headlines**: Keep 60-75 characters, include keyword
3. **Meta Description**: 155-160 characters, compelling
4. **Internal Linking**: Link 3-5 related articles
5. **Images**: Optimize size, add descriptive alt text
6. **Speed**: Optimize images, use caching plugin

---

## 🛡️ Security

### **Security Recommendations**

1. **Keep WordPress updated** regularly
2. **Use strong passwords** for all accounts
3. **Install security plugin**: Wordfence or Sucuri
4. **Backup regularly**: Updraft Plus or similar
5. **Disable file editing**: Add to wp-config.php:
   ```php
   define( 'DISALLOW_FILE_EDIT', true );
   ```

### **Performance**

1. **Caching Plugin**: WP Super Cache or W3 Total Cache
2. **Image Optimization**: Smush or ShortPixel
3. **Lazy Loading**: Already enabled in theme
4. **CDN**: Consider Cloudflare or similar

---

## 👥 User Management

### **Create User Roles**

The theme supports:
- **Admin**: Full access
- **Editor**: Create/edit all posts
- **Author**: Create/edit own posts
- **Subscriber**: Read-only, optional newsletter signup

### **Add Users**

1. Go to **Users → Add New**
2. Enter email and username
3. Set role (Editor, Author, or Subscriber)
4. Send invitation

---

## 🎯 Opera News Hub Optimization

For best Opera News Hub performance:

✓ **Original Content**: All articles must be original  
✓ **Clear Author**: Always include author name  
✓ **Publish Date**: Always visible on articles  
✓ **No Misleading Content**: Honest, accurate headlines  
✓ **Clean Layout**: Not ad-heavy (max 2-3 ads)  
✓ **Mobile Friendly**: Theme is fully responsive  
✓ **Category Structure**: Well-organized categories  
✓ **High CTR Headlines**: But must match content quality  

---

## 📊 Analytics

### **Add Google Analytics**

1. Create Google Analytics account
2. Get Tracking ID
3. Install **Google Site Kit** plugin
4. Follow setup wizard
5. Track visitors, behavior, and conversions

### **Monitor Performance**

Key metrics to track:
- **Page Views**: Overall traffic
- **Bounce Rate**: User engagement
- **Time on Page**: Content quality
- **Click-through Rate**: Headline effectiveness
- **Conversions**: Newsletter signups, shares

---

## 🐛 Troubleshooting

### **Theme Not Showing**

- Clear WordPress cache
- Check permalink settings
- Verify homepage is set to static page
- Disable conflicting plugins

### **Broken Layout**

- Disable child themes
- Check for CSS conflicts
- Verify all theme files uploaded
- Test in Firefox/Chrome

### **Missing Images**

- Check featured image sizes
- Verify uploads folder permissions
- Optimize images before upload
- Use correct image format (JPG/PNG)

### **Slow Performance**

- Enable caching plugin
- Optimize images
- Reduce plugins
- Upgrade hosting if needed

---

## 🆘 Support & Resources

### **Need Help?**

1. **Documentation**: Check theme docs
2. **WordPress Forum**: wordpress.org/support
3. **Stack Exchange**: wordpress.stackexchange.com
4. **Community**: Join WordPress communities

### **Useful Plugins**

- WPForms (Contact Forms)
- WP Super Cache (Performance)
- Yoast SEO (SEO)
- Wordfence (Security)
- Updraft Plus (Backup)
- Smush (Image Optimization)

---

## 📋 Checklist Before Going Live

- [ ] Site title and tagline set
- [ ] Logo uploaded
- [ ] Main menu created and assigned
- [ ] About, Contact, Privacy Policy pages created
- [ ] Featured content added (at least 10 articles)
- [ ] Categories populated with articles
- [ ] Dark mode tested
- [ ] Mobile responsiveness verified
- [ ] SEO plugins configured
- [ ] Google Analytics installed
- [ ] Social media links updated
- [ ] SSL certificate installed (https://)
- [ ] Caching plugin enabled
- [ ] Backup created
- [ ] Security settings configured

---

## 🎉 You're Ready!

Your Global News site is now ready for publishing. Focus on:
1. **Creating quality content**
2. **Building audience**
3. **Promoting on social media**
4. **Optimizing for SEO**
5. **Engaging with readers**

Good luck! 🚀

---

**Version**: 1.0.0  
**Last Updated**: January 2026  
**Compatibility**: WordPress 5.9+, PHP 8.0+
