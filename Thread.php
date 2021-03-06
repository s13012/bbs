<?php
require_once(dirname(__FILE__) . '/src/view/ThreadView.php');

$threadView = null;
if (isset($_GET['thread-id'])) {
    $threadId = $_GET['thread-id'];
    $threadView = new ThreadView($threadId);
}

if (!is_null($threadView) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $threadView->postResponse($_POST);

    //redirect
    header("Location: " . $_SERVER['SCRIPT_NAME'] . "?thread-id=" . $threadView->getThread()->getId());
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
    <div class="box">
        <p class="page">
            <?php echo $threadView->getPreviousPage("＜＜前の{$threadView->getLimitDisplaySize()}件")?>
        </p>
    </div>
    <div class="box">
        <p class="page">
            <?php echo $threadView->getNextPage("次の{$threadView->getLimitDisplaySize()}件＞＞")?>
        </p>
    </div>
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
            <div class="box"><p class="post-date">投稿日:<?php echo $response->getCreationDate() ?></p></div>
        </div>

        <p class="comment"><?php echo $response->getComment() ?></p>

        <?php
    }
    ?>
</div>

<hr />
<div id="post-response">
    <form action="Thread.php?thread-id=<?php echo $threadView->getThread()->getId() ?>" method="POST">
        <div class="box-container">
            <div class="box">
                <p>
                    名前: <input type="text" name="name">
                </p>
            </div>
            <div class="box">
                <p>
                    E-mail: <input type="email" name="mail_address" size="30">
                </p>
            </div>
        </div>

        <p>
            内容: <br /><textarea name="comment" cols="70" rows="10" required></textarea>
        </p>
        <br />
        <p>
            <button type="submit">書き込む</button>
        </p>
    </form>
</div>

</body>
</html>
