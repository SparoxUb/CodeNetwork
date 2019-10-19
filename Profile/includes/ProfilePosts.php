<?php
$post = $mysqli->query("SELECT * FROM posts WHERE username='$username' ORDER BY postingDate desc;");
while ($row = $post->fetch_assoc()) {
  if (empty($row['postRef'])) { //posttype empty means displaying post for its owner 

    echo '
            <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-2" id="p' . $row['id'] . '">
              <div class="tweetEntry ">
  
                <div class="tweetEntry-content"  id="Con' . $row['id'] . '">
    
                  <a class="tweetEntry-account-group" href="./">
                      <img class="tweetEntry-avatar" src="./Avatars/' . $username . '.' . $EXT . '">
                      
                      <strong class="tweetEntry-fullname">
                      ' . $Fname . ' ' . $Lname . '
                      </strong>
                      
                      <span class="tweetEntry-username">
                        @<b>' . $username . '</b>
                      </span>
                  </a>
                  <a class="tweetEntry-account-group" href="../posts/?post=' . $row['id'] . '">
                    <span class="tweetEntry-timestamp ml-1"> ' . $row['postingDate'] . '</span>
                  </a>

                  <span style="cursor:pointer;left:78%;position:sticky;" onclick="del(' . "'" . $row['id'] . "'" . ')"> <i class="fas fa-trash-alt ml-4 text-danger"></i> </span>
                  <span style="cursor:pointer;left:38%;position:relative;top:15%;"> <a href="./PostEdit.php?post=' . $row['id'] . '"> <i class="fas fa-pen ml-4 text-info"></i> </a></span>
                  <div class="tweetEntry-text-container mt-2">
                  ' . $row['Post'] . '  
                  </div>
                  ';
    if (!empty($row['codeID'])) {
      $CODEID = $row['codeID'];
      $getCodeInfos = $mysqli->query("SELECT * From codes WHERE id='$CODEID';");
      $getCodeInfos = $getCodeInfos->fetch_assoc();
      $codeURL = "../Playground/" . $getCodeInfos['langType'] . "/index.php?id=" . $CODEID;

      if (!empty($getCodeInfos['id']))
        echo '
                    <div class="text-center"> 
                    <p><i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i> <a href="' . $codeURL . '" target="_blank"> <span>' . $getCodeInfos['name'] . '</span></a> <i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i></p>
                    </div>
                    ';
    }
    //if there is an image included
    $imgid = explode('.', $row['img']);
    if (!empty($row['img'])) {
      echo '
                <div class="optionalMedia text-center mr-5">
                  <img id="img' . $imgid[0] . '" onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" class="optionalMedia-img myImg col-12" src="../sharedPics/' . $row['img'] . '">
                </div>';
    }
    //check if is already liked poste
    $PID = $row['id'];
    $liked = $mysqli->query("SELECT username FROM likes WHERE PostID='$PID' and username='$username';");
    $liked = $liked->fetch_assoc();
    $liked = $liked['username'];
    if ($liked == $username) { //liked
      echo '</div>
                <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
                <ul class="row col-8 mx-auto" style="list-style: none;">
                <li class="col d-inline">
                <button class="btn mr-4" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #ff3333;"></i></button>';
    } else {
      echo '</div>
                <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
                <ul class="row col-8 mx-auto" style="list-style: none;">
                <li class="col d-inline">
                <button class="btn mr-5" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #C2C5CC;"></i></button>';
    }
    /// Ajax Syncing Likes with database into index.php


    //printing nummber of likes if not null
    $likes = $mysqli->query("SELECT count(*) AS num FROM likes WHERE PostID='$PID';");
    $likes = $likes->fetch_assoc();
    $likes = $likes['num'];
    if ($likes == 0) {
      echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '"></span></li>';
    } else {
      echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '">' . $likes . '</span></li>';
    }
    $comments = $mysqli->query("SELECT count(*) AS num FROM comments WHERE PostID='$PID';");
    $comments = $comments->fetch_assoc();
    $comments = $comments['num'];
    echo '
                 <li class="col d-inline"> <i class="fa fa-comment d-inline-block pt-1 active" style="width: 80px;cursor:pointer;" onclick="Comment(' . "'" . $PID . "'" . ')"></i>';
    if ($comments > 0) {
      echo '<span class="text-info d-inline-block ml-n4 mr-2" >' . $comments . '</span>';
    }
    echo '
    </li><li class=" col d-inline"> <i class="fa fa-share d-inline-block pt-1" style="width: 80px;cursor: pointer;" onclick="share(' . "'" . $PID . "'" . ')"></i></li></ul>
                </div>
  
              </div>
            </div>
            ';
  } else {
    //posting the post for a non-owner shared :/

    echo '
    <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-2" id="p' . $row['id'] . '">
      <div class="tweetEntry ">

        <div class="tweetEntry-content"  id="Con' . $row['id'] . '">

          <a class="tweetEntry-account-group" href="./">
              <img class="tweetEntry-avatar" src="./Avatars/' . $username . '.' . $EXT . '">
              
              <strong class="tweetEntry-fullname">
              ' . $Fname . ' ' . $Lname . '
              </strong>
              
              <span class="tweetEntry-username">
                @<b>' . $username . '</b>
              </span>
          </a>
          <a class="tweetEntry-account-group" href="../posts/?post=' . $row['id'] . '">
            <span class="tweetEntry-timestamp ml-1"> ' . $row['postingDate'] . '</span>
          </a>

          <span style="cursor:pointer;left:78%;position:absolute;" onclick="del(' . "'" . $row['id'] . "'" . ')"> <i class="fas fa-trash-alt ml-4 text-danger"></i> </span>
          <span style="cursor:pointer;left:73%;position:absolute;"> <a href="./PostEdit.php?post=' . $row['id'] . '"> <i class="fas fa-pen ml-4 text-info"></i> </a></span>
          <div class="tweetEntry-text-container mt-2 mb-2">
          ' . $row['Post'] . '  
          </div>
          ';


    echo '
        </div> 
          <div class="my-3 col-10 mx-auto border border-secondary rounded ">
            <div class="col-9 mx-auto px-1" style="max-width:90%;"> 
        ';
    /////Shared post start
    $SharedID = $row['postRef'];
    $getter = $mysqli->query("SELECT * FROM posts WHERE id='$SharedID' ;");
    $SharedPost = $getter->fetch_assoc();
    $OwnerUsername = $SharedPost['username'];
    $owner = $mysqli->query("SELECT Fname,Lname,avatarEXT FROM users WHERE Email in (SELECT Email FROM profiles WHERE username='$OwnerUsername') ;");
    $owner = $owner->fetch_assoc();

    if (empty($SharedPost['id'])) { /// if the shared post 's original is deleted
      echo '
      <div class="alert alert-danger btn-block text-center px-5 py-4 mb-n1 mt-n1  " role="alert">
        <strong> Post not found ! </strong>
      </div>
      ';
    } else {
      echo '
    <div class="tweetEntry-tweetHolder bg-light text-dark ml-n5 mr-2 mb-2" style="max-width:100%">
      <div class="tweetEntry ">

        <div class="tweetEntry-content" >

          <a class="tweetEntry-account-group" href="../members/?username=' . $OwnerUsername . '">
              <img class="tweetEntry-avatar" src="./Avatars/' . $OwnerUsername . '.' . $owner['avatarEXT'] . '" style="max-width:90%;">
              
              <strong class="tweetEntry-fullname">
              ' . $owner['Fname'] . ' ' . $owner['Lname'] . '
              </strong>
              
              <span class="tweetEntry-username">
                @<b>' . $OwnerUsername . '</b>
              </span>
          </a>
          <a class="tweetEntry-account-group" href="../posts/?post=' . $SharedID . '">
            <span class="tweetEntry-timestamp ml-1"> ' . $SharedPost['postingDate'] . '</span>
          </a>

         <div class="tweetEntry-text-container mt-2">
          ' . $SharedPost['Post'] . '  
          </div>
          ';

      if (!empty($SharedPost['codeID'])) {
        $CODEID = $SharedPost['codeID'];
        $getCodeInfos = $mysqli->query("SELECT * From codes WHERE id='$CODEID';");
        $getCodeInfos = $getCodeInfos->fetch_assoc();
        $codeURL = "../Playground/" . $getCodeInfos['langType'] . "/index.php?id=" . $CODEID;

        if (!empty($getCodeInfos['id']))
          echo '
                          <div class="text-center"> 
                          <p><i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i> <a href="' . $codeURL . '" target="_blank"> <span>' . $getCodeInfos['name'] . '</span></a> <i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i></p>
                          </div>
                          ';
      }
      echo '
                </div>
                ';
      //if there is an image included
      $imgid = explode('.', $SharedPost['img']);
      if (!empty($SharedPost['img'])) {
        echo '
                <div class="optionalMedia text-center mr-5">
                  <img id="img' . $imgid[0] . '" onclick="imgTrigger(' . "'img" . $imgid[0] . "'" . ')" class="optionalMedia-img myImg" src="../sharedPics/' . $SharedPost['img'] . '">
                </div>';
      }





      /////Shared post end

      echo '</div>
    </div>';
    }
    echo '
          </div> 
        </div> 
        ';
    //check if is already liked poste
    $PID = $row['id'];
    $liked = $mysqli->query("SELECT username FROM likes WHERE PostID='$PID' and username='$username';");
    $liked = $liked->fetch_assoc();
    $liked = $liked['username'];
    if ($liked == $username) { //liked
      echo '
        <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
        <ul class="row col-8 mx-auto" style="list-style: none;">
        <li class="col d-inline">
        <button class="btn mr-4" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #ff3333;"></i></button>';
    } else {
      echo '
        <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
        <ul class="row col-8 mx-auto" style="list-style: none;">
        <li class="col d-inline">
        <button class="btn mr-5" style="padding: 0px;height:34px;width:30px;" onclick="Like(' . $PID . ')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post' . $PID . '" style="width: 20px;color: #C2C5CC;"></i></button>';
    }
    /// Ajax Syncing Likes with database into index.php


    //printing nummber of likes if not null
    $likes = $mysqli->query("SELECT count(*) AS num FROM likes WHERE PostID='$PID';");
    $likes = $likes->fetch_assoc();
    $likes = $likes['num'];
    if ($likes == 0) {
      echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '"></span></li>';
    } else {
      echo '<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes' . $PID . '">' . $likes . '</span></li>';
    }
    $comments = $mysqli->query("SELECT count(*) AS num FROM comments WHERE PostID='$PID';");
    $comments = $comments->fetch_assoc();
    $comments = $comments['num'];
    echo '
         <li class="col d-inline"> <i class="fa fa-comment d-inline-block pt-1 active" style="width: 80px;cursor:pointer;" onclick="Comment(' . "'" . $PID . "'" . ')"></i>';
    if ($comments > 0) {
      echo '<span class="text-info d-inline-block ml-n4 mr-2" >' . $comments . '</span>';
    }
    echo '
</li><li class=" col d-inline"> <i class="fa fa-share d-inline-block pt-1" style="width: 80px;cursor: pointer;" onclick="share(' . "'" . $PID . "'" . ')"></i></li></ul>
        </div>

      </div>
    </div>
    ';
  }
}
