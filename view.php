<?php
include("require/header.php");

?>


<?php if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}    
//main query________________________
$show="SELECT user.first_name, user.user_image_path, blog.blog_id , post.is_comment_allowed, post.created_at , user.last_name, post.post_title, post.featured_image, post.post_image_path, post.post_summary, post.post_description , blog.blog_title  FROM post , user,blog WHERE user.user_id =blog.user_id AND post.blog_id =blog.blog_id AND post.post_id = '".$post_id."'  ";
$result=excecute_query($show);
$rows=mysqli_fetch_assoc($result);
$blog_id =$rows['blog_id']; ?>

<div class="container-fluid mt-5" >
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex  align-items-center mt-5 ">
                    <a href="view_blog.php?blog_id=<?=$rows['blog_id']?>" class="text-decoration-none">
                        <h2 class="display-5"><?=$rows['blog_title']?></h2>
                    </a>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_approved'] == 'Approved' && $_SESSION['user']['is_active'] == 'Active'){?>
                    <div class="col-4 " style="margin-left: 50px" >
                        <?php
                            $follow =  "SELECT * FROM following_blog WHERE follower_id='" . $_SESSION['user']['user_id'] . "' AND blog_following_id = '" . $blog_id . "'";
                            $follow_result = excecute_query($follow);
                                if ($follow_result->num_rows > 0) {
                                $status = mysqli_fetch_assoc($follow_result);      
                            if ($status && $status['status'] == 'Followed') {
                                ?>
                                <a href="require/ajax_process.php?action=unfollow&blog_id=<?= $blog_id ?>&user_id=<?= $_SESSION['user']['user_id'] ?>&post=<?= $post_id ?>"><button type="button" class="btn btn-danger">Unfollow</button></a>
                            <?php
                            } elseif ($status && $status['status'] == 'Unfollowed') {
                                ?>
                                <a href="require/ajax_process.php?action=follow&blog_id=<?= $blog_id ?>&user_id=<?= $_SESSION['user']['user_id'] ?>&post=<?= $post_id ?>"><button type="button" class="btn btn-success">Follow</button></a>
                            <?php
                            } 
                       
                        } else {
                                ?>
                                <a href="require/ajax_process.php?action=newfollow&blog_id=<?= $blog_id ?>&user_id=<?= $_SESSION['user']['user_id'] ?>&post=<?= $post_id ?>"><button type="button" class="btn btn-success">Follow</button></a>
                          <?php  }} ?>
                            
                     </div>
                </div>
                
                <p class="text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                        <path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z"/>
                        <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z"/>
                    </svg> Category:  <?php $cat= "SELECT category.category_id, category.category_title FROM category,post,post_category WHERE post_category.post_id = post.post_id AND category.category_id =post_category.category_id AND post.post_id = '".$post_id."' "; 
                                $category_title=excecute_query($cat);
                                while ($catg=mysqli_fetch_assoc($category_title)) { ?> 
                      <a href="category.php?catg_id=<?=$catg['category_id']?>"> <?php echo $catg['category_title'].'&nbsp'.'&nbsp' ; } ?> </a>
                </p>
                <h3 class="fw-bold" style="font-family: sans-serif;"></h3>
                <h4 class="fw-bold display-5 "><?=$rows['post_title']?></h4>
            </div>
            <div class="col-12">
                <img src="<?="admin/".$rows['post_image_path']?>" class="img-fluid" alt="post_image">
            </div>
            <div class="col-12 mt-4">
                <h2>Summary</h2>
                <p><?=$rows['post_summary']?></p>
            </div>
            <div class="col-12 mt-4">
                <h4>Description</h4>
                <p><?=$rows['post_description']?></p>
                <p class="text-muted text-end">Publish on <?= date("d-M-Y",strtotime($rows['created_at'])) ?></p>
                 <div class="photo">
                      <span class="m-0 p-0">Author : <?=$rows['first_name']." ".$rows['last_name']?></span>
                    <img class="rounded-circle" width="40px" src="<?='ProfilePics/'.$rows['user_image_path']?>" alt="" class="img-fluid">
                 </div>
                  </div>
            </div>
            
            <div class="row">
                  <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_approved'] == 'Approved' && $_SESSION['user']['is_active'] == 'Active') {              
                    $att="SELECT post_atachment.post_attachment_title, post_atachment.post_attachment_path FROM post_atachment,post WHERE post.post_id=post_atachment.post_id AND post_atachment.is_active = 'Active' AND post_atachment.post_id = '".$post_id."'  ";
                         $attactment =excecute_query($att);
                         if ($attactment->num_rows > 0) { ?>
                       <div class="accordion accordion-flush" id="accordionFlushExample">
                        <?php   $count=0;
                        while ($attach=mysqli_fetch_assoc($attactment)) { 
                            $filePath = 'admin/' . $attach['post_attachment_path'];
                            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                            $icon = '';
                             if ($fileExtension == 'jpg' OR $fileExtension ==   'jpeg' OR $fileExtension ==  'png') {
                                $icon = "<img src='$filePath' alt='{$attach['post_attachment_title']}' style='width: 100%; max-width: 100px;'/>";
                            } elseif ($fileExtension == 'pdf') {
                                $icon = "<img src='icon/pdf.png' alt='PDF Icon' style='width: 20px; height: 20px;'/>";
                            } elseif ($fileExtension == 'xls' OR $fileExtension ==  'xlsx') {
                                $icon = "<img src='icon/excel.png' alt='Excel Icon' style='width: 20px; height: 20px;'/>";
                            } elseif ($fileExtension == 'doc' OR $fileExtension == 'docx') {
                                $icon = "<img src='icon/word.png' alt='Word Icon' style='width: 20px; height: 20px;'/>";
                            } else {
                                $icon = "<img src='icon/file.png' alt='File Icon' style='width: 20px; height: 20px;'/>";
                            }  ?>                                       
                          <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Attachment Item #<?= ++$count ?>
                              </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                               <div class="accordion-body">
                        <a download href="<?= $filePath ?>" > <?= $icon." ".$attach['post_attachment_title'] ?></a>
                         </div>
                          </div>
                         
                   <?php }?>
                 </div>
                   <?php }?>
                 </div>
                <form action="require/ajax_process.php" method="POST">
                    <div class="col-sm-12 mt-4">
                        <?php $comments="SELECT user.user_id ,user.first_name,user.last_name , user.user_image_path, post_comment.comment, post.is_comment_allowed, post_comment.created_at FROM post,user,post_comment
                         WHERE user.user_id = post_comment.user_id AND post.post_id=post_comment.post_id AND post_comment.is_active = 'Active'  
                        AND post.post_id = '".$post_id."'  ORDER BY post_comment.created_at DESC " ;                                   
                        $comm= excecute_query($comments); 
                        
                        if ($rows['is_comment_allowed'] ==  1) { ?>  
                        <div class="col-12">
                        <h5>Write a comment</h5>
                        <?php       
                        
                        if ($comm->num_rows > 0 ) {                  
                        
                        while ($show_comm=mysqli_fetch_assoc($comm)) {  
                         ?>      
                        
                        <p><img class="rounded-circle" width="40px" src="<?='ProfilePics/'.$show_comm['user_image_path']?>" alt="">  <?=$show_comm['first_name']." ".$show_comm['last_name']." "?> :  
                        <?=$show_comm['comment'] ?> <br>
                        <span class="text-muted"><?= date("h:j:s d-M-y", strtotime($show_comm['created_at'])) ?>  </span></p>
                        
                        </div>
                        <?php } ?>
                     
                 <?php } else { ?>
                        <h6>-</h6>
                 <?php } ?>
                  </div>
                    <div class="col-12 mt-3">
                        <label for="comment_message">Leave a comment</label>
                        <textarea class="form-control" id="comment_message" name="comment_message" placeholder="Enter your comment" cols="20" rows="5"></textarea>
                    </div>
                    <?php  $user_id = $_SESSION['user']['user_id']; ?>
                    <input type="hidden" name="post_id" value="<?=$post_id?>">
                    <input type="hidden" name="user_id" value="<?=$user_id?>">
                 
                    <div class="col-12 mt-3">
                        <input class="btn btn-dark" type="submit"  name="add_comment" value="Add Comment">   
                   </div>           
            </form>
                <?php   }else{ ?>
                        <h2>Comments Off</h2>
               <?php } }  ?>
           </div>
        </div>
    </div>
</div>
<?php
include("require/footer.php");
?>


