<!-- headerを読み込む -->
<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- 戻るボタン -->
<a href="<?php echo URLROOT; ?>/articles" class="btn btn-light"><i class="fa fa-backward"></i> 戻る</a>
<div class="card card-body bg-light mt-5">
  <h2>質問を投稿する</h2>
  <p>こちらのフォームから投稿を作成してください</p>

  <!-- タイトルと投稿内容の入力フォーム -->
  <form action="<?php echo URLROOT; ?>/articles/add" method="post">
    <div class="form-group">
      <label for="title">タイトル: <sup>*</sup></label>
      <input type="text" name ="title" class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
      <span class="invalid-feedback"><?php echo $data['title_err']?></span>
    </div>
    <div class="form-group">
    <label for="body">投稿内容: <sup>*</sup></label>
      <textarea name="body" class="form-control <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
      <span class="invalid-feedback"><?php echo $data['body_err']?></span>    
    </div>
    <button type="submit" class="btn btn-success">投稿する</button>
  </form>

</div>
<!-- footerを読み込む -->
<?php require APPROOT . '/views/inc/footer.php'; ?>