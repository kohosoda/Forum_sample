<!-- headerを読み込む -->
<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- flashメッセージ -->
<?php flash('comment_message') ?>
<!-- 戻るボタン -->
<a href="<?php echo URLROOT; ?>/articles" class="btn btn-light"><i class="fa fa-backward"></i> 戻る</a>
<br>

<!-- 投稿内容の詳細 -->
<h1><?php echo $data['article']->title ?></h1>
<div class="bg-light p-2 mb-3">
  <?php echo $data['user']->name; ?>さんによって投稿されました (<?php echo $data['article']->created_at; ?>)
</div>
<div class="card card-body mb-3">
  <?php echo $data['article']->body; ?>
</div>

<!-- 編集ボタンと削除ボタン / 投稿をしたユーザーのみ実行できるようにする -->
<?php if ($data['article']->user_id === $_SESSION['user_id']) : ?>
  <a href="<?php echo URLROOT; ?>/articles/edit/<?php echo $data['article']->id; ?>" class="btn btn-dark">編集する</a>

  <form class="float-right" action="<?php echo URLROOT; ?>/articles/delete/<?php echo $data['article']->id; ?>" method="post">
    <button type="submit" class="btn btn-danger">削除する</button>
  </form>
<?php endif; ?>
<hr>

<!-- コメント機能 -->
<div class="row mb-3">
  <div class="col-md-6">
    <h4>Comment</h4>
  </div>
  <div class="col-md-6">
    <a href="<?php echo URLROOT; ?>/comments/add/<?php echo $data['article']->id; ?>" class="btn btn-primary float-right">
      <i class="fa fa-pencil"></i> コメントする
    </a>
  </div>
</div>

<!-- コメントを表示していく -->
<?php foreach ($data['comments'] as $comment) : ?>
  <div class="card mb-3">
    <div class="card-heaer">
      <div class="bg-light p-1 mb-1">
        <?php echo $comment->userName; ?>さんの投稿 (<?php echo $comment->commentCreated; ?>)
      </div>
    </div>
    <div class="card-body">
      <div class="card-text">
        <?php echo $comment->body; ?>
      </div>
      <!-- コメントの編集/削除ボタン ※投稿ユーザーのみに表示 -->
      <div class="row mt-2 justify-content-end">
        <?php if ($comment->user_id === $_SESSION['user_id']) : ?>
          <a href="<?php echo URLROOT; ?>/comments/edit/<?php echo $comment->commentId; ?>" class="btn btn-dark mr-1">編集する</a>

          <form action="<?php echo URLROOT; ?>/comments/delete/<?php echo $comment->commentId; ?>" method="post">
            <button type=" submit" class="btn btn-danger">削除する</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>
<!-- footerを読み込む -->
<?php require APPROOT . '/views/inc/footer.php'; ?>