var mysql = require('mysql');
module.exports = {
	eventbrite: {
		api:'', // Change this to your eventbrite API key
		user:'' // Change this to your eventbrite USER key.
		username:'' //Change this to your eventbrite account's email address.
	},
	mailchimp: {
		api:'',  // Change this to your mailchimp API Key
		list:[''] // Change this to your mailchimp list ID
		//UK/EU/US
	},
	mysql: {
	"connection": mysql.createConnection({
	  host:'',
	  user:'',
	  port:'',
	  password:'',
	  database:'',
	  charset:'UTF8_GENERAL_CI'
	})
	},
	verify:function(input){} //function used for verification of inputs from the user.
};
