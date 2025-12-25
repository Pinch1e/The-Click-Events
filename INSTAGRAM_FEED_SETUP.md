# Instagram Feed Setup Guide

## Overview
Your pricing page now has a dynamic Instagram feed system that can display real Instagram posts. The system is designed with fallback options to ensure it always works.

## Configuration Options

### Option 1: SnapWidget (Easiest - Recommended)
1. Go to [SnapWidget.com](https://snapwidget.com/)
2. Sign up for a free account
3. Connect your Instagram account (@the_click_events)
4. Generate a widget for 4 posts
5. Copy your SnapWidget ID
6. Update the configuration in `assets/js/instagram-feed.js`:

```javascript
const INSTAGRAM_CONFIG = {
    useApi: false,
    useWidget: true,
    widgetType: 'snapwidget',
    snapwidgetId: 'YOUR_ACTUAL_SNAPWIDGET_ID', // Replace this
    // ... rest of config
};
```

### Option 2: Instagram Basic Display API (More Complex)
1. Create a Facebook Developer account
2. Create a new app and add Instagram Basic Display
3. Get your Instagram User ID and Access Token
4. Update the configuration:

```javascript
const INSTAGRAM_CONFIG = {
    useApi: true,
    apiEndpoint: 'instagram-feed.php',
    accessToken: 'YOUR_INSTAGRAM_ACCESS_TOKEN',
    userId: 'YOUR_INSTAGRAM_USER_ID',
    // ... rest of config
};
```

### Option 3: Manual Updates (Current Fallback)
The system currently shows your static images with proper links to your Instagram profile. This works immediately but requires manual updates to change images.

## Current Status
- ✅ Static images are displayed with correct Instagram links
- ✅ Fallback system is in place
- ✅ Ready for configuration with real Instagram data
- ✅ Responsive design maintained

## Features Included
- **Fallback System**: If API/widget fails, shows static images
- **Responsive Design**: Works on all devices
- **Proper Links**: All images link to your Instagram profile
- **Loading States**: Smooth user experience
- **Error Handling**: Graceful degradation

## Files Modified
1. `pricing.html` - Updated Instagram feed section
2. `assets/js/instagram-feed.js` - Created dynamic feed manager
3. `instagram-feed.php` - Created API endpoint (for future use)

## Next Steps
1. Choose one of the configuration options above
2. Update the configuration in `assets/js/instagram-feed.js`
3. Test the functionality
4. The feed will automatically update with real Instagram posts

## Testing
Open `pricing.html` in your browser to see the Instagram feed section in action. Currently, it shows the fallback static images with proper Instagram links.
