var mysql = require('mysql');
module.exports = {
	mailchimp: {
		api:'',  // Change this to your mailchimp API Key
		list:[''] // Change this to your mailchimp list ID
		//UK/EU/US
	},
	mysql: {
	"connection": mysql.createConnection({
	  host:'',
	  user:'',
	  password:'',
	  database:'',
	  charset:'UTF8_GENERAL_CI'
	})
	}
};