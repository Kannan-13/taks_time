(function($, Drupal, drupalSettings) {
  Drupal.behaviors.dynamicTime = {
    attach: function(context, settings) {
      $('.taks-time-block', context).once('dynamicTime').each(function() {
        const block = $(this);
        const timezone = drupalSettings.taksTime.timezone;
        const serverTimestamp = drupalSettings.taksTime.serverTime * 1000;
        
        const updateTime = function() {
          // Calculate offset between browser and server
          const now = new Date();
          const browserOffset = now.getTimezoneOffset() * 60000;
          
          // Create date in configured timezone
          const serverNow = new Date(serverTimestamp + (now - new Date(serverTimestamp)));
          const timeInZone = new Date(serverNow.toLocaleString('en-US', { timeZone: timezone }));
          
          // Format time (11:15 am)
          const timeStr = timeInZone.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
          }).toLowerCase();
          
          // Format date (Monday, 19 September 2022)
          const dayName = timeInZone.toLocaleDateString('en-US', { 
            weekday: 'long',
            timeZone: timezone
          });
          const dateNum = timeInZone.getDate();
          const monthName = timeInZone.toLocaleDateString('en-US', { 
            month: 'long',
            timeZone: timezone
          });
          const year = timeInZone.getFullYear();
          
          block.find('.time').text(timeStr);
          block.find('.date').text(`${dayName}, ${dateNum} ${monthName} ${year}`);
        };
        
        updateTime();
        setInterval(updateTime, 1000);
      });
    }
  };
})(jQuery, Drupal, drupalSettings);