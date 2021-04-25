<!-- headerを読み込む -->
<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('article_message') ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Articles</h1>
    </div>
    <div class="col-md-6">
      <a href="<?php echo URLROOT; ?>/articles/add" class="btn btn-primary float-right">
        <i class="fa fa-pencil"></i> 質問を投稿する
      </a>
    </div>
  </div>

  <!-- 記事をカードで表示していく -->
  <?php foreach($data['articles'] as $article) : ?>
    <div class="card card-body mb-3">
      <h4 class="card-title"><?php echo $article->title; ?></h4>
      <div class="bg-light p-2 mb-3">
        <?php echo $article->name; ?>さんによって投稿されました (<?php echo $article->articleCreated; ?>)
      </div>
      <a href="<?php echo URLROOT; ?>/articles/show/<?php echo $article->articleId?>" class="btn btn-dark">詳細を見る</a>
    </div>
  <?php endforeach; ?>

<!-- footerを読み込む -->
<?php require APPROOT . '/views/inc/footer.php'; ?>