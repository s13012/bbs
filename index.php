<?php
require_once('src/view/ThreadListView.php');
$threadListView = new ThreadListView();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>JUPIT BBS</title>

    <link rel="stylesheet" href="css/common.css">
</head>
<body>
<h1 class="title">JUPIT BBS</h1>

<h2>スレッド一覧</h2>
<div id="thread-list">
    <table>
        <thead>
        <tr>
            <th>番号</th>
            <th>タイトル</th>
            <th>レス</th>
            <th>作成日</th>
        </tr>
        </thead>
        <tbody>
        <!-- スレッド一覧 -->
        <?php echo $threadListView->showThreadList(); ?>
        </tbody>
    </table>

    <div class="box-container">
        <div class="box">
            <p class="page">
                <?php echo $threadListView->getPreviousPage("＜＜前の{$threadListView->getLimitDisplaySize()}件")?>
            </p>
        </div>
        <div class="box">
            <p class="page">
                <?php echo $threadListView->getNextPage("次の{$threadListView->getLimitDisplaySize()}件＞＞")?>
            </p>
        </div>
    </div>
</div>

<hr />

<h2>スレッド作成</h2>
<div id="create-thread">
    <form action="CreateThread.php" method="POST">
        <p>
            タイトル: <input type="text" name="title" size="50" required>
        </p>

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
            <button type="submit" name="insert_thread">新規スレッド作成</button>
        </p>
    </form>
</div>

</body>
</html>