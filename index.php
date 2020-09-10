<?php

require("/vendor/autoload.php");

$proxy = 'set valid proxy';
$searchedUsername = 'set username who are you looking for';
$username = 'username of request account owner';
$pass = 'password of request account owner';
$newComment = 'some comment to add to post';

$instagram = new \Instagram\Instagram();

try {

	 //Set the Proxy and Port
    $instagram->setProxy($proxy);

    //Enable/Disable SSL Verification (Testing with Charles Proxy etc)
    $instagram->setVerifyPeer(false);


    //Login
    $instagram->login($username, $pass);


    //Find User by Username
    $user = $instagram->getUserByUsername($searchedUsername);

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
        //$filterType = $timelineFeedItem->getFilterType();

        //Grab a list of Images for this Post (different sizes)
        //$images = $timelineFeedItem->getImageVersions2()->getCandidates();

        //Grab the URL of the first Photo in the list of Images for this Post
        //$photoUrl = $images[0]->getUrl();

        echo sprintf("---------- Timeline Item ----------<br>");
        echo sprintf("User: %s [%s]<br>", $user->getFullName(), $user->getUsername());
       // echo sprintf("Caption: %s\n", $caption->getText());
        echo sprintf("Like Count: %s<br>", $likeCount);
        echo sprintf("Comment Count: %s<br>", $commentCount);
        //echo sprintf("Filter Type: %s\n", $filterType);
        //echo sprintf("Comments:\n", $commentCount);

        $mediaId = $timelineFeedItem->getId();
        var_dump($mediaId);
        
        $likedMedia = $instagram->likeMedia($mediaId);
        
        $newComment = $instagram->commentOnMedia($mediaId, $newComment);
        break;

    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}