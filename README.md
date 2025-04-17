# Taks Time Module

This Drupal 10 custom module displays the current time and location based on admin configuration.

![Screenshot from 2025-04-18 02-14-12](https://github.com/user-attachments/assets/3757153e-a167-407c-ab70-abcc373d62a2)


## Features

- Admin configuration form to set:
  - Country
  - City
  - Timezone (predefined options)
- Custom service to get current time based on selected timezone
- Block plugin that renders time and location
- Twig template for clean display
- Fully cacheable with dynamic output

## Time Format

Example output:  
`Monday, 16 April 2025 - 11:15 AM`

## Configuration Path

`/admin/config/system/taks-time`

## Default Timezones

- America/Chicago
- America/New_York
- Asia/Tokyo
- Asia/Dubai
- Asia/Kolkata
- Europe/Amsterdam
- Europe/Oslo
- Europe/London

## How to Install

1. Place the module in `web/modules/custom/`
2. Enable the module via the admin UI or Drush:
   ```bash
   drush en taks_time
3. Go to:

    Admin > Configuration > System > Taks Time
    and set the country, city, and timezone.

4. Then go to:

    Admin > Structure > Block Layout
    Click "Place block" in your desired region, search for "Taks Time Block", and place it.

5. ⚠️ While placing the block, uncheck the "Display title" option to hide the default title and clear cache.

