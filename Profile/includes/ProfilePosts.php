<?php
$post=$mysqli->query("SELECT * FROM posts WHERE username='$username' ORDER BY postingDate desc;");
while($row=$post->fetch_assoc()){
        if(empty($row['postType'])){//posttype empty means displaying post for his owner 
                   
            echo'
            <div class="tweetEntry-tweetHolder bg-light text-dark border border-secondary mb-2" id="p'.$row['id'].'">
              <div class="tweetEntry ">
  
                <div class="tweetEntry-content">
    
                  <a class="tweetEntry-account-group" href="./">
                      <img class="tweetEntry-avatar" src="./Avatars/'.$username.'.'.$EXT.'">
                      
                      <strong class="tweetEntry-fullname">
                      '.$Fname.' '.$Lname.'
                      </strong>
                      
                      <span class="tweetEntry-username">
                        @<b>'.$username.'</b>
                      </span>
                        <span class="tweetEntry-timestamp ml-1"> '.$row['postingDate'].'</span>
                  </a>

                  
                  <span style="cursor:pointer;left:78%;position:sticky;" onclick="del('."'".$row['id']."'".')"> <i class="fas fa-trash-alt ml-4 text-danger"></i> </span>
<<<<<<< HEAD
                  <span style="cursor:pointer;left:38%;position:relative;top:15%;"> <a href="./PostEdit.php?post='.$row['id'].'"> <i class="fas fa-pen ml-4 text-info"></i> </a></span>
=======
                  
>>>>>>> b574ce7fba86298a032549b6cd232b12b1567c76

                  <div class="tweetEntry-text-container mt-2">
                  '.$row['Post'].'  
                  </div>
                  ';
                  if(!empty ($row['codeID'])){
                    $CODEID=$row['codeID'];
                    $getCodeInfos=$mysqli->query("SELECT * From codes WHERE id='$CODEID';");
                    $getCodeInfos=$getCodeInfos->fetch_assoc();
                    $codeURL="../Playground/".$getCodeInfos['langType']."/index.php?id=".$CODEID;
                    
                    if(!empty($getCodeInfos['id']))
                    echo'
                    <div class="text-center"> 
                    <p><i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i> <a href="'.$codeURL.'" target="_blank"> <span>'.$getCodeInfos['name'].'</span></a> <i class="fa fa-code d-inline-block text-success pt-2" aria-hidden="true"></i></p>
                    </div>
                    ';}
                    echo'
                </div>
                ';
                //if there is an image included
                $imgid=explode('.',$row['img']);
                if(!empty ($row['img'])){echo'
                <div class="optionalMedia text-center mr-5">
                  <img id="img'.$imgid[0].'" onclick="imgTrigger('."'img".$imgid[0]."'".')" class="optionalMedia-img myImg" src="../sharedPics/'.$row['img'].'">
                </div>';}

              //check if is already liked poste
              $PID=$row['id'];
              $liked=$mysqli->query("SELECT username FROM likes WHERE PostID='$PID';");
              $liked=$liked->fetch_assoc();
              $liked=$liked['username'];

              if($liked==$username){//liked
                echo'
                <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
                <button class="btn mr-4" style="padding: 0px;height:34px;width:30px;" onclick="Like('.$PID.')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post'.$PID.'" style="width: 20px;color: #ff3333;"></i></button>';
              }else{
              echo'
                <div class="tweetEntry-action-list" style="line-height:24px;color: #b1bbc3;">
                <button class="btn mr-5" style="padding: 0px;height:34px;width:30px;" onclick="Like('.$PID.')"><i class="fa fa-heart d-inline-block pt-1 mr-1" id="post'.$PID.'" style="width: 20px;color: #C2C5CC;"></i></button>';
              }

              /// Ajax Syncing Likes with database into index.php
             
                  
              //printing nummber of likes if not null
              $likes=$mysqli->query("SELECT count(*) AS num FROM likes WHERE PostID='$PID';");
              $likes=$likes->fetch_assoc();
              $likes=$likes['num'];
                  if($likes==0){
                    echo'<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes'.$PID.'"></span>';
                  }else{
                    echo'<span class="text-danger d-inline-block ml-n4 mr-1" id="NumLikes'.$PID.'">'.$likes.'</span>';
                  }

              $comments=$mysqli->query("SELECT count(*) AS num FROM comments WHERE PostID='$PID';");
              $comments=$comments->fetch_assoc();
              $comments=$comments['num'];
              echo'
                  <i class="fa fa-comment d-inline-block pt-1 active" style="width: 80px;"></i>';
              if($comments>0){
                    echo'<span class="text-info d-inline-block ml-n4 mr-2">'.$comments.'</span>';
                  }
                  echo'
                  <i class="fa fa-share d-inline-block pt-1" style="width: 80px"></i>
                </div>
  
              </div>
            </div>
            ';

                    }else{
                      //posting the post for a non-owner shared :/


                    
                    
                    
                    
                    }










                  }
?>