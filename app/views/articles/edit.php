<!-- headerを読み込む -->
<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- 戻るボタン -->
<a href="" class="btn btn-light"><i class="fa fa-backward"></i> 戻る</a>
<div class="card card-body bg-light mt-5">
  <h2>投稿を編集する</h2>
  <p>こちらのフォームから投稿を編集してください</p>

  <!-- タイトルと投稿内容の入力フォーム -->
  <form action="<?php echo URLROOT; ?>/articles/edit/<?php echo $data['id']; ?>" method="post">
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
    <button type="submit" class="btn btn-success">更新する</button>
  </form>

</div>
<!-- footerを読み込む -->
<?php require APPROOT . '/views/inc/footer.php'; ?>