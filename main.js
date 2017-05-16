// Console will print the message
console.log('Server running at http://127.0.0.1:8081/');

// Call node-cron and require package
var cron = require('node-cron');
var request = require('request');

// Change schedule to desired time you want the script to run. It's currently set to run every 12 hours
var task = cron.schedule('* * 23 * * *', function() {

	// Change URL to the desired URL of your RSS feed
	request("http://worksite/web/site/rss");
  	console.log('Late update: ' + new Date());
});
