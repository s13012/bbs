<?php
require_once(dirname(__FILE__) . '/src/view/ThreadView.php');

if (isset($_GET['thread-id'])) {
    $threadId = $_GET['thread-id'];
    $threadView = new ThreadView($threadId);
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?php echo $threadView->getThread()->getTitle()?></title>

    <link rel="stylesheet" href="css/common.css">
</head>
<body>
<div class="box-container">
    <div class="box"><p id="bbs-back"><a href="index.php">■掲示板に戻る■</a></p></div>
    <div class="box"><p class="page"><a href="#">＜＜前の10件</a></p></div>
    <div class="box"><p class="page"><a href="#">次の10件＞＞</a></p></div>
</div>
<hr />
<h1 id="thread-title"><?php echo $threadView->getThread()->getTitle()?></h1>

<div id="bbs-response">
    <?php
    $responseList = $threadView->getResponseList();
    foreach ((array)$responseList as $response) {

        ?>
        <div class="box-container">
            <div class="box"><p class="comment-number"><?php echo $response->getCommentNumber() ?></p></div>
            <div class="box"><p class="name">名前:<?php echo $response->getName() ?></p></div>
            <div class="box"><p class="mail-address">[<?php echo $response->getMailAddress() ?>]</p></div>
            <div class="box"><p class="post-date">投稿日:<?php echo $response->getWriteDate() ?></p></div>
        </div>

        <p class="comment"><?php echo $response->getComment() ?></p>

        <?php
    }
    ?>
</div>

</body>
</html>
