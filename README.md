# YAP - Yet Another Popups

A simple WordPress plugin for creating and managing popup windows on your site.

## Description

This plugin provides a clean, lightweight solution for creating popups in WordPress. It uses a custom post type to manage popups and displays them in the site footer. Popups can be triggered via anchor links or JavaScript.

## Features

- Create unlimited popups via WordPress admin
- Custom post type for easy management
- Support for shortcodes (Contact Form 7, etc.)
- Responsive design
- Click outside or × button to close
- URL hash-based triggering
- Scroll lock when popup is open

## Installation

1. Upload the `yap-yet-another-popups` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to **Popups → Add New Popup** to create your first popup

## Usage

### Creating a Popup

1. In WordPress admin, go to **Popups → Add New Popup**
2. Enter a title (displayed as popup heading)
3. Add content in the editor (supports HTML and shortcodes)
4. Click **Publish**
5. Copy the **Popup Slug** from the meta box (e.g., `#yapopup123`)

### Opening a Popup

Add a link with the href equal to the popup slug:

```html
<a href="#yapopup123">Open Popup</a>
```

### Examples

#### Simple Text Popup

1. Create popup with title "Information"
2. Add text content
3. Publish and get slug (e.g., `#yapopup42`)
4. Add link: `<a href="#yapopup42">Learn More</a>`

#### Popup with Contact Form 7

1. Create popup with title "Contact Us"
2. Add shortcode: `[contact-form-7 id="123"]`
3. Publish and use slug in link

#### Open Popup via JavaScript

```javascript
// Vanilla JavaScript
document.querySelector('a[href="#yapopup42"]').click();

// jQuery
jQuery('a[href="#yapopup42"]').trigger('click');
```

## Plugin Settings

Go to **Popups → Settings** for:
- Usage instructions
- Debug information
- List of all published popups

## Customization

### CSS Classes

| Class | Description |
|-------|-------------|
| `.yapopups-popup` | Popup overlay container |
| `.yapopups-popup.active` | Active (visible) popup |
| `.yapopups-popup__body` | Popup content box |
| `.yapopups-popup__close` | Close button (×) |
| `.yapopups-popup__title` | Popup title |
| `.yapopups-popup__content` | Popup content area |
| `body.yapopups-popup-open` | Added to body when popup is open |

### Custom CSS

Override styles in your theme's stylesheet:

```css
.yapopups-popup__body {
    max-width: 600px; /* Change max width */
}

.yapopups-popup__title {
    color: #your-color; /* Change title color */
}
```

## Technical Details

- **Custom Post Type**: `popup`
- **Footer Hook Priority**: 999
- **Z-Index**: 9999
- **Dependencies**: jQuery

## Files Structure

```
yap-yet-another-popups/
├── yap-yet-another-popups.php       # Main plugin file
├── includes/
│   ├── class-popup-cpt.php          # Custom post type registration
│   ├── class-popup-assets.php       # Assets enqueueing
│   ├── class-popup-renderer.php     # Popup rendering logic
│   └── class-popup-admin.php        # Admin settings page
├── assets/
│   ├── css/
│   │   └── popups.css               # Popup styles
│   └── js/
│       └── popups.js                # Popup functionality
├── templates/
│   └── popup-template.php           # Popup HTML template
└── uninstall.php                    # Cleanup on uninstall
```

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- jQuery (included with WordPress)

## License

GPL v2 or later

## Support

For support and feature requests, please visit the plugin repository.
