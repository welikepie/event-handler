<?php
    //API Key - see http://admin.mailchimp.com/account/api
    $apikey = '9e2f795643d9ebb639d3a0e395c1f138-us2';
    
    // A List Id to run examples against. use lists() to view all
    // Also, login to MC account, go to List, then List Tools, and look for the List ID entry
    $listId = '799f4da2e1';
    
    // A Campaign Id to run examples against. use campaigns() to view all
    $campaignId = 'YOUR MAILCHIMP CAMPAIGN ID - see campaigns() method';

    //some email addresses used in the examples:
    $my_email = 'INVALID@example.org';
    $boss_man_email = 'INVALID@example.com';

    //just used in xml-rpc examples
    $apiUrl = 'http://us2.api.mailchimp.com/1.3/';
    
?>
