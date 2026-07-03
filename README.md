# My Plugin

A WordPress plugin starter template with CPT, settings page, and frontend assets.

## Features

- Custom Post Type registration (`myplugin_item`) with meta box and admin columns
- Settings page with 8 option fields of various types (checkbox, text, number, select, color, textarea)
- Frontend CSS/JS enqueuing with debug mode
- Frontend rendering via `wp_footer` hook
- Uninstall handler with configurable data cleanup
- PHP 8.0+ with strict types, namespaces, and modern patterns
- Full WordPress security: nonces, sanitization, escaping, capability checks

## File Structure

```
my-plugin/
├── my-plugin.php              # Main plugin bootstrap
├── uninstall.php              # Cleanup on uninstall
├── readme.txt                 # WordPress.org readme
├── assets/
│   ├── css/plugin.css         # Frontend styles
│   └── js/plugin.js           # Frontend JavaScript
├── includes/
│   ├── class-cpt.php          # CPT registration
│   ├── class-assets.php       # Asset enqueuing
│   ├── class-renderer.php     # Frontend rendering
│   └── class-admin.php        # Admin settings page
└── templates/
    ├── frontend-template.php  # Frontend output template
    ├── option-checkbox.php    # Checkbox field template
    ├── option-select.php      # Select field template
    └── option-text.php        # Text/number/color/textarea template
```

## Usage

1. Activate the plugin
2. Create items under **My Plugin → Add New**
3. Reference items using `#myplugin_item{ID}` (e.g. `#myplugin_item1`)
4. Configure settings under **My Plugin → Settings**

## Requirements

- WordPress 6.0+
- PHP 8.0+
