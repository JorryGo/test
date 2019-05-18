<?php foreach ($posts as $post):?>

<div class="post">
    <span>
        <span class="date">[<?=date('d.m.Y H:i:s', strtotime($post['created_at']))?>]</span>
        <?=htmlspecialchars($post['name'])?> (<?=htmlspecialchars($post['email'])?>)
    </span>
    <br>
    <div class="text">
        <?=htmlspecialchars($post['text'])?>
    </div>

</div>


<?php endforeach; ?>
