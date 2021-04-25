<!-- headerを読み込む -->
<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- 戻るボタン -->
<a href="<?php echo URLROOT; ?>/articles/show/<?php echo $data['article']->id; ?>" class="btn btn-light"><i class="fa fa-backward"></i> 戻る</a>
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
</div>

<!-- コメント投稿機能 -->
<div class="card card-body bg-light">
  <form action="<?php echo URLROOT; ?>/comments/edit/<?php echo $data['id']; ?>" method="post">
    <div class="form-group">
      <label for="body">コメント: <sup>*</sup></label>
      <textarea name="body" class="form-control <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
      <span class="invalid-feedback"><?php echo $data['body_err'] ?></span>
    </div>
    <button type="submit" class="btn btn-success">更新する</button>
  </form>
</div>

<!-- footerを読み込む -->
<?php require APPROOT . '/views/inc/footer.php'; ?>