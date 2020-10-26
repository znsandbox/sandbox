<div class="container">

    <?php foreach ($links as $group): ?>
        <h2><?= $group['title'] ?></h2>
        <div class="list-group">
            <?php foreach ($group['items'] as $link): ?>
                <a href="http://<?= $link['url'] ?>" class="list-group-item list-group-item-action">
                    <?= $link['title'] ?: $link['url'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

</div>