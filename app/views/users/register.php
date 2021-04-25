<!-- headerを読み込む -->
<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="card card-body bg-light mt-5">
        <h2>アカウントを登録する</h2>
        <p>こちらのフォームに入力をお願いします</p>
        <form action="<?php echo URLROOT; ?>/users/register" method="post">

          <div class="form-group">
            <label for="name">お名前：<sup>*</sup></label>
            <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="email">メールアドレス：<sup>*</sup></label>
            <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="password">パスワード：<sup>*</sup></label>
            <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="confirm_password">パスワード(確認用)：<sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
          </div>

          <div class="row">
            <div class="col-md-6">
              <input type="submit" value="登録する" class="btn btn-success btn-block">
            </div>
            <div class="col-md-6">
              <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">登録済みの方はこちら</a>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
<!-- footerを読み込む -->
<?php require APPROOT . '/views/inc/footer.php'; ?>