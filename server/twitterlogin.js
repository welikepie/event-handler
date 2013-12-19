var ntwitter = require("ntwitter");

var twit = new ntwitter({
  consumer_key: 'hIaiALrvvN0JmqUvq8AHA',
  consumer_secret: 'wbZC7636LRLnj78mOcPNfLAILomRKJT5TRmmZMr4hgA',/*
  access_token_key: 'keys',
  access_token_secret: 'go here'*/
  access_token_key: '213861940-vrYZIWVhoDiGxnwE63HwKPQJIPFM5sRQ6Iml1eMn',
access_token_secret: 'do4GCVkmoOGmil7Tskgk0iV0JObXKrzdUZhkPLTj2EeVI'
});

    twit.verifyCredentials(function (err, data) {
      console.log("Verifying Credentials...");
      if(err)
        console.log("Verification failed : " + err);
    })
    .getHomeTimeline('',
      function (err, data) {
        console.log("Timeline Data Returned...");
        // console.log(data);

        console.log("Exiting Controller.");
        console.log(JSON.stringify(data));
      });
