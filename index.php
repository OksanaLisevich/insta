<?php

require("../vendor/autoload.php");

$instagram = new \Instagram\Instagram();

try {

	 //Set the Proxy and Port
    $instagram->setProxy('Hb7xHn:AfBew2@213.166.75.107:9024');

    //Enable/Disable SSL Verification (Testing with Charles Proxy etc)
    $instagram->setVerifyPeer(false);


    //Login
    $instagram->login('petrov52122', '05saa#1983');


//var_dump($instagram); exit;
    //Find User by Username
    $user = $instagram->getUserByUsername('ksenia417ksy');

    //Follow the User
    //$instagram->followUser($user);

    //Get TimelineFeed
    $timelineFeed = $instagram->getTimelineFeed();

    foreach($timelineFeed->getItems() as $timelineFeedItem){

        //User Object, (who posted this)
        $user = $timelineFeedItem->getUser();

        //Caption Object
        $caption = $timelineFeedItem->getCaption();

        //How many Likes?
        $likeCount = $timelineFeedItem->getLikeCount();

        //How many Comments?
        $commentCount = $timelineFeedItem->getCommentCount();

        //Get the Comments
        $comments = $timelineFeedItem->getComments();

        //Which Filter did they use?
        $filterType = $timelineFeedItem->getFilterType();

        //Grab a list of Images for this Post (different sizes)
        $images = $timelineFeedItem->getImageVersions2()->getCandidates();

        //Grab the URL of the first Photo in the list of Images for this Post
        $photoUrl = $images[0]->getUrl();

        echo sprintf("---------- Timeline Item ----------\n");
        echo sprintf("User: %s [%s]\n", $user->getFullName(), $user->getUsername());
       // echo sprintf("Caption: %s\n", $caption->getText());
        echo sprintf("Like Count: %s\n", $likeCount);
        echo sprintf("Comment Count: %s\n", $commentCount);
        echo sprintf("Filter Type: %s\n", $filterType);
        echo sprintf("Comments:\n", $commentCount);

        $mediaId = $timelineFeedItem->getId();
        var_dump($mediaId);
        //var_dump();
        //$likedMedia = $instagram->likeMedia($mediaId);
        //$newComment = $instagram->commentOnMedia($mediaId, 'HI!)) It\'s my own \"like\"-test');
        break;

    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}