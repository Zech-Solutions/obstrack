<section style="margin-top: 80px;">
<div class="container my-5">
    <h2 class="mb-4">Notifications</h2>
    <div class="list-group">
      <!-- Unread Notification -->
       <?php 
        foreach($notifications as $row){
       ?>
      <a href="#" class="list-group-item list-group-item-action d-flex align-items-start bg-light">
        <div class="ms-2 me-auto">
          <div class="fw-bold"><?=""?></div>
          <?=$row['description']?>
          <small class="text-muted d-block mt-1"><?=timeAgo($row['created_at'])?></small>
        </div>
      </a>
      <?php } ?>
    </div>
  </div>
</section>